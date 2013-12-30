#! /usr/bin/env python

import os
import json
from collections import OrderedDict

print "Finding videos..."

videoDir = "/home/user/Public/Videos"
lib = OrderedDict()
base_dir = "base_dir"   # Avoid problems with '_empty_' in PHP
ignoreExts = [".srt", ".iso"]

for path, dirs, files in os.walk(videoDir):
    relPath = path.replace(videoDir, base_dir)
    print relPath

    # clean path name
    if relPath.startswith(os.sep):
        relPath = relPath[1:]

    tree = relPath.split(os.sep)
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

with open("/var/www/player/db.json", 'w') as outFile:
    json.dump(lib, outFile)

print "Done"
