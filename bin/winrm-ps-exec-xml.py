#!/usr/bin/python

import json
import winrm
import sys
import xmltodict
from base64 import b64encode

session = winrm.Session(sys.argv[1], auth=(sys.argv[2], sys.argv[3]))

script = sys.argv[4]
encoded_ps = b64encode(script.encode('utf_16_le')).decode('ascii')

shell_id = session.protocol.open_shell()
command_id = session.protocol.run_command(shell_id, 'powershell -encodedcommand {0}'.format(encoded_ps))


req = {'env:Envelope': session.protocol._get_soap_header(
    resource_uri='http://schemas.microsoft.com/wbem/wsman/1/windows/shell/cmd',  # NOQA
    action='http://schemas.microsoft.com/wbem/wsman/1/windows/shell/Receive',  # NOQA
    shell_id=shell_id)}

stream = req['env:Envelope'].setdefault('env:Body', {}).setdefault(
    'rsp:Receive', {}).setdefault('rsp:DesiredStream', {})
stream['@CommandId'] = command_id
stream['#text'] = 'stdout stderr'

res = session.protocol.send_message(xmltodict.unparse(req))

print(res)
