<?php


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

	// shimming `asset()` template call – return input value
	$functionAsset = new Twig_SimpleFunction('asset', function ($file) {
		return $file;
	});
	$template->addFunction($functionAsset);

	// shimming `path()` template call – return root path
	$functionPath = new Twig_SimpleFunction('path', function () {
		return '/';
	});
	$template->addFunction($functionPath);


	// TODO: add `{% trans %}… {% endtrans %}` token parser

	// output template
	echo $template->load($data['template'])->render($data['data']);

	// stop PHP propagation
	// TODO: would be nicer w/ a return clause, but more complicated on includes
	die;
}
