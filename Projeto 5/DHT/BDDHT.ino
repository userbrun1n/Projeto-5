#include <WiFi.h>
#include <HTTPClient.h>
#include <DHT.h>

#define DHTPIN 5
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);

const int ledPin = 26; // GPIO onde o LED está conectado
const float LIMITE_UMIDADE = 70.0; // Umidade mínima para acionar o LED

// Credenciais da rede Wi-Fi
const char* ssid = "A55";
const char* password = "07101114";

// Endereço do script PHP no servidor local
const char* serverName = "http://192.168.242.102/api/dht_logger.php";

void setup() {
  dht.begin();
  pinMode(ledPin, OUTPUT);
  digitalWrite(ledPin, LOW);

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
  }
}

void loop() {
  float temperatura = dht.readTemperature();
  float umidade = dht.readHumidity();

  if (!isnan(temperatura) && !isnan(umidade)) {
    // Controle do LED
    if (umidade >= LIMITE_UMIDADE) {
      digitalWrite(ledPin, HIGH);
    } else {
      digitalWrite(ledPin, LOW);
    }

    // Envio dos dados para o banco de dados
    if (WiFi.status() == WL_CONNECTED) {
      HTTPClient http;
      http.begin(serverName);
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");

      String dados = "temperatura=" + String(temperatura) + "&umidade=" + String(umidade);
      http.POST(dados);
      http.end();
    }
  }

  delay(2000);
}
