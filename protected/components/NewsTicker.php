<?php
Yii::import('system.web.widgets.CWidget');

class NewsTicker extends CWidget
{
    public function run()
    {
        $search = "from%3Atelemedellin%20#NTMed";
		$notweets = 4;
		$consumerkey = "lvX5ZuwYkNNFwaYaLz0Rw";
		$consumersecret = "tkEfo98Xcpg0rYphooAetOSVjBcYEXhM4pKTGh1Bw";
		$accesstoken = "44186827-6qP8bJ2cRD5Hwkol6hJn782lzSEprym5tyVI4mAc5";
		$accesstokensecret = "xI07T7D9S6E6jnEQ2muSYD1kSBIATRkGgKM3C6w";
		  
		  
		$connection = Yii::app()->twitter->getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
		 
		$search = str_replace("#", "%23", $search); 
		$tweets = $connection->get("https://api.twitter.com/1.1/search/tweets.json?q=".$search."&count=".$notweets);

        $this->render('newsticker', array('tweets' => $tweets->statuses));
    }
}