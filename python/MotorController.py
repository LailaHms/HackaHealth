import numpy as np
import time
import logging
from Queue import Queue, Empty
import RPi.GPIO as GPIO
from random import randint


logging.basicConfig(level=logging.DEBUG,format="(%(threadName)-9s) %(message)s",)

class MotorController():

    def __init__(self,outputRate,startingPosition=4.5,minPosition=4.5,maxPosition=5.5,movementStep=0.1):
        self._outputRate = outputRate
        self._outputPeriod = 1./self._outputRate
        self._stopControl = False
        self._velocity = 0
        self._startPosition = startingPosition
        self._minPosition = minPosition
        self._maxPosition = maxPosition
        self._movementStep = movementStep
        
        self._outputRpiPin = 18
        self._pwmOptimalFreq = 50
        self._motorPosition = self._startPosition # half range of motion
        


    def run_motor(self,queue):
        GPIO.setmode(GPIO.BOARD)
        GPIO.setup(self._outputRpiPin, GPIO.OUT)
        self._pwm = GPIO.PWM(self._outputRpiPin,self._pwmOptimalFreq)
        self._pwm.start(0)
        self._pwm.ChangeDutyCycle(self._startPosition)
        time.sleep(1)
        oldTime = -100
        t = time.time()
        while not self._stopControl:
            if time.time()-oldTime>= self._outputPeriod:
                oldTime = time.time()
                try: self._velocity = queue.get()
                except Empty: pass
                logging.debug("velocity is {0}".format(self._velocity))
	        self._motor()

        self._pwm.stop()
        GPIO.cleanup()
    
    def _motor(self):
        print self._velocity
        if(str(self._velocity) == '1'):
            GPIO.output(self._outputRpiPin,True)
            self._pwm.ChangeDutyCycle(self._motorPosition)
            time.sleep(0.1)
            if(self._motorPosition > self._maxPosition):
                self._motorPosition = self._maxPosition
            else:
                self._motorPosition += self._movementStep
                                
        elif(str(self._velocity) == '-1'):
            GPIO.output(self._outputRpiPin,True)
            self._pwm.ChangeDutyCycle(self._motorPosition)
            time.sleep(0.1)
            if(self._motorPosition <= self._minPosition):
                self._motorPosition = self._minPosition
            else:
                self._motorPosition -= self._movementStep
                                
        else:
            print 'stop'
        


if __name__ == "__main__":
    main()         

    logging.debug("velocity is {0}".format(self._velocity))

    def set_stopControl(self,val):
        self._stopControl = val
