import sys
import numpy as np
import time
import threading
from Queue import Queue, Empty

from decoding import ThresholdingMav
from EmgController import EmgController
from MotorController import MotorController
from tools import read_value

class ClosedLoopEmgControl():

    def __init__(self,slidingWindowSamples,outputRate,decoderType,decoderInfo):

        #Init general variables
        self._slidingWindowSamples = slidingWindowSamples
        self._outputRate = outputRate
        self._outputPeriod = 1./self._outputRate
        self._decoderType = decoderType
        self._decoderInfo = decoderInfo

        self._stopControl = False
        self._debugPeriodPrinting = 1

        self.init_decoder()
        self.init_myo()
        time.sleep(10)
        print "Ended initializations ... pisellino ;) "
        self.init_motor()

    def init_decoder(self):
        if self._decoderType == "thresholdingMav":
            self._decoder = ThresholdingMav(self._slidingWindowSamples,self._decoderInfo["electrodesToMusclesMap"])

    def init_myo(self):
        self._emgCnt = EmgController(self._outputRate,self._slidingWindowSamples,self._decoder)

    def init_motor(self):
        self._motorCnt = MotorController(self._outputRate)

    def _init_threads(self):
        self._threadEmg = threading.Thread(name="emgThread",target=self._emgCnt.read_continuous_data,args=(self._dataQueue,))
        self._threadMotor = threading.Thread(name="motorThread",target=self._motorCnt.run_motor,args=(self._dataQueue,))

    def _start_threads(self):
        self._threadEmg.start()
        self._threadMotor.start()

    def start(self):
        self._dataQueue = Queue()
        self._init_threads()
        self._start_threads()
        self.check_stop()

    def check_stop(self):
        while True:
            time.sleep(0.1)
            # if read_value("disconnet"): # TODO
            if False:
                self._stopControl = True
                self._emgCnt.set_stopControl(True)
                self._motorCnt.set_stopControl(True)
                self._threadEmg.join()
                self._threadMotor.join()
                break

    def calibrate(self):
        while True:
            time.sleep(0.1)
            if read_value("calibrate"):
                if self._decoderType == "thresholdingMav":
                    emgSignals = self._emgCnt.get_myo_data(self._decoderInfo["calibrationTime"])
                    self._decoder.calibrate_threshold(emgSignals)
                    self._decoder.print_thresholds()
                break
