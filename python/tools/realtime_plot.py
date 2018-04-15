#!/usr/bin/env python

import numpy as np
import time
import matplotlib
matplotlib.use('GTKAgg')
#matplotlib.use('TkAgg')
from matplotlib import pyplot as plt
import random
import time

if __name__ == '__main__':
    """
    Display the simulation using matplotlib using blit for speed
    """

    x = np.random.rand(255,1)*10
    y = np.random.rand(255,1)*10

    fig, ax = plt.subplots(1, 1)
    ax.set_xlim(0, 255)
    ax.set_ylim(0, 10)
    ax.hold(True)

    plt.show(False)
    plt.draw()

    background = fig.canvas.copy_from_bbox(ax.bbox)

    points = ax.plot(x, y, 'o')[0]
    tic = time.time()

    for ii in xrange(10000):
        print(ii)
        # update the xy data
        x = x[1:-1] + [random.randint(0,5)]
        y = y[1:-1] + [random.randint(0,5)]

        time.sleep(0.05)
        points.set_data(x, y)

        # restore background
        fig.canvas.restore_region(background)

        # redraw just the points
        ax.draw_artist(points)

        # fill in the axes rectangle
        fig.canvas.blit(ax.bbox)

    plt.close(fig)
    print "Blit = %s, average FPS: %.2f" % (niter / (time.time() - tic))
