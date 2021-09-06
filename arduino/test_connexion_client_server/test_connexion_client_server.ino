#include <Ethernet.h>
#include <SPI.h>

byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
  
IPAddress ip = ( 192, 168, 43, 172 );

IPAddress server = (64,233,187, 99); // Google

  
EthernetClient client;


void setup()
{
  Serial.begin(9600);
  delay(3000);
  Serial.println("after 1er delay");
  
  Ethernet.begin(mac, ip);//, ip, dns, gateway
  

  delay(6000);
  Serial.println("after 2nd delay");

  Serial.println("connecting...");
  
  

  if (client.connect(server, 80)) {
    Serial.println("connected");
    client.println("GET /search?q=arduino HTTP/1.0");
    client.println();
  } else {
    Serial.println("connection failed");
  }
}

void loop()
{
  if (client.connect(server, 80)) {
    Serial.println("connected");
    client.println("GET /search?q=arduino HTTP/1.0");
    client.println();
  } else {
    Serial.println("connection failed");
  }
  
  if (client.available()) {
    char c = client.read();
    Serial.print(c);
  }

  if (!client.connected()) {
    Serial.println();
    Serial.println("disconnecting.");
    client.stop();
    for(;;)
      ;
  }
}
