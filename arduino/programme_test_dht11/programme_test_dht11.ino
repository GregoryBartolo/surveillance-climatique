#include <dht11.h>

#define DHT11PIN 5 // broche DATA -> broche 5
 
dht11 DHT11;
 
void setup()
{
  pinMode(10, OUTPUT);
  Serial.begin(9600);
  while (!Serial) {
    // wait for serial port to connect. Needed for native USB (LEONARDO)
  }
  Serial.println("DHT11 programme d'essai ");
  Serial.print("LIBRARY VERSION: ");
  Serial.println(DHT11LIB_VERSION);
  Serial.println();
}
 
void loop()
{
  DHT11.read(DHT11PIN);
  
  float dht11_humidity = DHT11.humidity;
  float dht11_temp = DHT11.temperature;
 
  Serial.print("Humidite (%): ");
  Serial.print(dht11_humidity, 2);
  Serial.print("\t");
  Serial.print("Temperature (Celsius): ");
  Serial.println(dht11_temp, 2);
  
  delay(1000);
  
  if (dht11_humidity > 50) {
    digitalWrite(10, HIGH);
  }
  else {
    digitalWrite(10, LOW);
  }
}
