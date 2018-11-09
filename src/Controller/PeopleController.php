<?php

declare( strict_types = 1 );

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Yaml\Yaml;

class PeopleController extends Controller {

	public function staff( Request $request ): Response {
		$preview = Yaml::parse( file_get_contents( __DIR__.'/../../templates/pages/team-draft.html.yaml' ) );

		$csv = str_getcsv(file_get_contents( $this->container->getParameter('kernel.project_dir').'/templates/pages/people/staff.csv' ));

		// split first line (column headings)
		$keysOrig = array_shift($csv);

		// note:
		// instead of mapping, we could actually use the csv headings
		// but we settle for simple ids for now
		$keys = [
			'firstname', // "Vorname"
			'lastname', // "Nachname"
			'title_de', // "Stellenbezeichnung (de)"
			'title_en', // "Stellenbezeichnung (en)"
			'mail', // "E-Mail (geschäftlich)"
			'domain_de', // "Bereich (de)"
			'domain_en', // "Bereich (en)"
			'team_de', // "Team (de)"
			'team_en', // "Team (en)"
			'imgsrc' //" BildLink
		];

		// TODO: convert staff.csv to team template object

		// $data =
		// "domains" => [
		//		…
		// ]

		// we're assuming a data pattern w/ keys `template` and `data` on root
		return $this->render( $preview['template'], $preview['data'] );
	}

}
