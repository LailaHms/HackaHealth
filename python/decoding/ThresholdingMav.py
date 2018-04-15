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
        self._threshold = np.zeros(len(restingEmgSignals))
        for i,ch in enumerate(restingEmgSignals):
            mav = np.zeros((len(ch)-1)/self._slidingWindowSamples)
            for j in xrange(self._slidingWindowSamples,len(restingEmgSignals[0]),self._slidingWindowSamples):
                mav[j/self._slidingWindowSamples-1] = self.compute_mav(ch[j-self._slidingWindowSamples:j])
            meanMav = np.mean(mav)
            stdMav = np.std(mav)
            self._threshold[i] = meanMav+xTimes*stdMav

    def decode(self,emgSignals):
        meanAbsoluteValues = [self.compute_mav(ch) for ch in emgSignals]
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
