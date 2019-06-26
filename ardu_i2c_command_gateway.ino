#include <Wire.h>
#include <Arduino.h>
#include <Commands/Analog.h>
#include <Commands/Digital.h>
#include <Commands/Interrupt.h>
#include <Helpers/InputParser.h>
#include <Helpers/DataPool.h>

const int I2C_ADDRESS = 0x04;

//#include <Config.h>
//#include <stdio.h>
//#include <stdlib.h>
//#include <string.h>
//#include <Wire.h>
//#include <Arduino.h>
//#include <Data.h>
//#include <math.h>
//#include <Commands.h>


unsigned int response;

// callback for received data
void receiveI2C(int byteCount) {

    int commandByte = Wire.read();

    int argumentByte = 0x00;
    if (byteCount==2) {
        argumentByte = Wire.read();
    }

    // DIGITAL COMMANDS
    if (byteCount==2 && commandByte == 0x10) {          // Digital read and set to buffered data pool(hex: 0x10, dec: 16)
        int result = gwDigitalRead(argumentByte);
        addBufferedData(String(result, DEC));
    } else if (byteCount==2 && commandByte == 0x11) {   // Digital write (hex: 0x11, dec: 17)
        gwDigitalWrite(argumentByte);
    } else if (byteCount==2 && commandByte == 0x12) {   // Pin mode (hex: 0x12, dec: 18)
        gwPinMode(argumentByte);

    // ANALOG COMMANDS
    } else if (byteCount==2 && commandByte == 0x20) {   // Analog read and set to buffered data pool (hex: 0x20, dec: 32)
        int result = gwAnalogRead(argumentByte);
        addBufferedData(String(result, DEC));
    } else if (byteCount==2 && commandByte == 0x21) {   // Analog write (hex: 0x21, dec: 33)
        gwDigitalWrite(argumentByte);
    } else if (byteCount==2 && commandByte == 0x22) {   // Analog reference (hex: 0x22, dec: 34)
        gwAnalogReference(argumentByte);

    // POOL COMMANDS
    } else if (byteCount==2 && commandByte == 0x30) {   // Set buffer from i2c (hex: 0x30, dec: 48)
        addBufferedData(String(argumentByte, DEC));
    } else if (byteCount==1 && commandByte == 0x31) {   // Get buffered data length (hex: 0x31, dec: 49)
        response = getBufferedDataLength();
    } else if (byteCount==1 && commandByte == 0x32) {   // Get first byte from buffered data, and clear it from pool (hex: 0x32, dec: 50)
        response = getFirstByteAndCleanIt();
    } else if (commandByte == 0x33) {                   // Flush Buffered data (hex: 0x33, dec: 51)
        cleanBufferedData();
        response = getBufferedDataLength();

    // INTERRUPT COMMANDS
    } else if (byteCount==2 && commandByte==0x40) {     // Attach interrupt (hex: 0x40, dec: 64)
        gwAttachInterrupt(argumentByte);
    } else if (byteCount==2 && commandByte==0x41) {     // Detach interrupt (hex: 0x41, dec: 65)
        gwdDetachInterrupt(argumentByte);
    } else if (byteCount==1 && commandByte==0x42) {     // Get Interrupt counter (hex: 0x42, dec: 66)
        gwdDetachInterrupt(argumentByte);
    }
}


void sendI2CData() {
    Serial.print("Response:");
    Serial.println(response);
    Serial.print("Data str: ");
    Wire.write(response);
}

void setupI2C() {
    Serial.print("Setting up the i2c Address: ");
    Serial.println(I2C_ADDRESS);
    Wire.begin(I2C_ADDRESS);
    Wire.onReceive(receiveI2C);
    Wire.onRequest(sendI2CData);
}


void setup() {
    Serial.begin(9600);
    setupI2C();
    Serial.println("I2C Command Gateway Ready");
}


void loop() {

}