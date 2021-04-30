// Load the http module to create an http server and requets to request arduino URL
var http = require('http');
var request = require('request');
const sqlite3 = require('sqlite3').verbose();

var httpServer = http.createServer(function (req, resp) {
	resp.writeHead(200, {'Access-Control-Allow-Origin':'*','Content-Type': 'text/plain'});
});

function requestArduino() {
	request('http://169.254.2.10/', { json: true }, (err, res, body) => {
		if (err) {
			return console.log(err);
		}
		//console.log(body);
		let db = new sqlite3.Database('../surveillance_climatique.db')
		db.run('INSERT INTO mesures(id_capteur, date, temperature, humidity, battery, capteur_status) VALUES(?,?,?,?,?,?)', [1,'2021/16/04-16:42:225', 24.5, 82.2, 70, '1100101'], function(err) {
			if (err) {
				return console.log(err);
			}
			console.log('A row has been inserted with rowid ${this.lastID}');
		});
		db.close();
	})
}
setInterval(requestArduino, 2000); //time in ms..

httpServer.listen(8888)

console.log('Server running on port :8888 ...');
