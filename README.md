# www.wikimedia.de website

[![Build Status](https://travis-ci.org/wmde/website.svg?branch=master)](https://travis-ci.org/wmde/website)

This repo contains the source code of the [www.wikimedia.de website](https://www.wikimedia.de).

## Development

The application is build on top of the Symfony 4 PHP web framework.

Development is done via Docker. No local PHP installation is needed.

### Running the application

In the root of the project, execute this to start the Docker containers:

    docker-compose up -d

After the command finished, you can view the application at http://localhost:8000

### Executing PHP (including tests)

Executing this in the project root will give you a shell from which you can interact with Symfony via PHP:

    docker-compose exec php-fpm bash
    
Running PHPUnit

	make test
   
Full CI run

	make ci
