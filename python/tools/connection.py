
import sys
import os
print "Trying to Disconnect"
filename = "tmp/connect.txt"
print "Trying to Disconnect"

print "Trying to Disconnect"

if len(sys.argv) >1 and sys.argv[1] == "connect":
    print "Trying to Connect"
    f= open(filename,"w")
    f.close()
    print "Connected"
    print os.path.isfile(filename) 
elif len(sys.argv) >1 and sys.argv[1] == "disconnect":
    print "Trying to Disconnect"
    if os.path.isfile(filename) :
        os.remove(filename)
    print "Disconnected"
else:
    print "Incorrect input argument. Launch script with \"python connection.py connect\" or  \"python connection.py disconnect\""
