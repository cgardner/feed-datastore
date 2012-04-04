<?php
namespace FeedDataStoreFactory;

require_once dirname(__FILE__) . '/lib/SimplePie.compiled.php';


class FeedDataStore extends \Cumula\DataStore\ReadOnlyDataStore {
	public $_storage;
	public $_fields = array(
		'id',
		'title',
		'url',
		'description',
		'author',
		'date'
		);
	public $useragent = 'Cumula/0.5';
		
	public function __construct() {
		parent::__construct();
		$this->_storage =  new \SimplePie();
		$this->_storage->set_useragent($this->useragent);
	}

	public function setup($fields, $id, $name, $configValues) {
		parent::setup($this->_fields, 'id', $name, $configValues);
		$this->setConfig($configValues);
	}

	public function setConfig($configValues) {
		$this->_storage->set_feed_url($configValues['url']);
		$cache = array_get('cache_directory', $configValues, DATAROOT.DIRECTORY_SEPARATOR.'cache');
		if (!file_exists($cache)) {
			mkdir($cache, 0775, true);
		}
		$this->_storage->set_cache_location($cache);
	}

	public function connect() {
		$this->_storage->init();
	}
	public function disconnect() {
		
	}
	
	public function query($args, $order = null, $limit = 10, $start=0) {
		$items = $this->_storage->get_items($start, $limit);
		$ret = array();
		foreach($items as $item) {
			$author = $item->get_author();
			if ($author) {
				$author = $author->get_name();
			} else {
				$author = '';
			}
			$obj = $this->newObj(
				array(
					'id' => $item->get_id(),
					'title' => $item->get_title(),
					'url' => $item->get_link(0),
					'description' => $item->get_description(),
					'author' => $author,
					'date' => $item->get_date(),
					));
			// TODO: fixed schema
			$obj = $this->prepareLoad($obj);
			$ret[] = $obj;
		}
		return $ret;
	}

	public function findRecent($limit, $start, $startFrom=false, $field='date') {
		return $this->query(null, null, $limit, $start);
	}

}