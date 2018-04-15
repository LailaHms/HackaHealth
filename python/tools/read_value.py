import sys, os

def read_value(variable, path = os.getcwd(), verbose = False):

    value = False
    # wait while le fichier .lock existe
    while(os.path.isfile(os.path.join(path, variable + ".lock"))):
        if verbose: print "Waiting"

    if verbose : print "Reading value"

    with open(os.path.join(path, variable + ".txt")) as f:
        first_line = f.readline().rstrip()
        value = float(first_line)

    return value


if __name__ == '__main__':
    print(read_value("test", verbose = True))
