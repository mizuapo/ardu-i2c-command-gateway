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

    private static $slaveAddress = "0x0";

    public static $debugMode = false;

    public static $debugFile = "/tmp/i2cgw.log";

    public static function setI2cChannel($channelNum = 0)
    {
        $channelNum = sprintf("0x%02x", $channelNum);
        self::debug("Setting up i2c Channel to {$channelNum}");
        self::$channelId = $channelNum;
    }


    public function getI2cChannel()
    {
        return self::$channelId;
    }

    public static function setSlaveAddress($address = "0x00")
    {
        $address = sprintf("0x%02x", $address);
        self::debug("Setting up i2c Slave Address to {$address}");
        self::$slaveAddress = $address;
    }

    public static function getSlaveAddress()
    {
        return self::$slaveAddress;
    }

    /**
     * @param $commandByte
     * @param null|int $argumentByte
     * @return bool|string
     * @throws Exception
     */
    public static function write($commandByte, $argumentByte = null)
    {
        $channelId = self::$channelId;
        $slaveAddress = self::$slaveAddress;
        $commandByte = strtoupper(sprintf("0x%02x", $commandByte));
        $argumentByte = strtoupper(sprintf("0x%02x", $argumentByte));

        if (strlen($slaveAddress)!=4) {
            throw new Exception("Invalid slave addres!");
        }

        if (strlen($channelId)!=4) {
            throw new Exception("Invalid channel Id!");
        }

        if (strlen($commandByte)!=4) {
            throw new Exception("Invalid command byte (first byte: {$commandByte})!");
        }


        if (!empty($argumentByte) && strlen($argumentByte)!=4 ) {
            throw new Exception("Invalid argument byte (second byte: {$argumentByte})!");
        }

        $command = "i2cset -y -f  {$channelId} {$slaveAddress} {$commandByte} {$argumentByte}";
        self::debug("Write command: ");
        self::debug($command);
        exec($command);
    }

    /**
     * @param $commandByte
     * @return bool|string
     * @throws Exception
     */
    public static function read($commandByte)
    {
        $channelId = self::$channelId;
        $slaveAddress = self::$slaveAddress;
        $commandByte = strtoupper(sprintf("0x%02x", $commandByte));

        if (strlen($slaveAddress)!=4) {
            throw new Exception("Invalid slave addres!");
        }

        if (strlen($channelId)!=4) {
            throw new Exception("Invalid channel Id!");
        }

        if (strlen($commandByte)!=4) {
            throw new Exception("Invalid command byte (first byte: {$commandByte})!");
        }

        $command = "i2cget -y -f {$channelId} {$slaveAddress} {$commandByte}";
        self::debug("Read command:");
        self::debug($command);
        $response =  exec($command);
        self::debug("Read response:");
        self::debug($response);
        return $response;
    }

    public static function debug($msg) {
        if (self::$debugMode) {
            echo $msg."\n";
            $toLog = date("Y-m-d H:i:s");
            file_put_contents(
                self::$debugFile,
                "[{$toLog}] : {$msg} \n",
                FILE_APPEND
            );
        }

    }
}
