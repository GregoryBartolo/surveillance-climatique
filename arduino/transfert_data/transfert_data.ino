#include <SPI.h>
#include <Ethernet.h>

// 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED
byte mac[] = {
  0xA8, 0x61, 0x04, 0xAE, 0x66, 0x89
};


IPAddress ip(192, 168, 1, 147);
EthernetServer server(80);

void setup() 
{
  Ethernet.begin(mac, ip); // sans serveur avec juste adresse mac -> OK
  
  server.begin(); // demarrage du server fait planter
  Serial.begin (9600);
  
  //Serial.print(Ethernet.localIP());
  Serial.print("VVVVVV");
}

void loop( ) 
{
  Serial.print("VVVVVV");
//  Serial.print("flag");
//  float mavar = 500;
//  //EthernetClient client = server.available();
//  
//  if (client) 
//  {
//    boolean currentLineIsBlank = true;
//    while (client.connected ( ) ) 
//    {
//      if (client.available ( ) ) 
//      {
//        //char character = client.read ( );
//        
//        if (character == '\n' && currentLineIsBlank) 
//        {
////          client.println ("HTTP/1.1 200 OK");
////          client.println ("Content-Type: text/html");
////          client.println ("Connection: close");
////          client.println ("Refresh: 5");
////          client.println ( );
////          client.println ("<!DOCTYPE HTML>");
////          client.println ("<html>");
////          client.print ("<Title>Arduino Ethernet Webserver </Title>");
////          client.print ("<h1>Arduino Ethernet Shield Webserver </h1>");
////          client.print ("<h4>Mon nombre: ");
////          client.print (mavar);
////          client.println ("<br />");
////          client.println ("</html>");
//          break;
//        }
//
//        if ( character == '\n') 
//        {
//          currentLineIsBlank = true;
//        } 
//        else if (character != '\r') 
//        {
//          currentLineIsBlank = false;
//        }
//      }
//    }
//    delay(1);
//    //client.stop();
//  }
}

