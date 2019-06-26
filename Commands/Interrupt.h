#ifndef COMMANDS_INTERRUPT_H
#define COMMANDS_INTERRUPT_H

#include <Helpers/InputParser.h>
#include <Helpers/DataPool.h>
#include <Arduino.h>
#include <stdint.h>

int interruptCounter = 0;

void impulseCounter() {
    interruptCounter++;
}


/**
 * argumentByte: 1-6 bit: pin number 7-8. bit: 00 - Low, 01 - Change, 10 - Rising, 11 Falling
 *
 * Write a HIGH or a LOW value to a digital pin.
 */
void gwAttachInterrupt(int8_t argumentByte) {
    int pin = getPinNumberFromArgument(argumentByte);
    int mode = getValueFromArgument(argumentByte);

    if (mode==0) {
        mode = LOW;
    } else if (mode==1) {
        mode = CHANGE;
    } else if (mode==10) {
        mode = RISING;
    } else if (mode==11) {
        mode = FALLING;
    }

    attachInterrupt(digitalPinToInterrupt(pin), impulseCounter, mode);
}


void gwdDetachInterrupt(int8_t argumentByte) {
    int pin = getPinNumberFromArgument(argumentByte);
    detachInterrupt(digitalPinToInterrupt(pin));
}

int getInterruptCounter() {
    return interruptCounter;
}


void resetImpulseCounter() {
    interruptCounter = 0;
}

#endif //COMMANDS_INTERRUPT_H
