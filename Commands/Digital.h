#ifndef COMMANDS_DIGITAL_H
#define COMMANDS_DIGITAL_H

#include <Helpers/DataPool.h>
#include <Helpers/InputParser.h>
#include <Arduino.h>

/**
 * argumentByte byte: 1-6 bit: pin number 7-8 bit not used
 *
 * Reads the value from a specified digital pin, either HIGH or LOW.
 *
 * @return current status
 */
int gwDigitalRead(int8_t argumentByte) {
    int pin = getPinNumberFromArgument(argumentByte);
    int val = digitalRead(pin);
    return val;
}


/**
 * argumentByte: 1-6 bit: pin number 7. bit allow 0, 8. bit: 1/0 HIGH/LOW
 *
 * Write a HIGH or a LOW value to a digital pin.
 */
int gwDigitalWrite(int8_t argumentByte) {

    int pin = getPinNumberFromArgument(argumentByte);
    int value = getValueFromArgument(argumentByte);
    if (value==1 || value==0) {
        digitalWrite(pin, value);
    }
}

/**
 * argumentByte 1-6 bit: pin number, 7-8. bit: 00 - OUTPUT 11 - INPUT - 10 INPUT_PULLUP
 *
 * Write a HIGH or a LOW value to a digital pin.
 */
int gwPinMode(int8_t argumentByte) {
    int pin = getPinNumberFromArgument(argumentByte);
    int mode = getValueFromArgument(argumentByte);
    pinMode(pin, mode==1 ? INPUT : OUTPUT);
}

#endif //COMMANDS_DIGITAL_H
