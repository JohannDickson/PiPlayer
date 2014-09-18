#! /usr/bin/env python

import os
import json
from collections import OrderedDict

# Change these to match your configuration
videoDir = "/home/user/Public/Videos"
webDir   = "/var/www/player"
#

dbFile = webDir+"/db.json"    # Same as in www/index.php

print "Finding videos..."

lib = OrderedDict()
ignoreExts = [".srt", ".iso"]

for path, dirs, files in os.walk(videoDir):
    print path

    tree = path.split(os.sep)[1:]
    last_dir = lib

    # Make sure path exists in dict
    for d in tree:
        if d not in last_dir:
            last_dir[d] = OrderedDict()
        last_dir = last_dir[d]

    # Add files to tree
    if files:
        last_dir['files'] = []
        for f in sorted(files):
            if os.path.splitext(f)[-1] not in ignoreExts:
                last_dir['files'].append(f)

    # Add dirs to tree
    if dirs:
        for dd in sorted(dirs):
            if dd not in last_dir:
                last_dir[dd] = OrderedDict()

with open(dbFile, 'w') as outFile:
    json.dump(lib, outFile)

print "Done"
