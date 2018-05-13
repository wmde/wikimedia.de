# www.wikimedia.de website

[![Build Status](https://travis-ci.org/wmde/website.svg?branch=master)](https://travis-ci.org/wmde/website)

This repo contains the source code of the [www.wikimedia.de website](https://www.wikimedia.de).

## Development

The application is build on top of the Symfony 4 PHP web framework.

Development is done via Docker. No local PHP installation is needed.

### Running the application

In the root of the project, execute this to start the Docker containers:

    docker-compose up

After the command finished, you can view the application at http://localhost:8000

### Executing PHP (including tests)
    
Running the tests (includes PHPUnit)

	make test
   
Running the style checks

	make cs
   
Full CI run

	make ci

You can get a shell from which you can interact with Symfony via PHP. Though beware that this is executed as root,
and that newly created files will be owned by root.

    docker-compose exec php-fpm bash