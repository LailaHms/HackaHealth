import numpy as np
import time
import logging
from Queue import Queue, Empty
from myo import MyoRaw
import threading

logging.basicConfig(level=logging.DEBUG,format="(%(threadName)-9s) %(message)s",)

class EmgController():

    def __init__(self,outputRate,slidingWindowSamples,emgDecoder):
        self._outputRate = outputRate
        self._outputPeriod = 1./self._outputRate
        self._slidingWindowSamples = int(slidingWindowSamples)
        self._stopControl = False
        self._decoder = emgDecoder
        self._myo = MyoRaw(None)
        self._myo.connect()

    def get_myo_data(self,nSeconds):
        oldTime = -100
        tStart = time.time()
        data = []
        while time.time()-tStart<nSeconds:
            self._myo.run(timeout=1)
            if time.time()-oldTime>= self._outputPeriod:
                oldTime = time.time()
                data.append(self._myo.myo_emg_buffer)
        return data

    def read_continuous_data_thread(self,queue):
        oldTime = -100
        t = time.time()
        while not self._stopControl:
            self._myo.run(timeout=1)
            if time.time()-oldTime>= self._outputPeriod:
                oldTime = time.time()
                velocity = self._decoder.decode(self._myo.myo_emg_buffer)
                queue.put(velocity)
                logging.debug("Decoded emg data! velocity %.1f"%(velocity))

    def decode(self,queue):
        velocity = self._decoder.decode(self._myo.myo_emg_buffer)
        queue.put(velocity)
        logging.debug("Decoded emg data! velocity %.1f"%(velocity))

    def set_stopControl(self,val):
        self._stopControl = val
