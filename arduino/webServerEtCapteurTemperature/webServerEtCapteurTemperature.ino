#include <AsyncDelay.h>

#include <SPI.h>
#include <Ethernet.h>

#include <Wire.h>
#include <HIH61xx.h>
#include <AsyncDelay.h>

byte mac[] = {
  0xA8, 0x61, 0x0A, 0xAE, 0x66, 0x89
};
IPAddress ip(169, 254, 2, 73);

const int BATTERIEPIN = A0;

const float tensionMin = 3.2;
const float tensionMax = 4.2;

HIH61xx<TwoWire> hih(Wire);

AsyncDelay samplingInterval;


EthernetServer server(80);


void powerUpErrorHandler(HIH61xx<TwoWire>& hih)
{
  Serial.println("Error powering up HIH61xx device");
}


void readErrorHandler(HIH61xx<TwoWire>& hih)
{
  Serial.println("Error reading from HIH61xx device");
}

void setup() {

  
    Serial.begin(115200);
    Serial.print("9600");
  


  Wire.begin();

  // Set the handlers *before* calling initialise() in case something goes wrong
  hih.setPowerUpErrorHandler(powerUpErrorHandler);
  hih.setReadErrorHandler(readErrorHandler);
  hih.initialise();
  samplingInterval.start(3000, AsyncDelay::MILLIS);
  
  
  
  // Open serial communications and wait for port to open:
  
  while (!Serial) {
    ; // wait for serial port to connect. Needed for native USB port only
  }
  Serial.println("Ethernet WebServer Example");

  // start the Ethernet connection and the server:
  Ethernet.begin(mac, ip);

  // Check for Ethernet hardware present
  if (Ethernet.hardwareStatus() == EthernetNoHardware) {
    Serial.println("Ethernet shield was not found.  Sorry, can't run without hardware. :(");
    while (true) {
      delay(1); // do nothing, no point running without Ethernet hardware
    }
  }
  if (Ethernet.linkStatus() == LinkOFF) {
    Serial.println("Ethernet cable is not connected.");
  }

  // start the server
  server.begin();
  Serial.print("server is at ");
  Serial.println(Ethernet.localIP());

  hih.read();
   Serial.print(hih.getRelHumidity() / 100.0);
  Serial.println(" %");
  Serial.print("Ambient temperature: ");
  Serial.print(hih.getAmbientTemp() / 100.0);
  Serial.println(" deg C");
  Serial.print("Status: ");
  Serial.println(hih.getStatus());

  
  
}

// Calcul du pourcentage de la batterie 
// branchement de la batterie suivre tuto : https://www.youtube.com/watch?v=-vZk2FVrSkI
int getBatterie()
{
  float batterie = analogRead(BATTERIEPIN);

  int minValue = (1023 * tensionMin) / 5;
  int maxValue = (1023 * tensionMax) / 5;

  batterie = ((batterie - minValue) / (maxValue - minValue)) * 100;

  if(batterie > 100)
    batterie = 100;

  else if (batterie < 0)
    batterie = 0;

  return batterie;
}

int compteur = 0;

void loop() {

  
  int batterie = getBatterie();
  batterie = 30;
  hih.read();
  
  // listen for incoming clients
  EthernetClient client = server.available();
  if (client) {
    Serial.println("new client");
    
          
    // an http request ends with a blank line
    boolean currentLineIsBlank = true;
    while (client.connected()) {
      if (client.available()) {
        char c = client.read();
        Serial.write(c);
        // if you've gotten to the end of the line (received a newline
        // character) and the line is blank, the http request has ended,
        // so you can send a reply
        if (c == '\n' && currentLineIsBlank) {
          // send a standard http response header
          client.println("HTTP/1.1 200 OK");
          client.println("Content-Type: text/html");
          client.println("Connection: close");  // the connection will be closed after completion of the response
          client.println("Refresh: 5");  // refresh the page automatically every 5 sec
          client.println();
          client.println("<!DOCTYPE HTML>");
          client.println("<html>");
          // output the value of each analog input pin
          /*
          for (int analogChannel = 0; analogChannel < 6; analogChannel++) {
            int sensorReading = analogRead(analogChannel);
            client.print("analog input ");
            client.print(analogChannel);
            client.print(" is ");
            client.print(sensorReading);
            client.println("<br />");
          }
          */
          hih.read();
          float temp = hih.getAmbientTemp() / 100.0;
          float hum = hih.getRelHumidity() / 100.0;
          //String tempstr = String(temp);
          Serial.print("Relative humidity: ");
          Serial.print(hih.getRelHumidity() / 100.0);
          Serial.println(" %");
          Serial.print("Ambient temperature: ");
          Serial.print(hih.getAmbientTemp() / 100.0);
          Serial.println(" deg C");
          Serial.print("Status: ");
          Serial.println(hih.getStatus());

          client.print(",");
          //client.print("id");
          client.print("1");
          client.print(",");
          //client.write("temperature : ");
          //client.print("temperature");
          client.print(temp);
          client.print(",");
          //client.write("humidite : ");
          //client.print("hum");
          client.print(hum);
          client.print(",");
          //client.println("batterie : ");
          //client.print("batterie");
          client.print(batterie);
          client.print(",");

          //client.print("status");
          client.print("010101");
          
          client.print(",");
          
            
          client.println("</html>");
          break;
        }
        if (c == '\n') {
          // you're starting a new line
          currentLineIsBlank = true;
        } else if (c != '\r') {
          // you've gotten a character on the current line
          currentLineIsBlank = false;
        }
      }
      
    }
    
    // give the web browser time to receive the data
    delay(1);
    compteur = compteur + 1;
    // close the connection:
    client.stop();
    Serial.println("client disconnected");
    compteur = 0;
  }
  else
  {
    if(compteur > 3000)
    {
      Serial.print("error");
      // lien de programmation pour sd card https://www.carnetdumaker.net/articles/lire-et-ecrire-des-donnees-sur-une-carte-sd-avec-une-carte-arduino-genuino/
    }
  }
  delay(1000);
  // Serial.println(compteur);
  // compteur = compteur + 1;
}
