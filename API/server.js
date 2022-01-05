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
		
		if (data.length == 7) {
			var id = parseInt(data[1]);
			var temperature = parseFloat(data[2]);
			var humidite = parseFloat(data[3]);
			var batterie = parseFloat(data[4]);
			var status = data[5];
		} else if (data.length == 8) {
			var old_data = data[1];
			var id = parseInt(data[2]);
			var temperature = parseFloat(data[3]);
			var humidite = parseFloat(data[4]);
			var batterie = parseFloat(data[5]);
			var status = data[6];
		} else {
			console.log("Vérifier les données reçues !")
		}
		var dateTime = new Date();
		dateTime = String(dateformat(dateTime, 'dd/mm/yyyy HH:MM:ss'));
		
		// format to get old data
		/*old_data = old_data.split("FLUSH")[1];
		old_data = old_data.split("\r\r\n");
		old_data[0] = old_data[0].slice(2);
		old_data.pop();
		old_data = old_data.reverse();*/
		
		/*console.log(data);
		console.log("------------");
		console.log(old_data);		
		console.log(id);
		console.log(temperature);
		console.log(humidite);
		console.log(batterie);
		console.log(status);
		console.log(dateTime);*/

		let db = new sqlite3.Database('../surveillance_climatique.db')
		
		/*db.get('SELECT date FROM mesures WHERE id_capteur = ? AND id = (SELECT MAX(id) FROM mesures)', [id], (err, result) => {
			if (err) {
				return console.error(err.message);
			}
			
			var date = new Date(result.date + "Z");
			console.log(date);
			
			old_data.forEach(function(item) {
				item = item.split("-");
				new_date = date.setSeconds(date.getSeconds() + 5)
				console.log(item);
				console.log(new Date(new_date));
			});
		});*/
		
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
setInterval(requestArduino, 300000); //time in ms..

httpServer.listen(8888)

console.log('Server running on port :8888 ...');
