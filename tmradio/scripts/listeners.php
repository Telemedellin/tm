<?php
//-----------------------------------------------------------------------------------------------------------------
// Icecast2/Shoutcast Station Status 2.0  Php Module  - Dards, WhooshStream.com
// Description: this module use to grab the icecast server status and generate an xml data for AAC+ Flash player
// Note: the fsockopen php function must be enabled on your server for this script to work
//-----------------------------------------------------------------------------------------------------------------



$host 		=	"real2.streaming-co.com"; 		// ip or url of shoutcast server
$port 		=	"8306";          		// port of shoutcast server 
$servertype	=	"icecast";			// shoutcast / icecast



// no do not edit the code below----------------------------------------------------------------------------------- 
$fp = @fsockopen($host, $port, $errno, $errstr, 30);
if($fp)
{
	$servertype=strtolower($servertype);
	switch($servertype){
		case "shoutcast":
			fputs($fp,"GET /7.html HTTP/1.0\r\nUser-Agent: GET SEVEN (Mozilla Compatible)\r\n\r\n");
		break;	
		case "icecast":
		fputs($fp,"GET /status2.xsl HTTP/1.0\r\nUser-Agent: GET SEVEN (Mozilla Compatible)\r\n\r\n");
		break;
	}
	$data="";
	while(!feof($fp))
	{
		$data .= fgets($fp, 1000);
	}
	fclose($fp);
	$data              = ereg_replace(".*<body>", "", $data);
	$data              = ereg_replace("</body>.*", ",", $data);
	$data_array        = explode(",",$data);
	
	//print_r($data_array);
 
	switch($servertype){
		case "shoutcast":
			$listeners         = $data_array[0];
			$status            = $data_array[1];
			$peak_listeners    = $data_array[2];
			$maximum_listeners = $data_array[3];
			$unique_listeners  = $data_array[4];
			$bitrate           = $data_array[5];
			$track             = $data_array[6];
		break;	
		case "icecast":
			$bitrate           = "32k";
			$unique_listeners  = $data_array[14];
			$track             = $data_array[16];		
		break;
	}

 
	$title  = chop($track);
	$select = explode(" - ",$title);
	$artist = chop($select[0]);
	
	if(count($select)<2){
		$title  = chop($select[0]);
	}else{
		$title  = chop($select[1]);	
	}
	
	header ("content-type: text/xml");
	echo "<?xml version=\"1.0\" standalone=\"yes\"?>\n";
	echo "<status>\n";
	echo "	<status>on</status>\n";
	echo "	<listeners>$unique_listeners</listeners>\n";
	echo "	<peaklisteners>0</peaklisteners>\n";
	echo "	<bitrate>$bitrate</bitrate>\n";
	echo "	<artist><![CDATA[$artist]]></artist>\n";
	echo "	<title><![CDATA[$title]]></title>\n";
	echo "</status>\n"; 
}else{
	header ("content-type: text/xml");
	echo "<?xml version=\"1.0\" standalone=\"yes\"?>\n";
	echo "<status>\n";
	echo "	<status>off</status>\n";
	echo "	<listeners>0</listeners>\n";
	echo "	<peaklisteners>0</peaklisteners>\n";
	echo "	<bitrate>0</bitrate>\n";
	echo "	<artist><![CDATA[]]></artist>\n";
	echo "	<title><![CDATA[]]></title>\n";
	echo "</status>\n"; 
}
?>