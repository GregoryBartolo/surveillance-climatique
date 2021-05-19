// Load the http module to create an http server and requets to request arduino URL
var http = require('http');
var request = require('request');
const sqlite3 = require('sqlite3').verbose();
const dateformat = require('dateformat');

var httpServer = http.createServer(function (req, resp) {
	resp.writeHead(200, {'Access-Control-Allow-Origin':'*','Content-Type': 'text/plain'});
});

function requestArduino() {
	request('http://169.254.2.73/', { json: true }, (err, res, body) => {
		if (err) {
			return console.log(err);
		}
		
		data = body.split(",");
		
		var id = parseInt(data[1]);
		var temperature = parseFloat(data[2]);
		var humidite = parseFloat(data[3]);
		var batterie = parseFloat(data[4]);
		var status = data[5];
		var dateTime = new Date();
		dateTime = String(dateformat(dateTime, 'dd/mm/yyyy HH:MM:ss'));
		
		/*console.log(id);
		console.log(temperature);
		console.log(humidite);
		console.log(batterie);
		console.log(status);
		console.log(dateTime);*/

		let db = new sqlite3.Database('../surveillance_climatique.db')
		
		db.get('SELECT limit_mini_temperature, limit_maxi_temperature, limit_mini_humidity, limit_maxi_humidity FROM capteurs WHERE id_capteur = ?', [id], (err, result) => {
			if (err) {
				return console.error(err.message);
			}
			
			var limit_mini_temperature = result.limit_mini_temperature;
			var limit_maxi_temperature = result.limit_maxi_temperature;
			var limit_mini_humidity = result.limit_mini_humidity;
			var limit_maxi_humidity = result.limit_maxi_humidity;
			
			if (temperature < limit_mini_temperature || temperature > limit_maxi_temperature || humidite < limit_mini_humidity || humidite > limit_maxi_humidity) {
				db.run('UPDATE capteurs SET date_last_error = ? WHERE id_capteur = ?', [dateTime, id], function(err) {
					if (err) {
						return console.log(err);
					}
					console.log('Row updated : ${this.changes}');
				});
			}
		});
		
		
		db.run('INSERT INTO mesures(id_capteur, date, temperature, humidity, battery, capteur_status) VALUES(?,?,?,?,?,?)', [id, dateTime, temperature, humidite, batterie, status], function(err) {
			if (err) {
				return console.log(err);
			}
			console.log('A row has been inserted with rowid ${this.lastID}');
		});
		
		db.close();
	})
}
setInterval(requestArduino, 5000); //time in ms..

httpServer.listen(8888)

console.log('Server running on port :8888 ...');
