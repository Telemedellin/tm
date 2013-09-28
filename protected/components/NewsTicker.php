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

		$nuevos_tweets = array();

		foreach ($tweets->statuses as $tweet) {
	        $texto_original = $tweet->text;
	        $texto_nuevo = '';
	        $ultimo_indice = 0;
	        $entidades = array();
	        if( count($tweet->entities->hashtags) )
	        {
	          foreach ($tweet->entities->hashtags as $hashtag) {
	            $nh = '<s>#</s><b class="hashtag">' . $hashtag->text . '</b>';
	            $entidades[] = array('texto' => $nh, 'pi' => $hashtag->indices[0], 'pf' => $hashtag->indices[1]);
	          }
	        }
	        if( count($tweet->entities->user_mentions) )
	        {
	          foreach ($tweet->entities->user_mentions as $user_mention) {
	            $num = '<s>@</s><b class="user_mention">' . $user_mention->screen_name . '</b>';
	            $entidades[] = array('texto' => $num, 'pi' => $user_mention->indices[0], 'pf' => $user_mention->indices[1]);
	          }
	        }
	        usort($entidades, "NewsTicker::ceo");
	        for($i=0; $i < count($entidades); $i++){
	          $pedazo = mb_substr($texto_original, $ultimo_indice, ($entidades[$i]['pi'] - $ultimo_indice), 'UTF-8' );
	          $texto_nuevo .= $pedazo;
	          $texto_nuevo .= $entidades[$i]['texto'];
	          $ultimo_indice = $entidades[$i]['pf'];
	        }
	        $texto_nuevo .= mb_substr($texto_original, $ultimo_indice, 200, 'UTF-8');
	        $nuevos_tweets[] = $texto_nuevo;
	    }

        $this->render( 'newsticker', array('tweets' => $nuevos_tweets) );
    }

    public static function ceo($a, $b)
    {
        return ($a['pi'] < $b['pi']) ? -1 : 1;
    }
}