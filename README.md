# OpenPetition

## Symfony Docker

Docker setup based on [Symfony Docker](https://github.com/dunglas/symfony-docker)

### Quick guide

#### Building docker images

`./docker_dev.sh build --pull --no-cache`

#### Running dev environment with XDEBUG enabled

`XDEBUG_MODE=debug ./docker_dev.sh up -d`

*If debugging doesn't work, check your firewall settings. Access to port 9003 must be allowed.*
