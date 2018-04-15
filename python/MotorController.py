import numpy as np
import time
import logging
from Queue import Queue, Empty
import RPi.GPIO as GPIO

logging.basicConfig(level=logging.DEBUG,format="(%(threadName)-9s) %(message)s",)

class MotorController():

    def __init__(self,outputRate):
        self._outputRate = outputRate
        self._outputPeriod = 1./self._outputRate
        self._stopControl = False
        self._velocity = 0

        self._outputRpiPin = 18
        self._pwmOptimalFreq = 50
        self._motorPosition = 5.5 # half range of motion

    def _update_motor_position(self):
        GPIO.setmode(GPIO.BOARD)
        GPIO.setup(self._outputRpiPin, GPIO.OUT)

        pwm = GPIO.PWM(self._outputRpiPin,self._pwmOptimalFreq)
        pwm.start(0)

        GPIO.output(self._outputRpiPin,True)
        pwm.ChangeDutyCycle(self._motorPosition)
        time.sleep(0.5)
        self._motorPosition += self._velocity

        pwm.stop()
        GPIO.cleanup()


    def run_motor(self,queue):
        oldTime = -100
        t = time.time()
        while not self._stopControl:
            if time.time()-oldTime>= self._outputPeriod:
                oldTime = time.time()
                try: self._velocity = queue.get()
                except Empty: pass

                # Motor control
                # GPIO.setmode(GPIO.BOARD)
                # GPIO.setup(self._outputRpiPin, GPIO.OUT)
                # pwm = GPIO.PWM(self._outputRpiPin,self._pwmOptimalFreq)
                # pwm.start(0)
                # GPIO.output(self._outputRpiPin,True)
                # pwm.ChangeDutyCycle(self._motorPosition)

                # time.sleep(0.5)
                # self._motorPosition += self._velocity
                # pwm.stop()
                # GPIO.cleanup()

                logging.debug("velocity is {0}".format(self._velocity))

    def set_stopControl(self,val):
        self._stopControl = val
