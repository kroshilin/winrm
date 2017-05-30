#!/usr/bin/python

import json
import winrm
import sys

session = winrm.Session(sys.argv[1], auth=(sys.argv[2], sys.argv[3]))
result = session.run_ps(sys.argv[4])

print(json.dumps({'std_out': result.std_out, 'std_err': result.std_err, 'status_code': result.status_code}))
