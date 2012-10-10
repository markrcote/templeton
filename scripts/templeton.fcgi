#!python

# This Source Code is subject to the terms of the Mozilla Public License
# version 2.0 (the "License"). You can obtain a copy of the License at
# http://mozilla.org/MPL/2.0/.

import inspect
import os.path
import sys
import templeton.logs
import web

if __name__ == '__main__':
    sys.path.append('.')
    from server import app

    from optparse import OptionParser
    parser = OptionParser()
    parser.add_option('-l', '--log-file', dest='log_file',
                      help='location of log file, defaults to stdout',
                      default=None)
    parser.add_option('-v', '--verbose', dest='verbose',
                      action='store_true', help='enable verbose logging')
    (options, args) = parser.parse_args()

    if options.log_file:
        templeton.logs.setup_file(log_file, options.verbose)
    else:
        templeton.logs.setup_stream(options.verbose)

    try:
        from handlers import init
    except ImportError:
        pass
    else:
        init()

    web.wsgi.runwsgi = lambda func, addr=None: web.wsgi.runfcgi(func, addr)
    app.run()
