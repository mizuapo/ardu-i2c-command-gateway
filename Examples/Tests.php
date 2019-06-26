<?php

require_once "./Helper/I2C.php";
require_once "./Helper/ArduI2CCommandGateway.php";

//configure
I2C::$debugMode = false;
I2C::$debugFile = "/tmp/i2cgw.log";
I2C::setI2cChannel(0);
I2C::setSlaveAddress(0x04);

try {

    $a = new ArduI2CCommandGateway();

    // digital read
    //echo "Digital read...\n";
    //$digitalPin = 0;
    //$a->pinMode($digitalPin, ArduI2CCommandGateway::INPUT);
    //$a->delay(50);
    //$value = $a->digitalRead($digitalPin);
    //echo "Value is " . $value;


    //echo "Digital write...\n";
    //$digitalPin = 7;
    //$a->pinMode($digitalPin, ArduI2CCommandGateway::OUTPUT);
    //$a->delay(50);
    //$a->digitalWrite($digitalPin, ArduI2CCommandGateway::LOW);
    //$a->delay(2000);
    //$a->digitalWrite($digitalPin, ArduI2CCommandGateway::HIGH);
    //$a->delay(2000);
    //$a->digitalWrite($digitalPin, ArduI2CCommandGateway::LOW);
    //$a->delay(2000);
    //$a->digitalWrite($digitalPin, ArduI2CCommandGateway::HIGH);


    //echo "Analog read...\n";
    //$analogPin = 1;
    //$value = $a->analogRead($analogPin);
    //echo "Value is " . $value;


} catch (\Exception $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
}