<?php


class ArduI2CCommandGateway {

    const OUTPUT =  "00";

    const INPUT =  "11";

    const INPUT_PULLUP =  "10";

    const LOW = "00";

    const HIGH = "01";

    /**
     * Read a data from
     *
     * @param int $pin
     *
     * @throws Exception
     *
     * @return int
     */
    public function digitalRead($pin = 0)
    {
        $data = $this->generateCommandByte($pin);

        $this->flushBufferedData();
        $this->delay(50);
        I2C::write(I2C::DIGITAL_READ, $data);
        $this->delay(50);
        $response = $this->getBufferedData();

        return $response;
    }


    public function digitalWrite($pin, $mode)
    {
        $data = $this->generateCommandByte($pin, $mode);
        I2C::write(I2C::DIGITAL_WRITE, $data);
    }

    public function pinMode($pin, $mode)
    {
        $data = $this->generateCommandByte($pin, $mode);
        I2C::write(I2C::PIN_MODE, $data);
    }


    /**
     * Analog Read
     *
     * @param $pin
     * @return string
     * @throws Exception
     */
    public function analogRead($pin)
    {
        $data = $this->generateCommandByte($pin);

        $this->flushBufferedData();
        $this->delay(50);
        I2C::write(I2C::ANALOG_READ, $data);
        $this->delay(50);
        $response = $this->getBufferedData();

        return $response;
    }

    /**
     * Analog Write
     *
     * @param $pin
     * @return string
     * @throws Exception
     */
    public function analogWrite($pin, $value)
    {
        $this->flushBufferedData();
        $this->delay(50);
        $this->writeBufferedData($value);
        $this->delay(50);
        $data = $this->generateCommandByte($pin);
        I2C::write(I2C::ANALOG_WRITE, $data);
        $this->delay(50);
    }


    public function delay($miliseconds) {
        usleep($miliseconds*1000);
    }


    private function generateCommandByte($pin, $data = "00") {
        try {

            $pinStr = sprintf("%06d", decbin($pin));

            if (in_array($data, ["00", "01", "10", "11"])) {
                return bindec("{$data}{$pinStr}");
            } else {
                throw new \Exception("Data bits not correctly!");
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            echo $e->getTraceAsString();
            die();
        }
    }

    /**
     * @throws Exception
     */
    public function flushBufferedData()
    {
        I2C::write(I2C::POOL_FLUSH_BUFFERED_DATA);
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public function getBufferedData() {
        $length = hexdec(I2C::read(I2C::POOL_GET_BUFFERED_DATA_LENGTH));
        $data = "";
        for ($i=0;$i<$length;$i++) {
            $data.= chr(hexdec(I2C::read(I2C::POOL_GET_FIRST_BYTE_FROM_BUFFER)));
            $this->delay(50);
        }
        return $data;
    }

    /**
     * @param $pin
     * @param $dataToSend
     * @throws Exception
     */
    public function writeBufferedData($dataToSend)
    {
        I2C::write(I2C::POOL_ADD_DATA_TO_BUFFER, $dataToSend);
    }


}