<?php


class ArduI2CCommandGateway {

    const OUTPUT =  "00";

    const INPUT =  "11";

    const INPUT_PULLUP =  "10";

    const LOW = "00";

    const HIGH = "10";

    /**
     * Read a data from
     *
     * @param int $pin
     *
     * @return int
     */
    public function digitalRead($pin = 0)
    {
        $data = $this->generateCommandByte($pin);
        $response = I2C::write(I2C::DIGITAL_READ, $data);
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

    public function delay($miliseconds) {
        usleep($miliseconds*1000);
    }



private function generateCommandByte($pin, $data = "00") {
        try {
            $pinStr = sprintf("%06d", decbin($pin));
            if (in_array($data, ["00", "01", "10", "11"])) {
                return bin2hex("{$data}{$pinStr}");
            } else {
                throw new \Exception("Data bits not correctly!");
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            echo $e->getTraceAsString();
            die();
        }
    }




}