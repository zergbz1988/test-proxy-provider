## How to deploy
First of all, you must have an OS with Docker installed and with GNU Make support. After that:
- run `make install` to prepare .env file, install sail, start the containers, install composer dependencies, generate new JWT secret for the app, generate app certificates.

## How to test
- run `make test` to run all tests.