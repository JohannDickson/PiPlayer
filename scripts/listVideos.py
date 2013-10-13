#! /usr/bin/env python

import os
import json

videoDir = "/home/user/Public/Videos"
lib = {}

for path, dirs, files in os.walk(videoDir):
    if files:
        relPath = path.replace(videoDir,'')
        lib[relPath] = []
        for f in sorted(files):
            lib[relPath].append(f)

with open("/var/www/player/db.json", 'w') as outFile:
    json.dump(lib, outFile)
