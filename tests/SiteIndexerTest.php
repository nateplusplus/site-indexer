<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../__mocks__/domains.php';
require_once __DIR__ . '/../src/SiteIndexer.php';

class SiteIndexerTest extends TestCase {
    public function testClassInitializesWithoutArgments() {
        $this->assertInstanceOf( SiteIndexer::class, new SiteIndexer );
    }
    public function testDomainsAreSet() {
        global $mock_domains;
        $site_crawler = new SiteIndexer( $mock_domains );
        $this->assertEquals( $site_crawler->domains[0], $mock_domains[0] );
    }
    public function testFilenamePrefixIsSet() {
        global $mock_domains;
        $site_crawler = new SiteIndexer( $mock_domains, 'test' );
        $this->assertEquals( $site_crawler->filename_prefix, 'test' );
    }
}