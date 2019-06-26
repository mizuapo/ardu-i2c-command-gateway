#ifndef INPUT_PARSER_H
#define INPUT_PARSER_H

int ipow(int base, int exp)
{
    int result = 1;
    for (;;)
    {
        if (exp & 1)
            result *= base;
        exp >>= 1;
        if (!exp)
            break;
        base *= base;
    }
    return result;
}

/**
 * Get pin number (1-7 bit)
 *
 * @return int - the pin number
 */
int getPinNumberFromArgument(int8_t argumentByte) {
    // get first bit value
    int pin = 0;
    int value = 0;
    for (int i=5;i>=0;i--) {
        int bitValue = ((1 << (i % 8)) & (argumentByte)) >> (i % 8);

        if (bitValue==1) {
            pin += ipow(2, i);
        }
    }
    Serial.print("Parsed pin number is: ");
    Serial.println(pin);
    return  pin;
}

/**
 * Get binary value  (8. bit)
 *
 * @return int - the value (0)0, (0)1, 10, 11
 */
int getValueFromArgument(int8_t argumentByte) {
    int result = 0;
    result = (((1 << (7 % 8)) & (argumentByte)) >> (7 % 8))*10;
    result+= (((1 << (6 % 8)) & (argumentByte)) >> (6 % 8));

    Serial.print("Parsed top 2 bit value is: ");
    Serial.println(result);

    return  result;
}

#endif //INPUT_PARSER_H
