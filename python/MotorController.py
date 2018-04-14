import numpy as np
import time
import logging
from Queue import Queue, Empty

logging.basicConfig(level=logging.DEBUG,format="(%(threadName)-9s) %(message)s",)

class MotorController():

    def __init__(self,outputRate):
        self._outputRate = outputRate
        self._outputPeriod = 1./self._outputRate
        self._stopControl = False
        self._velocity = 0

    def _update_motor_position(self):
        pass

    def run_motor(self,queue):
        oldTime = -100
        t = time.time()
        while not self._stopControl:
            if time.time()-oldTime>= self._outputPeriod:
                oldTime = time.time()
                try: self._velocity = queue.get()
                except Empty: pass
                self._update_motor_position()
                logging.debug("velocity is {0}".format(self._velocity))

    def set_stopControl(self,val):
        self._stopControl = val
