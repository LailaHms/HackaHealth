from ClosedLoopEmgControl import ClosedLoopEmgControl

def main():
    slidingWindowSamples = 10
    outputRate = 1
    decoderType = "thresholdingMav"
    decoderInfo = {}
    decoderInfo["electrodesToMusclesMap"] = ["flex","flex","flex","ext","ext","ext"]
    decoderInfo["calibrationTime"] = 10#s

    clc = ClosedLoopEmgControl(slidingWindowSamples,outputRate,decoderType,decoderInfo)
    #clc.calibrate()
    clc.start()


if __name__ == '__main__':
    main()
