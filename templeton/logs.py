# This Source Code is subject to the terms of the Mozilla Public License
# version 2.0 (the "License"). You can obtain a copy of the License at
# http://mozilla.org/MPL/2.0/.

import logging
import logging.handlers

def setup_logging(handler, verbose):
    logger = logging.getLogger()
    if verbose:
        logger.setLevel(logging.DEBUG)
    else:
        logger.setLevel(logging.INFO)
    handler.setFormatter(logging.Formatter(
            "%(asctime)s %(levelname)s %(message)s", '%Y-%m-%d %H:%M:%S'))
    logger.addHandler(handler)


def setup_stream(verbose=False):
    setup_logging(logging.StreamHandler(), verbose)


def setup_file(log_file, verbose=False):
    setup_logging(logging.handlers.RotatingFileHandler(
            log_file, maxBytes=1024*1024, backupCount=5), verbose)
