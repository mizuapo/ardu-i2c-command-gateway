#ifndef COMMANDS_ANALOG_H
#define COMMANDS_ANALOG_H

#include <Arduino.h>
#include <Helpers/DataPool.h>
#include <Helpers/InputParser.h>

/**
 * argumentByte: 1-6 bit: pin number 7-8 bit not used
 *
 * Reads the value from a specified analog pin. Result as an integer
 *
 * @return current status
 */
int gwAnalogRead(int8_t argumentByte) {
    int pin = getPinNumberFromArgument(argumentByte);
    analogRead(pin);
}


/**
 * argumentByte: 1-8 bit: type
 *
 * Configures the reference voltage used for analog input (i.e. the value used as the top of the input range). The options are:
 *
 * @return current status
 */
void gwAnalogReference(int8_t argumentByte) {

    int value = DEFAULT;

    if (argumentByte>=0x0 && argumentByte<=0x5) {
        // Arduino AVR Boards (Uno, Mega, Leonardo, etc.)
        if (argumentByte == 0x00) {
            value = DEFAULT;
        } else if (argumentByte == 0x01) {
            value = INTERNAL;
        } else if (argumentByte == 0x02) {
            // value = ATmega32U4;
        } else if (argumentByte == 0x03) {
            // value = INTERNAL1V1;
        } else if (argumentByte == 0x04) {
            // value = INTERNAL2V56;
        } else if (argumentByte == 0x05) {
            value = EXTERNAL;
        } else {
            value = DEFAULT;
        }
    }
    analogReference(value);
}

/**
 * argumentByte: 1-6 bit: pin number 7-8 bit not used
 *
 * Configures the reference voltage used for analog input (i.e. the value used as the top of the input range). The options are:
 *
 * @return current status
 */
void gwAnalogWrite(int8_t argumentByte) {
    int pin = getPinNumberFromArgument(argumentByte);

    if (getBufferedDataLength()>=0 && getBufferedDataLength()<=3) {
        int value = getBufferedDataToInt();
        if (value>=0 && value<=255) {
            analogWrite(pin, value);
        }
    }
}

#endif //COMMANDS_ANALOG_H
