#include <ESP8266WiFi.h>  // Ganti dengan <WiFi.h> jika menggunakan ESP32
#include <Servo.h>

const char* ssid = "xxx";  // Ganti dengan SSID Wi-Fi Anda
const char* password = "xxx";          // Ganti dengan password Wi-Fi Anda

const int led1 = D7;
const int led2 = D8;
const int servoPin = D4;
Servo myServo;

WiFiServer server(80);
bool isGateOpen = false;  // Flag status palang pintu
unsigned long previousMillis = 0;  // Untuk mengatur interval kedipan
const long interval = 500;  // Interval kedipan (500ms)
bool ledState = false;  // Status kedipan LED

void setup() {
  Serial.begin(115200);
  pinMode(led1, OUTPUT);
  pinMode(led2, OUTPUT);
  myServo.attach(servoPin);

  // Menghubungkan ke Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Menghubungkan ke WiFi...");
  }
  Serial.println("Terhubung ke WiFi");
  Serial.print("IP Address : ");
  Serial.println(WiFi.localIP());

  server.begin();
}

void loop() {
  WiFiClient client = server.available();
  if (client) {
    String currentLine = "";
    while (client.connected()) {
      if (client.available()) {
        char c = client.read();
        Serial.write(c);
        if (c == '\n') {
          if (currentLine.length() == 0) {
            client.println("HTTP/1.1 200 OK");
            client.println("Content-type:text/html");
            client.println();
            client.println("<!DOCTYPE HTML>");
            client.println("<html>");
            client.println("Palang Pintu Kereta Api");
            client.println("</html>");
            break;
          } else {
            if (currentLine.startsWith("GET /open")) {
              openGate();
            } else if (currentLine.startsWith("GET /close")) {
              closeGate();
            }
            currentLine = "";
          }
        } else if (c != '\r') {
          currentLine += c;
        }
      }
    }
    client.stop();
  }

  // **Menyalakan lampu berkedip jika palang TERTUTUP**
  if (!isGateOpen) {
    unsigned long currentMillis = millis();
    if (currentMillis - previousMillis >= interval) {
      previousMillis = currentMillis;
      ledState = !ledState;  // Toggle LED
      digitalWrite(led1, ledState);
      digitalWrite(led2, !ledState);
    }
  }
}

void openGate() {
  myServo.write(0);   // Membuka palang
  isGateOpen = true;  // Tandai bahwa palang terbuka
  digitalWrite(led1, LOW);  // Matikan lampu saat gate dibuka
  digitalWrite(led2, LOW);
  Serial.println("Palang pintu dibuka!");
}

void closeGate() {
  myServo.write(90);   // Menutup palang
  isGateOpen = false;  // Tandai bahwa palang tertutup
  Serial.println("Palang pintu ditutup!");
}
