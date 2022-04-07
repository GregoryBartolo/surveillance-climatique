#include <SPI.h>
#include <Ethernet.h>
#include <SD.h>
#include <Wire.h>
#include <HIH61xx.h>
#include <AsyncDelay.h>

// Init
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

// Action at the start
void setup() {    
    //Serial.begin(115200);
    Wire.begin();

    // Init sensor
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
    
    // Init connection 
    Ethernet.init(10);
    Ethernet.begin(mac, ip);

    // Check for Ethernet hardware present
    if (Ethernet.hardwareStatus() == EthernetNoHardware) {
        //Serial.println("Ethernet shield was not found.  Sorry, can't run without hardware. :(");
        while (true) {
            delay(1); // do nothing, no point running without Ethernet hardware
        }
    }

    // start the server
    server.begin();
    //Serial.print("Start at ");
    //Serial.println(Ethernet.localIP());

}

// Action during the Arduino lifecyle( client connection, data stored in sd card, data send to the client to generate the graph, ect.)
void loop() {
    hih.start();
    hih.process();
    
    // Check if ethernet is connected
    // If is not -> writing data in SD card
    if (Ethernet.linkStatus() == LinkOFF) {
        //Serial.print("Link is OFF");

        // Check if SD card is ok
        //if (!SD.begin(4)) {
            //Serial.println("init failed..");
        //}

        // Open / Write to SD card
        //Serial.println("Creating file in SD card");
        file = SD.open("test.txt", FILE_WRITE);
        //Check if there are already a file to write inside 
        if (file) {
            file.print("FLUSH");
            while(Ethernet.linkStatus() == LinkOFF)
            {
                if ((millis()-t)>900000) // time in ms to wait before writing inside the file
                {
                    // Read sensor data
                    hih.read();
                    float temp = hih.getAmbientTemp() / 100.0;
                    float hum = hih.getRelHumidity() / 100.0;
                    
                    //Serial.println("File open and writing inside");
                    //Serial.println(temp);
                    //Serial.println(hum);
                    file.print(temp); //print the data to file
                    file.print("-"); //print the data to file
                    file.println(hum); //print the data to file
                    
                    t = millis();
                }
            }
            file.close();
        }
        //else {
            //Serial.print("Save on sd card failed !  : ");
            //Serial.println(file);
        //}
    } else { // If ethernet is connected -> send data to client incoming
        // listen for incoming clients
        EthernetClient client = server.available();
        //Client init
        if (client) {
            //Serial.println("Connection established with Raspberry Pi");
            String connection_method;
            
            // HTTP request ends with a blank line
            boolean currentLineIsBlank = true;
            // While the client requests data
            while (client.connected()) {
              if (client.available()) {
                  char c = client.read();
                  connection_method.concat(c);
  
                  // If the current line is blank and the next character is a new line character
                  if (c == '\n' && currentLineIsBlank) {
                    //Serial.print(connection_method);
                    int ping = connection_method.indexOf("ping");
                    if (ping < 0) {
                  
                      // Send a standard HTTP response header at the start of data
                      client.println("HTTP/1.1 200 OK");
                      client.println("Content-Type: text/html");
                      client.println("Connection: close");  // the connection will be closed after completion of the response
                      client.println("Refresh: 5");  // refresh the page automatically every 5 sec
                      client.println();
                      client.println("<!DOCTYPE HTML>");
                      client.println("<html>");
    
                      // Check if SD card is ok
                      //if (!SD.begin(4)) {
                          //Serial.println("init failed..");
                      //}
//                      else {
//                          Serial.println("SD card is OK");
//                      }
    
                      // Try to open sd card
                      file = SD.open("test.txt");
                      //if (!file) {
                          //Serial.println("No data in SD Card.");
                      //}
                      // If SD card exist : read data inside
                      if (file) {
                          //Serial.println("Reading file..");
                          client.println(",");
                          while (file.available()) {
                            buffer = file.readStringUntil('\n');
                            client.println(buffer);
                          }
                          file.close();
      
                          SD.remove("test.txt");
                      }
    
                      // Read sensor data
                      hih.read();
                      float temp = hih.getAmbientTemp() / 100.0;
                      float hum = hih.getRelHumidity() / 100.0;
                      // Print them on arduino serial
//                      Serial.print("Temperature : ");
//                      Serial.println(temp);
//                      Serial.print("Humidite : ");
//                      Serial.println(hum);
    
                      // Send data to client
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
                    else {
                      //Serial.println("Ping received");
                      client.println("HTTP/1.1 200 OK");
                      client.println("Content-Type: text/html");
                      client.println("Connection: close");  // the connection will be closed after completion of the response
                      client.println("Refresh: 5");  // refresh the page automatically every 5 sec
                      client.println();
                      client.println("<!DOCTYPE HTML>");
                      client.println("<html>");
                      client.stop();
                    }
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
            
            // Give the web browser time to receive the data
            // And close the client connection
            delay(1);
            client.stop();
        }
    }
    // Check if sampling interval is over
    delay(1000);
}
