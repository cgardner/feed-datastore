<?php

use \FeedDataStore\FeedDataStore as DS;


class Test_FeedDataStoreFactory extends \Cumula\Test\Base {

	public function testConstructor() {
		$ds = new DS();
		$this->assertInstance($ds, 'FeedDataStoreFactory\FeedDataStoreFactory');
	}

	public function testQueryRss() {
		$ds = new DS();
		$config = array(
			'url' => realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'test.rss'
			);
		$ds->setup(null, null, null, $config);
		$ds->connect();
		$item = $ds->query(array());
		$this->assertEquals(count($item), 10);
		$item = $item[0];
		$this->assertEq($item->title, 'Incentive Auctions:  The Concept Ratified, and the Work Begins');
		$this->assertEq($item->url, 'http://www.fcc.gov/blog/incentive-auctions-concept-ratified-and-work-begins');
		$this->assertEq($item->id, '38585 at http://www.fcc.gov');
		$this->assertEq($item->description, '');
	}

	public function testQueryAtom() {
		$config = array(
			'url' => realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'test.atom'
			);
		$ds->setup(null, null, null, $config);
		$ds->connect();
		$item = $ds->query(array());
		$this->assertEquals(count($item), 1);
		$item = $item[0];
		$this->assertEq($item->title, 'Atom-Powered Robots Run Amok');
		$this->assertEq($item->url, 'http://example.org/2003/12/13/atom03');
		$this->assertEq($item->id, 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a');
		$this->assertEq($item->description, 'Some text.');
	}

}
