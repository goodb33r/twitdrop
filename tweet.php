<?php

/*
	Airdrop Twitter Task Helper ( Follow, Like, Retweet Quote )
	Crafted by Viloid ( github.com/vsec7 )
	Dependency : github.com/abraham/twitteroauth
*/

require 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

echo "Target RT: ";
$s = trim(fgets(STDIN));
echo "Hashtag: ";
$t = trim(fgets(STDIN));

// Edit tweet.txt with your message
$txt = file_get_contents("tweet.txt");

$q = "$txt $t $s";
$data = explode("/", $s);

// Configurations
// Get API key & secret from https://developer.twitter.com
// Make sure your APP Token set "write" permissions

$consumer_key        = '';MfGgyXBysJ6AqtAHs9SX2bC8X
$consumer_secret     = '';A7tzNoGlKh8FtxmiVNVnLPs8nCCfrUtzTXoFgZyVllarNBBhVK
$access_token        = '';1381872579976171522-Gm5gwVg09Lv2I3SHPYF1u7ziYjdHXs
$access_token_secret = '';s4P1xiZMicLJoBEVrsSEWRKz3JELS6jr3v6lvACSdAh0C

$conn = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
$conn->get('account/verify_credentials');

if ($conn->getLastHttpCode() == 200) {
    
  $conn->post('friendships/create', ['screen_name' => $data[3]]);
  if ($conn->getLastHttpCode() == 200) {
    echo "[+] Follow @". $data[3]." : Success\n";
  } else {
    echo "[+] Follow @". $data[3]." : Failed\n";
  }

  $conn->post('favorites/create', ['id' => $data[5]]);
  if ($conn->getLastHttpCode() == 200) {
    echo "[+] Like : Success\n";
  } else {
    echo "[+] Like : Failed\n";
  }

  $rt = $conn->post('statuses/update', ['status' => $q]);
  if ($conn->getLastHttpCode() == 200) {
    echo "[+] RT Link : https://twitter.com/" . $rt->user->screen_name . "/status/" .$rt->id."\n";
  } else {
    echo "[+] RT : Failed\n";
  }

} else {
  echo 'Invalid API Key!';
}

