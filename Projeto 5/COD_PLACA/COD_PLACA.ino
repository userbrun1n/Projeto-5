#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include <LiquidCrystal_I2C.h>

const char* ssid = "A55";
const char* password = "07101114";
const char* serverName = "http://192.168.242.102/api/get_dht_data.php";

LiquidCrystal_I2C lcd(0x27, 16, 2); // Endereço I2C pode variar

void setup() {
  Serial.begin(115200);
  lcd.init();
  lcd.backlight();

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("WiFi conectado!");
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverName);
    int httpCode = http.GET();

    if (httpCode == 200) {
      String payload = http.getString();
      Serial.println(payload);

      StaticJsonDocument<200> doc;
      DeserializationError error = deserializeJson(doc, payload);

      if (!error) {
        float temperatura = doc["temperatura"];
        float umidade = doc["umidade"];

        lcd.clear();
        lcd.setCursor(0, 0);
        lcd.print("Temp: ");
        lcd.print(temperatura, 1);
        lcd.print(" C");

        lcd.setCursor(0, 1);
        lcd.print("Umid: ");
        lcd.print(umidade, 1);
        lcd.print(" %");
      } else {
        lcd.clear();
        lcd.setCursor(0, 0);
        lcd.print("Erro JSON");
      }
    } else {
      lcd.clear();
      lcd.setCursor(0, 0);
      lcd.print("Erro HTTP");
    }

    http.end();
  }

  delay(5000); // Atualiza a cada 5 segundos
}
