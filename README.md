# www.wikimedia.de website

[![Build Status](https://travis-ci.org/wmde/wikimedia.de.svg?branch=master)](https://travis-ci.org/wmde/wikimedia.de)

This repo contains the source code of the [www.wikimedia.de website](https://www.wikimedia.de).

## Editing content

Presently there are two types of content on the site, each with their own editing approach.

### Messages

Many of the text on the site, known as "messages", is displayed using a translation mechanism. This mechanism gets the
message in the correct language from a translation file. These files can be found in the `translations` directory, and
there is one per language. They contain one line per message, starting with an identifier, followed by the actual text
in the right language.

Excerpt from `translations/messages.en.yaml`:

	homepage.mission.header: Mission
	homepage.mission.message: We promote Free Knowledge to further equal access to knowledge and education.
	homepage.ED.title: Executive Director

If you want to update a message on the site, you can open the right messages file with a text editor and search
for the message you want to update. Leave the identifier on the left alone.

GitHub editing links:

* [German messages](https://github.com/wmde/website/edit/master/translations/messages.de.yaml)
* [English messages](https://github.com/wmde/website/edit/master/translations/messages.en.yaml)

Further understanding of how the system works is not needed, though might be useful:
The messages are used in the templates (located in the `templates` folder), where they are identified by their
identifier. By looking at the templates you can see exactly where a message is used.

### Templates

The simple pages such as "imprint" are not translated via the messages system. Instead there are two versions of the
page, one English and one German. To update the text or structure of these pages you will need to edit their respective
template.

The templates can all be found in the `templates` directory, with the pages residing in the `pages`
sub-directory. Simple pages have a dedicated subdirectory there with one twig file per language. Example:
`templates/pages/imprint/imprint.de.html.twig` is the German version of the imprint page.

The templates can be edited with a text editor. They do contain simple HTML, though you can update text without
understanding the HTML. With basic understanding of HTML you can change the structure of the page. Though beware
that you will only be changing the structure of one language version of the page.

GitHub editing links:

* [Charter - German](https://github.com/wmde/website/edit/master/templates/pages/charter/charter.de.html.twig)
* [Charter - English](https://github.com/wmde/website/edit/master/templates/pages/charter/charter.en.html.twig)
* [Imprint - German](https://github.com/wmde/website/edit/master/templates/pages/imprint/imprint.de.html.twig)
* [Imprint - English](https://github.com/wmde/website/edit/master/templates/pages/imprint/imprint.en.html.twig)
* [Transparency - German](https://github.com/wmde/website/edit/master/templates/pages/transparency/transparency.de.html.twig)
* [Transparency - English](https://github.com/wmde/website/edit/master/templates/pages/transparency/transparency.en.html.twig)

## Development

The application is build on top of the Symfony 4 PHP web framework.

Development is done via Docker. No local PHP installation is needed.

### Installing the application

    make install

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

## Deployment

Standard deployment practices for Symfony 4 applications can be followed. See
[How to Deploy a Symfony Application](https://symfony.com/doc/current/deployment.html)

However since the website does not currently have a database or uses compiled assets, many steps can be skipped.

Get a clone of the git repository

	git clone https://github.com/wmde/website.git
	
Then follow steps A through D from the section
"[Common Post-Deployment Tasks](https://symfony.com/doc/current/deployment.html#common-post-deployment-tasks)".

### Updating to a new version

1. `git pull` - get the latest version of the site
2. `composer install` - install the dependencies (`make install` if you have Docker instead of PHP)

### Deployment guidelines

* Only code from master (on GitHub!!!) can be deployed on the server
* Only gitignored files such as configuration can be changed on the server directly
* The site should be deployed in production mode (see `.env`)
