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
    
### Application structure

At present the repo contains no application or domain logic. However a decoupling mechanism has been put in place
that allows following the Clean Architecture by creating UseCases containing application logic that are fully
decoupled from the framework. The typical scenario here is that a controller method gets invoked and this method
then gets a UseCase instance via the TopLevelFactory. This TopLevelFactory is available via BaseController in
the production code and via EdgeToEdgeTestCase in the tests.

Example of a similarly structured application:
https://github.com/wmde/FundraisingFrontend/blob/master/README.md#project-structure