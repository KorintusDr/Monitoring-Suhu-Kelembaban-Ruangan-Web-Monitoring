#include "DHT.h"
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>

#define DHTPIN 5
#define DHTTYPE DHT11

DHT dht(DHTPIN, DHTTYPE);

const char* ssid = "samping";
const char* pass = "22223333";

const char* ip_server = "192.168.11.241";

void setup() {
  Serial.begin(115200);
  dht.begin();

  WiFi.begin(ssid, pass);

  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(500);
  }

  Serial.println("\nWifi berhasil konek");
}

void loop() {
  float suhu = dht.readTemperature();
  float kelembaban = dht.readHumidity();

  // Periksa apakah pembacaan valid
  if (isnan(suhu) || isnan(kelembaban)) {
    Serial.println("Gagal membaca data dari sensor DHT");
    delay(2000);
    return;
  }

  Serial.println("Suhu: " + String(suhu));
  Serial.println("Kelembaban: " + String(kelembaban));

  WiFiClient client; // Objek WiFiClient
  HTTPClient http;

  String Link = "http://" + String(ip_server) + "/monitoringsk/Monitoring/kirimdata/" + String(suhu) + "/" + String(kelembaban);

  http.begin(client, Link);

  int httpCode = http.GET();
  if (httpCode > 0) {
    Serial.println("Data berhasil dikirim. HTTP Response: " + String(httpCode));
  } else {
    Serial.println("Gagal mengirim data. HTTP Error: " + String(httpCode));
  }

  http.end();

  delay(1000);
}
