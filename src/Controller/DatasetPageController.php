<?php

declare( strict_types = 1 );

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// TODO: remove once the template dummy is no longer used
use Symfony\Component\Yaml\Yaml;

class DatasetPageController extends Controller {

	// load CSV file and return contents as nested array
	private function csvAsArray($csvPath){
		// thanks to durik at 3ilab dot net for pointing out we need 2 str_getcsv() parsers for rows/columns, see
		// https://secure.php.net/manual/en/function.str-getcsv.php#101888
		$csv = [];
		foreach(
			str_getcsv( file_get_contents( $this->container->getParameter( 'kernel.project_dir' ).$csvPath ), "\n" )
			as
			$row
		) {
			$csv[] = str_getcsv( $row );
		}
		return $csv;
	}

	// convert csv array to key/value objects per row
	// keys get supplied separately
	private function csv2object( array $csv, array $keys ): array {
		$items = [];
		foreach ( $csv as $row ) {
			$item = [];
			foreach ( $keys as $index => $key ) {
				$value = isset( $row[$index] ) ? $row[$index] : '';
				$item[$key] = $value;
			}
			$items[] = $item;
		}
		return $items;
	}

	// group array in sub-arrays
	// TODO: currently, only 1 root key is supported by argument,
	//       we should be able to dive deeper via an array like [ 'title' , 'de' ]
	function groupBy( array $array, string $key ): array {
		$groups = [];
		$groupsLookup = [];
		foreach ( $array as $item ) {
			if ( isset( $item[$key] ) ) {
				$groupBy = $item[$key];

				// value not yet encountered? register grouping value in lookup
				// TODO: test framework decided, this is one nesting too many, d'uh!
				if ( !in_array( $item[$key], $groupsLookup ) ) {
					$groupsLookup[] = $groupBy;
				}

				// groups are filled in order of first encounter of key value
				$groups[array_search( $groupBy,$groupsLookup )][] = $item;

			}
		}
		return $groups;
	}

	private function peopleParse($templatePath, $csvPath) {
		$data = [];

		// 1. loading team table as data source
		$csv = $this->csvAsArray($csvPath);

		// 2. key handling

		// split first line (column headings)
		$keysOrig = array_shift( $csv );

		// note:
		// instead of mapping, we could actually use the csv headings
		// but we settle for simple ids for now
		$keys = [
			'delta', // 'Nummer'
			'firstname', // 'Vorname'
			'lastname', // 'Nachname'
			'title_de', // 'Stellenbezeichnung (de)'
			'title_en', // 'Stellenbezeichnung (en)'
			'mail', // 'E-Mail (geschäftlich)'
			'domain_de', // 'Bereich (de)'
			'domain_en', // 'Bereich (en)'
			'team_de', // 'Team (de)'
			'team_en', // 'Team (en)'
			'imgsrc' //' BildLink
		];

		$items = $this->csv2object( $csv, $keys );

		// 3. modify item datasets

		// add image sources
		// this should be handled by an extra column, for now we only remove the path and assume the files under
		// /files/staff/*.*
		foreach( $items as &$item ) {
			$item['img'] = pathinfo( $item['imgsrc'] )['basename'];
		}

		// TODO: supply multilingual strings per template
		// TODO: split team and domain titles to de/en

		// 4. group datasets by domains and teams

		$data['domains'] = [];
		foreach(
			$this->groupBy( $items, 'domain_de' )
			as $domainItems
		) {
			// preparing domain object
			$domain = [
				// assuming identical titles due to grouping
				// TODO: multilanguage
				'title' => $domainItems[0]['domain_de'],
				'teams' => []
			];

			foreach ( $this->groupBy( $domainItems, 'team_de' ) as $team ) {
				// preparing team object
				$domain['teams'][] = [
					// assuming identical titles due to grouping
					// TODO: multilanguage
					'title' => $team[0]['team_de'],
					'members' => $team
				];
			}

			$data['domains'][] = $domain;

		}

		return $this->render( $templatePath , $data );

	}

	public function peopleStaff( Request $request ): Response {
		return $this->peopleParse('pages/people/staff.html.twig', '/templates/pages/people/staff.csv');
	}

	public function peopleBoard( Request $request ): Response {
		return $this->peopleParse('pages/people/board.html.twig', '/templates/pages/people/board.csv');
	}

	public function themes( Request $request ): Response {
		$path = '/pages/topics-draft';
		$preview = Yaml::parse( file_get_contents( __DIR__.'/../../templates'.$path.'.html.yaml' ) );

		// we're assuming a data pattern w/ keys `template` and `data` on root
		return $this->render( $preview['template'], $preview['data'] );
	}


}
