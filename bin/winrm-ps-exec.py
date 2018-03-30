#!/usr/bin/python

import json
import winrm
import sys


def fix_run_ps(self, script):
    from base64 import b64encode
    encoded_ps = b64encode(script.encode('utf_16_le')).decode('ascii')
    rs = self.run_cmd('powershell -encodedcommand {0}'.format(encoded_ps))
    if len(rs.std_err):
        rs.std_err = self._clean_error_msg(rs.std_err.decode('utf-8'))
    return rs

try:
    winrm.Session.run_ps = fix_run_ps
    session = winrm.Session(sys.argv[1], auth=(sys.argv[2], sys.argv[3]))
    result = session.run_ps(sys.argv[4])
    print(json.dumps({'std_out': str(result.std_out, 'utf-8'), 'std_err': result.std_err, 'status_code': result.status_code}))
except BaseException as e:
    print(json.dumps({'std_out': '', 'std_err': str(e), 'status_code': 1}))