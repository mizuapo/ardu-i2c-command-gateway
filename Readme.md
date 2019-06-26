# Arduino I2C remote pin/command controller 

This project makes a command gateway between Arduino (slave) and any I2C master device (another Arduino, RapsberryPi, OrangePi etc.)

## Getting Started

Get the project:

git clone 

Run the project
cmake --build /home/molnarg/CLionProjects/ardu-i2c-command-gateway/cmake-build-debug --target ardu_i2c_command_gateway -- -j 4



### Compatibility
Arduino AVR Boards (Uno, Mega, Leonardo, etc.)

### Configure

Find and edit the Config.h and change the I2C slave address if needed. Default address is: **0x04**


```
Give the example
```

And repeat

```
until finished
```

End with an example of getting some data out of the system or using it for a little demo

### Usage

Examples with i2cset and i2cget.

The pre-requested command parameters in example:

**WRITE command**
```
i2cset -f -y 0 0x04 [CommandByte] [ArgumentByte]
```
 Where the **0** is number of I2C bus, **0x04** is the slave Arduino address, the **CommandByte** is the command Id, and **ArgumentByte** is a multifunctional byte. See details.  
\
**READ command**
```
i2cget -f -y 0 0x04 [CommandByte]
```

The result is a number from  0x00 to 0xFF.


## Supported Commands 
CommandByte and ArgumentByte description
#### Arduino core commands
##### Digital

* **digitalRead** - 0x10 (Dec 16) - (2 byte, WRITE command)\
ArgumentByte desc:
    - bit 1-6: pin number
    - bit 7: not used
    - bit 8: 1/0 
        - 1 before write to buffer to data the buffer will flush all previous data. 
        - 0 Keep the prev buffer data(s).

* **digitalWrite** - 0x11 (Dec 17) - (2 byte, WRITE command)\
ArgumentByte desc:
    - bit 1-6: pin number
    - bit 7: not used 
    - bit 8: 1/0 HIGH/LOW

* **pinMode** - 0x12 (Dec 18) (2 byte, WRITE command)\
ArgumentByte desc:
    - bit 1-6: pin number
    - bit 7-8: 
        - 00 OUTPUT
        - 11 INPUT
        - 10 INPUT_PULLUP

##### Analog

* **analogRead** - 0x20 (Dec 32) (2 byte, WRITE command)\
    ArgumentByte desc:
    - bit 1-6: pin number
    - bit 7: not used
    - bit 8: 1/0\ 
        - 1 before write to buffer to data the buffer will flush all previous data. 
        - 0 Keep the prev buffer data(s).
* **analogWrite** - 0x21 (Dec 33) (2 byte, WRITE command)\
    ArgumentByte desc:
    - bit 1-6: pin number
    - bit 7-8: not used

* **analogReference** - 0x22 (Dec 34) -  (2 byte, WRITE command)\
    ArgumentByte desc:
    - bit 1-6: pin number
    - bit 7-8: not used


#### Custom (helper) commands
* 0x30 (Dec 48) - Send a byte from master to slave device buffer pool (2 byte, WRITE command)
* 0x31 (Dec 49) - Get the buffer pool length of slave device and send to master. (READ command)
* 0x32 (Dec 50) - Read the oldest a byte from slave device buffer, send to master and delete from pool. (READ command) (eg.: if the pool contains **63215** then will send the first char (**6**) and the new buffer pool it will be **3215**. )
* 0x33 (Dec 50) - Flush salve device pool and return the new length (READ command) 

##Examples

##### DigitalRead
*i2c command: first byte: 0x10 second byte: 1-6 bit: pin number 7-8 bit not used*

```
i2cset -f -y 0 0x04 0x10 0x
i2cset -f -y 0 0x04 0x02 0x8B
```


## Versioning

* ##### 1.0 - Initial version

## Authors

* **Gabor Molnar** - *Initial work* - [mizuapo](https://github.com/mizuapo)

## License

This project is licensed under the Creative Common License.
