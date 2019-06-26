<?php


class I2C {

    const DIGITAL_READ = 0x10;

    const DIGITAL_WRITE = 0x11;

    const PIN_MODE = 0x12;

    const ANALOG_READ = 0x20;

    const ANALOG_WRITE = 0x21;

    const ANALOG_REFERENCE = 0x22;

    const POOL_ADD_DATA_TO_BUFFER = 0x30;

    const POOL_GET_BUFFERED_DATA_LENGTH = 0x31;

    const POOL_GET_FIRST_BYTE_FROM_BUFFER = 0x32;

    const POOL_FLUSH_BUFFERED_DATA = 0x33;

    const ATTACH_INTERRUPT = 0x40;

    const DETACH_INTERRUPT = 0x41;

    const GET_IMPULSE_COUNTER = 0x42;

    const RESET_IMPULSE_COUNTER = 0x43;



    private static $channelId = "0";

    private static  $slaveAddress = "0x0";



    public static function setI2cChannel($channelNum = 0)
    {
        self::$channelId = $channelNum;
    }


    public function getI2cChannel()
    {
        return self::$channelId;
    }

    public static function setSlaveAddress($address = "0x00")
    {
        self::$slaveAddress = $address;
    }

    public static function getSlaveAddress()
    {
        return self::$slaveAddress;
    }

    public static function write($commandByte, $dataByte = null)
    {
        $channelId = self::$channelId;
        $slaveAddress = self::$slaveAddress;
        return system("i2cset {$channelId} {$slaveAddress} {$commandByte} {$dataByte}");
    }

    public function read($commandByte)
    {
        $channelId = self::$channelId;
        $slaveAddress = self::$slaveAddress;
        return system("i2cget {$channelId} {$slaveAddress} {$commandByte}");
    }
}
