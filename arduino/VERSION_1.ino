#include <SPI.h>
#include <Ethernet.h>
#include <SD.h>
#include <Wire.h>
#include <HIH61xx.h>
#include <AsyncDelay.h>

float t = millis();
File file;
String buffer;

EthernetServer server(80);

HIH61xx<TwoWire> hih(Wire);
AsyncDelay samplingInterval;

void powerUpErrorHandler(HIH61xx<TwoWire>& hih)
{ Serial.println("Error powering up HIH61xx device"); }


void readErrorHandler(HIH61xx<TwoWire>& hih)
{ Serial.println("Error reading from HIH61xx device"); }

void setup() {    
    Serial.begin(115200);
    Wire.begin();

    //hih.setPowerUpErrorHandler(powerUpErrorHandler);
    //hih.setReadErrorHandler(readErrorHandler);
    hih.initialise();
    samplingInterval.start(3000, AsyncDelay::MILLIS);
      
    // Open serial communications and wait for port to open:
    while (!Serial) {
      ; // wait for serial port to connect. Needed for native USB port only
    }
  
    IPAddress ip(169, 254, 2, 73);
    byte mac[] = {
      0xA8, 0x61, 0x0A, 0xAE, 0x66, 0x89
    };
    Ethernet.init(10);
    Ethernet.begin(mac, ip);
  
    // Check for Ethernet hardware present
    if (Ethernet.hardwareStatus() == EthernetNoHardware) {
      Serial.println("Ethernet shield was not found.  Sorry, can't run without hardware. :(");
      while (true) {
        delay(1); // do nothing, no point running without Ethernet hardware
      }
    }

    // start the server
    server.begin();
    Serial.print("Start at ");
    Serial.println(Ethernet.localIP());
 
}


void loop() {
  hih.start();
  
  hih.process();
  // Check if ethernet is connected
  // If is not -> writing data in SD card
  if (Ethernet.linkStatus() == LinkOFF) {
      if (!SD.begin(4)) {
          Serial.println("init failed..");
      }
      file = SD.open("test.txt", FILE_WRITE);

      if (file) {
          file.print("FLUSH");
          while(Ethernet.linkStatus() == LinkOFF)
          {
            if ((millis()-t)>900000)
            {
                hih.read();
                float temp = hih.getAmbientTemp() / 100.0;
                float hum = hih.getRelHumidity() / 100.0;
  
                Serial.println("File open and writing inside");
                Serial.println(temp);
                Serial.println(hum);
                file.print(temp); //print the data to file
                file.print("-"); //print the data to file
                file.println(hum); //print the data to file
                  
                t = millis();
             }
          }
          file.close();
      } else {
        Serial.print("Save on sd card failed !  : ");
        Serial.println(file);
      }
  } else { // If ethernet is connected -> send data to client incoming
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
            if (c == '\n' && currentLineIsBlank) {
              // send a standard http response header
              client.println("HTTP/1.1 200 OK");
              client.println("Content-Type: text/html");
              client.println("Connection: close");  // the connection will be closed after completion of the response
              client.println("Refresh: 5");  // refresh the page automatically every 5 sec
              client.println();
              client.println("<!DOCTYPE HTML>");
              client.println("<html>");

              //check if SD card is ok
              if (!SD.begin(4)) {
                Serial.println("init failed..");
              }
              // open sd card
              file = SD.open("test.txt");
              if (!file) {
                Serial.println("The text file cannot be opened or doesn't exist");
              }
              // read data of sd card
              if (file) {
                Serial.println("Reading file..");
                client.println(",");
                while (file.available()) {
                  buffer = file.readStringUntil('\n');
                  client.println(buffer);
                }
                file.close();

                SD.remove("test.txt");
              }

              // read sensor data
              hih.read();
              float temp = hih.getAmbientTemp() / 100.0;
              float hum = hih.getRelHumidity() / 100.0;
              Serial.print("Temperature : ");
              Serial.println(temp);
              Serial.print("Humidite : ");
              Serial.println(hum);

              client.print(",");
              client.print("1"); // id capteur
              client.print(",");
              client.print(temp); // temperature mesurée
              client.print(",");
              client.print(hum); // humidité mesurée
              client.print(",");
              client.print("30"); // pourcentage de la batterie
              client.print(",");
              client.print("010101"); // statut du capteur
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
        client.stop();
      }
  }

  delay(1000);
}
