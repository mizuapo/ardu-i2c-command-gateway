//
// Created by root on 2019.06.18..
//



#ifndef POTATO_DATA_H
#define POTATO_DATA_H

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <Wire.h>


String bufferData = "";

int cleanBufferedData() {
    bufferData = "";
}


void addBufferedData(String data) {
    bufferData+=data;
}

int getBufferedDataLength() {
    return bufferData.length();
}


int getFirstByteAndCleanIt() {
    if (getBufferedDataLength()>0) {
        char firstChar = bufferData.charAt(0);
        bufferData.remove(0,1);
        return (int)firstChar;
    }
}

String getBufferDataToString() {
    return bufferData;
}

int getBufferedDataToInt() {
    return bufferData.toInt();
}


#endif //POTATO_DATA_H
