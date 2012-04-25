<?php
namespace FeedDataStore;

/**
 * Feed Data Service
 * @package FeedDataService
 * @author Craig Gardner <craig.s.gardner@gmail.com>
 **/
class FeedDataService extends \Cumula\Base\DataService {
    
	/**
	 * Class Constructor
	 * @param array $config
	 **/
	public function __construct($config) {
		parent::__construct($config);
		if (!isset($config['url'])) {
			throw new \Exception('Config must contain "url" with a valid RSS Feed URL key as the value.');
		}

		$this->url = $config['url'];
	} // end function __construct

	/**
	 * Get the items for the current feed
	 **/
	public function getItems() {
		$feed = $this->get($this->url);
		$xml = simplexml_load_string($feed['response']);
		$feedItems = array();
		if ($xml) {
			foreach ($xml->channel->item as $item) {
				$feedItems[] = array(
					'title' => (string)$item->title,
					'link' => (string)$item->link,
					'pubDate' => (string)$item->pubDate,
					'description' => (string)$item->description,
				);
			}
		}
		return $feedItems;
	} // end function getItems
} // end class FeedDataService extends \Cumula\Base\DataService
