<?php

declare( strict_types = 1 );

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Yaml\Yaml;

class TemplatesController extends Controller {

	public function preview( Request $request ): Response {

		// TODO: use a request part instead of hardcoded
		$previewPath = 'pages/team-draft';

		$preview = Yaml::parse( file_get_contents(__DIR__.'/../../templates/'.$previewPath.'.html.yaml') );

		// we're assuming a data pattern w/ keys `template` and `data` on root
		return $this->render( $preview['template'], $preview['data'] );
	}

}
