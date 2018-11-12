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

		// thanks to durik at 3ilab dot net for pointing out we need 2 str_getcsv() parsers for rows/columns, see
		// https://secure.php.net/manual/en/function.str-getcsv.php#101888
		$csv = [];
		foreach(
			str_getcsv( file_get_contents( $this->container->getParameter('kernel.project_dir').'/templates/pages/people/staff.csv' ), "\n")
			as
			$row
		) {
			$csv[] = str_getcsv( $row );
		}

		// split first line (column headings)
		$keysOrig = array_shift($csv);

		// note:
		// instead of mapping, we could actually use the csv headings
		// but we settle for simple ids for now
		$keys = [
			'delta', // "Nummer"
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

		// TODO: create keys for groups
		// TODO: supply multilingual strings per template
		// TODO: split team and domain titles to de/en

		// $data =
		// "domains" => [
		//		…
		// ]

		// convert csv array to key/value objects per row
		$items = [];
		foreach ($csv as $row) {
			$item = [];
			foreach ($keys as $index => $key) {
				$value = isset($row[$index]) ? $row[$index] : "";
				$item[$key] = $value;
			}
			$items[] = $item;
		}

		// TODO: currently, only 1 root key is supported by argument,
		// we should be able to dive deeper via an array like [ 'title' , 'de' ]
		function groupBy($array, $key){
			$groups = [];
			$groupsLookup = [];
			foreach ($array as $item) {
				if (isset($item[$key])) {
					$groupBy = $item[$key];

					// value not yet encountered? register grouping value in lookup
					if (!in_array($item[$key], $groupsLookup)) {
						$groupsLookup[] = $groupBy;
					}

					// groups are filled in order of first encounter of key value
					$groups[array_search($groupBy,$groupsLookup)][] = $item;

				}
			}
			return $groups;
		}

		// grouping by domain
		$items = groupBy($items, "domain_de");

		// grouping by team per domain
		foreach ($items as &$domain) {
			$domain = groupBy($domain, "team_de");
		}

		// we're assuming a data pattern w/ keys `template` and `data` on root
		return $this->render( $preview['template'], $preview['data'] );
	}

}
