<?php
Yii::import('system.web.widgets.CWidget');

class NewsTicker extends CWidget
{
    public function run()
    {
		$nuevos_tweets = Yii::app()->cache->get('tweets');
		if($nuevos_tweets === false){
			$nuevos_tweets = $this->obtener_tuits();
		}
        $this->render( 'newsticker', array('tweets' => $nuevos_tweets) );
    }

    public static function ceo($a, $b)
    {
        return ($a['pi'] < $b['pi']) ? -1 : 1;
    }

    private function obtener_tuits()
    {
    	$search = "from%3Atelemedellin%20#NTMed";
		$notweets = 6;
		$consumerkey = "lvX5ZuwYkNNFwaYaLz0Rw";
		$consumersecret = "tkEfo98Xcpg0rYphooAetOSVjBcYEXhM4pKTGh1Bw";
		$accesstoken = "44186827-6qP8bJ2cRD5Hwkol6hJn782lzSEprym5tyVI4mAc5";
		$accesstokensecret = "xI07T7D9S6E6jnEQ2muSYD1kSBIATRkGgKM3C6w";
		  
		$connection = Yii::app()->twitter->getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
		 
		$search = str_replace("#", "%23", $search); 
		$tweets = $connection->get("https://api.twitter.com/1.1/search/tweets.json?q=".$search."&count=".$notweets);

    	$nuevos_tweets = array();

    	if(!empty($tweets))
    	{
	    	foreach ($tweets->statuses as $tweet) {
				if(substr($tweet->text, 0, 2) == 'RT') continue;
		        $texto_original = $tweet->text;
		        $texto_nuevo = '';
		        $ultimo_indice = 0;
		        $entidades = array();
		        if( count($tweet->entities->hashtags) )
		        {
		          foreach ($tweet->entities->hashtags as $hashtag) {
		            $nh = '<a href="https://twitter.com/search?q=%23NTMed" target="_blank" rel="nofollow"><s>#</s><b class="hashtag">' . $hashtag->text . '</b></a>';
		            $entidades[] = array('texto' => $nh, 'pi' => $hashtag->indices[0], 'pf' => $hashtag->indices[1]);
		          }
		        }
		        if( count($tweet->entities->user_mentions) )
		        {
		          foreach ($tweet->entities->user_mentions as $user_mention) {
		            $num = '<a href="https://twitter.com/'.$user_mention->screen_name.'" target="_blank" rel="nofollow"><s>@</s><b class="user_mention">' . $user_mention->screen_name . '</b></a>';
		            $entidades[] = array('texto' => $num, 'pi' => $user_mention->indices[0], 'pf' => $user_mention->indices[1]);
		          }
		        }
		        if( count($tweet->entities->urls) )
		        {
		          foreach ($tweet->entities->urls as $url) {
		            $nu = '<a href="'.$url->expanded_url.'" target="_blank" rel="nofollow" class="tlink">' . $url->url . '</a>';
		            $entidades[] = array('texto' => $nu, 'pi' => $url->indices[0], 'pf' => $url->indices[1]);
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
		    Yii::app()->cache->set('tweets', $nuevos_tweets, 300);
		}
		
	    return $nuevos_tweets;
    }
}