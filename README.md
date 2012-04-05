FeedDataStore for Cumula
========================

Provides an RSS and Atom read-only datastore for Cumula, using [SimplePie](http://www.simplepie.org).

Using in your project
---------------------

Add `cumula/feed-datastore` to your composer.json dependency list and update.

Installing dependencies for development
---------------------------------------

Use [`composer.phar`](http://getcomposer.org/composer.phar) and run:

  ` php composer.phar install`

Running tests
-------------

We use [phing](http://www.phing.info/) to run [phpunit](https://github.com/sebastianbergmann/phpunit/) tests. (If your OS package manager provides these it'll make sense to install them that way). Once dependencies are installed, you can run tests with:

  ` phing test`
