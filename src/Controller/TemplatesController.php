<?php

declare( strict_types = 1 );

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Yaml\Yaml;

class TemplatesController extends Controller {

	public function preview( Request $request, $path ): Response {
		// note: the route comes w/ a $path enviroment variable, see
		// /config/routes.yaml


		$preview = Yaml::parse( file_get_contents(__DIR__.'/../../templates/'.$path.'.html.yaml') );

		// we're assuming a data pattern w/ keys `template` and `data` on root
		return $this->render( $preview['template'], $preview['data'] );
	}

}
