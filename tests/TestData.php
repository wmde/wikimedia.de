<?php

declare( strict_types = 1 );

namespace App\Tests;

class TestData {

	public static function getFileContents( string $fileName ): string {
		return file_get_contents( self::getFilePath( $fileName ) );
	}

	public static function getFilePath( string $fileName ): string {
		return __DIR__ . '/data/' . $fileName;
	}

}
