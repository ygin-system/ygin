Feed Writer Generator Extension to create your feeds. Currently supports RSS 1.0, RSS 2.0 and ATOM 1.0.

##Requirements  
- Developed using Yii version 1.1.5    

##Usage
Unzip the contents of the package and place it on your protected/extensions folder.

**Examples of use**

RSS 1.0

~~~

Yii::import('ext.feed.*');

// specify feed type
$feed = new EFeed(EFeed::RSS1);
$feed->title = 'Testing the RSS 1 EFeed class';
$feed->link = 'http://www.ramirezcobos.com';
$feed->description = 'This is test of creating a RSS 1.0 feed by Universal Feed Writer';
$feed->RSS1ChannelAbout = 'http://www.ramirezcobos.com/about';
// create our item	
$item = $feed->createNewItem();
$item->title = 'The first feed';
$item->link = 'http://www.yiiframework.com';
$item->date = time();
$item->description = 'Amaz-ii-ng <b>Yii Framework</b>';
$item->addTag('dc:subject', 'Subject Testing');
		
$feed->addItem($item);
		
$feed->generateFeed();
~~~

RSS 2.0

~~~

Yii::import('ext.feed.*');
// RSS 2.0 is the default type
$feed = new EFeed();

$feed->title= 'Testing RSS 2.0 EFeed class';
$feed->description = 'This is test of creating a RSS 2.0 Feed';

$feed->setImage('Testing RSS 2.0 EFeed class','http://www.ramirezcobos.com/rss',
'http://www.yiiframework.com/forum/uploads/profile/photo-7106.jpg');

$feed->addChannelTag('language', 'en-us');
$feed->addChannelTag('pubDate', date(DATE_RSS, time()));
$feed->addChannelTag('link', 'http://www.ramirezcobos.com/rss' );

// * self reference
$feed->addChannelTag('atom:link','http://www.ramirezcobos.com/rss/');

$item = $feed->createNewItem();

$item->title = "first Feed";
$item->link = "http://www.yahoo.com";
$item->date = time();
$item->description = 'This is test of adding CDATA Encoded description <b>EFeed Extension</b>';
// this is just a test!!
$item->setEncloser('http://www.tester.com', '1283629', 'audio/mpeg');

$item->addTag('author', 'thisisnot@myemail.com (Antonio Ramirez)');
$item->addTag('guid', 'http://www.ramirezcobos.com/',array('isPermaLink'=>'true'));

$feed->addItem($item);

$feed->generateFeed();
Yii::app()->end();
~~~

ATOM 1.0

~~~
Yii::import('ext.feed.*');


$feed = new EFeed(EFeed::ATOM);
		
// IMPORTANT : No need to add id for feed or channel. It will be automatically created from link.
$feed->title = 'Testing the ATOM RSS EFeed class';
$feed->link = 'http://www.ramirezcobos.com';
		
$feed->addChannelTag('updated', date(DATE_ATOM, time()));
$feed->addChannelTag('author', array('name'=>'Antonio Ramirez Cobos'));
		
$item = $feed->createNewItem();

$item->title = 'The first Feed';
$item->link  = 'http://www.ramirezcobos.com';
// we can also insert well formatted date strings
$item->date ='2010/24/12';
$item->description = 'Test of CDATA Encoded description <b>EFeed Extension</b>';
		
$feed->addItem($item);

$feed->generateFeed();
~~~

##Change Log  
*  v.1.3 Added stylesheet support 
*  v.1.2 Added support for [atom:link](http://workbench.cadenhead.org/news/3284/adding-atomlink-your-rss-feed "") 
*  v.1.1 Fixed bug on EFeedItemAtom thanks to [Flokey82](http://www.yiiframework.com/forum/index.php?/user/25919-flokey82/ "Flokey")

##Resources
 * [GitHub repository](https://github.com/tonydspaniard/Yii-extensions)  
 * [Forum Post](http://www.yiiframework.com/forum/index.php?/topic/14663-extension-efeed-extension/)
