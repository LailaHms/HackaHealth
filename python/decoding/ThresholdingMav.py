import numpy as np
from EmgDecoding import EmgDecoding


class ThresholdingMav(EmgDecoding):

    def __init__(self,slidingWindowSamples,electrodesToMusclesMap,vFlex=-1,vExt=1,vNull=0):
        """ Object initialization.

        Keyword arguments:
        slidingWindowSamples -- n samples in each window
        electrodesToMusclesMap -- dictionary[].
        """

        EmgDecoding.__init__(self,slidingWindowSamples)

        self._electrodesToMusclesMap = electrodesToMusclesMap
        self._vFlex = vFlex
        self._vExt = vExt
        self._vNull = vNull
        self._threshold = len(electrodesToMusclesMap)*[0]

    def calibrate_threshold(self,restingEmgSignals,xTimes=5):
        """ restingEmgSignals -- list (nChans) of list (mSamples) """
        self._threshold = np.zeros(len(restingEmgSignals[0]))

        count = 1
        for i,window in enumerate(restingEmgSignals):
            if np.sum(np.mean(np.abs(window),axis=1))==0:continue
            if count==1:calibrationData = np.mean(np.abs(window),axis=1)
            else: calibrationData = np.c_[calibrationData,np.mean(np.abs(window),axis=1)]
            count+=1

        meanMav = np.mean(calibrationData,axis=1)
        stdMav = np.std(calibrationData,axis=1)
        self._threshold = meanMav+xTimes*stdMav

    def print_thresholds(self):
        print self._threshold

    def decode(self,emgSignals):
        meanAbsoluteValues = [self.compute_mav(ch) for ch in emgSignals]
        print meanAbsoluteValues[0]
        flex = 0
        ext = 0
        for muscle,mav,thr in zip(self._electrodesToMusclesMap,meanAbsoluteValues,self._threshold):
            if muscle == "ext" and mav>thr: ext+=1
            elif muscle == "flex" and mav>thr: flex+=1
        # Check activity
        if flex+ext>0:
            if flex>ext: return self._vFlex
            elif ext>flex: return self._vExt
            else: return self._vNull
        else: return self._vNull
