# OpenPetition

## Symfony Docker

Docker setup based on [Symfony Docker](https://github.com/dunglas/symfony-docker)

### Quick guide

#### Building docker images

`./docker_dev.sh build --pull --no-cache`

#### Running dev environment with XDEBUG enabled

`XDEBUG_MODE=debug ./docker_dev.sh up -d`

*If debugging doesn't work, check your firewall settings. Access to port 9003 must be allowed.*

## Setup guide

#### Importing example petition

An example of petition parameters is located in `app_parameters/import_petition_example.sql`.
To import an example, use the command: `php bin/console doctrine:query:sql "$(cat app_parameters/import_petition_example.sql)"`
