import numpy as np

class EmgDecoding:
    """ Interface class to design different Emg decoding algos.
    """

    def __init__(self,slidingWindowSamples):
        self._slidingWindowSamples = slidingWindowSamples

    def decode():
        raise Exception("pure virtual function")

    def compute_mav(self,emgSignal):
        """ emgSignals -- list (mSamples) """
        return np.mean(np.abs(emgSignal))
