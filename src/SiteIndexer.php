<?php

class SiteIndexer {

	public $domains         = array();
	public $filename_prefix = '';

	public function __construct( $domains = array(), $filename_prefix = '' ) {
		$this->domains         = $domains;
		$this->filename_prefix = $filename_prefix;
	}

	public function start() {
		if ( empty( $this->domains ) ) {
			printf( "No domains found. Please provide domains to begin crawling for data." );
			exit;
		}
		printf( "Preparing to crawl %d domains...\n", count( $this->domains ) );

		$doc                     = new DOMDocument();
		$doc->preserveWhiteSpace = FALSE;

		$data      = array();
		foreach ( $this->domains as $domain ) {
			@$doc->loadHTMLFile( $domain );
			$xpath  = new DOMXPath( $doc );

			$title = $this->getPageTitle( $xpath );
			printf( "%s\n", $title );

			$content = $this->getPageContent( $xpath );

			$data[] = array(
				'url'     => $domain,
				'title'   => $title,
				// 'content' => $content,
			);
		}

		$this->output( $data );

		echo "JSON file created.\n";
	}

	private function getPageTitle( $xpath ) {
		$title = $xpath->query( './/title' )->item(0);
		return utf8_decode( $title->textContent );
	}

	private function getPageContent( $xpath ) {
		$container = $xpath->query( './/main' )->item(0);
		$textnodes = $xpath->query( './/text()', $container );

		$content = '';
		if ( $textnodes !== FALSE && count($textnodes) > 0 ) {
			foreach ( $textnodes as $textnode ) {
				if ( trim($textnode->textContent) !== '' ) {
					$content .= trim( $textnode->textContent );
				}
			}
		}
		return utf8_decode( $content );
	}

	private function output( $data ) {
		$path = __DIR__ . '/../dist/' . $this->filename_prefix . 'index.json';
		$fp = fopen( $path , 'w' );
		fwrite( $fp, json_encode( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) );
		fclose( $fp );
	}
}
