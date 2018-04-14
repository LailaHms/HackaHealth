import numpy as np
import time
import logging
from Queue import Queue, Empty

logging.basicConfig(level=logging.DEBUG,format="(%(threadName)-9s) %(message)s",)

class EmgController():

    def __init__(self,outputRate,slidingWindowSamples,emgDecoder):
        self._outputRate = outputRate
        self._outputPeriod = 1./self._outputRate
        self._slidingWindowSamples = int(slidingWindowSamples)
        self._stopControl = False
        self._decoder = emgDecoder

    def get_myo_data_window(self):
        return np.random.rand(6,self._slidingWindowSamples)

    def get_myo_data(self,nSeconds):
        return np.random.rand(6,nSeconds)

    def read_continuous_data(self,queue):
        oldTime = -100
        t = time.time()
        while not self._stopControl:
            if time.time()-oldTime>= self._outputPeriod:
                oldTime = time.time()
                emgWindow = self.get_myo_data_window()
                velocity = self._decoder.decode(emgWindow)
                queue.put(velocity)
                logging.debug("Decoded emg data!")

    def set_stopControl(self,val):
        self._stopControl = val
