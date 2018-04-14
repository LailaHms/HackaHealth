import sys
import numpy as np
from decoding import ThresholdingMav

def main():

    slidingWindowSamples = 10
    electrodesToMusclesMap = ["flex","flex","flex","ext","ext","ext"]

    decoder = ThresholdingMav(slidingWindowSamples,electrodesToMusclesMap)


    emgFakeRest = [
        np.random.rand(100),
        np.random.rand(100),
        np.random.rand(100),
        np.random.rand(100),
        5*np.random.rand(100),
        6*np.random.rand(100),
    ]
    decoder.calibrate_threshold(emgFakeRest)
    print decoder._threshold

    emgFake = [
        np.ones(10),
        2*np.ones(10),
        3*np.ones(10),
        4*np.ones(10),
        5*np.ones(10),
        6*np.ones(10),
    ]
    print decoder.decode(emgFake)


if __name__ == '__main__':
    main()
