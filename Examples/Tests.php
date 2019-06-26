<?php

require_once "./Helper/I2C.php";
require_once "./Helper/ArduI2CCommandGateway.php";

//configure
I2C::setI2cChannel("0");
I2C::setSlaveAddress("0x04");


$a = new ArduI2CCommandGateway();

// digital read
echo "Digital read...";
$digitalPin = 5;
$a->pinMode($digitalPin, ArduI2CCommandGateway::INPUT);
$a->delay(50);
$value = $a->digitalRead($digitalPin);
echo "Value is ".$value;


// digital read
echo "Digital write...";
$digitalPin = 7;
$a->pinMode($digitalPin, ArduI2CCommandGateway::OUTPUT);
$a->delay(50);
$a->digitalWrite($digitalPin, ArduI2CCommandGateway::LOW);
$a->delay(5000);
$a->digitalWrite($digitalPin, ArduI2CCommandGateway::HIGH);
$a->delay(5000);
$a->digitalWrite($digitalPin, ArduI2CCommandGateway::LOW);
$a->delay(5000);
$a->digitalWrite($digitalPin, ArduI2CCommandGateway::HIGH);


