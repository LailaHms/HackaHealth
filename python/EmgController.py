import numpy as np
import time
import logging
from Queue import Queue, Empty
# from myo import MyoRaw
import threading

logging.basicConfig(level=logging.DEBUG,format="(%(threadName)-9s) %(message)s",)

class EmgController():

    def __init__(self,outputRate,slidingWindowSamples,emgDecoder):
        self._outputRate = outputRate
        self._outputPeriod = 1./self._outputRate
        self._slidingWindowSamples = int(slidingWindowSamples)
        self._stopControl = False
        self._decoder = emgDecoder
        # self._myo = MyoRaw(None)
        # self._myo.connect()

    def get_myo_data(self,nSeconds):
        # return np.random.rand(6,nSeconds)
        oldTime = -100
        tStart = time.time()
        data = []
        while time.time()-tStart<nSeconds:
            self._myo.run(timeout=.1)
            if time.time()-oldTime>= self._outputPeriod:
                oldTime = time.time()
                data.append(self._myo.myo_emg_buffer)
        return data

    def read_continuous_data(self,queue):
        oldTime = -100
        t = time.time()
        while not self._stopControl:
            # self._myo.run(timeout=.1)
            if time.time()-oldTime>= self._outputPeriod:
                oldTime = time.time()
                print "shit"
                # logging.debug(self._myo.myo_emg_buffer)
                # velocity = self._decoder.decode(self._myo.myo_emg_buffer)
                velocity = 1
                queue.put(velocity)
                logging.debug("Decoded emg data!")

    def set_stopControl(self,val):
        self._stopControl = val
