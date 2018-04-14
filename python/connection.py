
import sys
import os

filename = "connected.txt"

if len(sys.argv) >1 and sys.argv[1] == "connect":
    f= open(filename,"w")
    f.close()
elif len(sys.argv) >1 and sys.argv[1] == "disconnect":
    if os.path.isfile(filename) :
        os.remove(filename)
else:
    print("Incorrect input argument. Launch script with \"python connection.py connect\" or  \"python connection.py disconnect\"")
