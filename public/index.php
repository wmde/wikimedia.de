<?php

// Template query? Hijacking PHP request before Symfony kicks in
// query is everything after `/templates/` + trailing slash in case it's `/templates`

$templateQuery = explode('/templates/',$_SERVER['REQUEST_URI'].'/');

//prep YAML loader
//sorry, this should rather go in some templateQuery class
use Symfony\Component\Yaml\Yaml;
require_once __DIR__ . '/../vendor/autoload.php';

if ( count ( $templateQuery ) > 1 ) {

	// kill potential trailing slash(es)
	$query = preg_replace('/[\/]*$/' , '', $templateQuery[1] );

	// this is supposed to have the name of the query w/ `tpl.yaml` extension
	$queryFile = __DIR__.'/../templates/'.$query.'.html.yaml';

	// no template definition – no output
	if (!file_exists($queryFile)) { return; }

	// read YAML template def file
	$data = Yaml::parse( file_get_contents($queryFile) );

	// init Twig interpreter
	$loader = new Twig_Loader_Filesystem('../templates');
	$template = new Twig_Environment($loader,['debug'=>true]);
	// + debugger
	$template->addExtension(new \Twig_Extension_Debug());

	// output template
	echo $template->load($data['template'])->render($data['data']);

	// stop PHP propagation
	return;
}

// start of actual Symfony application

use App\Kernel;
use App\TopLevelFactory;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../vendor/autoload.php';

// The check is to ensure we don't use .env in production
if ( !isset( $_SERVER['APP_ENV'] ) ) {
	if ( !class_exists( Dotenv::class ) ) {
		throw new \RuntimeException(
			'APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.'
		);
	}
	( new Dotenv() )->load( __DIR__ . '/../.env' );
}

$env = $_SERVER['APP_ENV'] ?? 'dev';
$debug = (bool)( $_SERVER['APP_DEBUG'] ?? ( 'prod' !== $env ) );

if ( $debug ) {
	umask( 0000 );

	Debug::enable();
}

if ( $trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? false ) {
	Request::setTrustedProxies(
		explode( ',', $trustedProxies ),
		Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST
	);
}

if ( $trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? false ) {
	Request::setTrustedHosts( explode( ',', $trustedHosts ) );
}

$kernel = new Kernel( $env, $debug );
$request = Request::createFromGlobals();
$response = $kernel->handle( $request );
$response->send();
$kernel->terminate( $request, $response );
