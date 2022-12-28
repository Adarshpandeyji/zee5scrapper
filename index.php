<?php

$url =$_GET['c'];
if($url !=""){
$id = end(explode('/', $url));
$tlink ="https://apiv2.sonyliv.com/AGL/3.0/A/ENG/MWEB/IN/JH/CONTENT/VIDEOURL/VOD/$url/freepreview";

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $tlink,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Security_Token: eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpYXQiOjE2NzIyMTE5MTQsImV4cCI6MTY3MzUwNzkxNCwiYXVkIjoiKi5zb255bGl2LmNvbSIsImlzcyI6IlNvbnlMSVYiLCJzdWIiOiJzb21lQHNldGluZGlhLmNvbSJ9.PUgmKteYphsKnk7naE98dh9hnhNrRNlzHoZwmmnkK6jA8up7pxe62LXWobu2U5Q_jCXFz4RR642aeGXgTS9xPmqgyxwqv3E-EVjqvVvtESLTp9VAwjf57YKXHhs9Z4aLpCDSyDltfCtSOQQh8qLQMd177MsbraJ2nco_M5p8YMkDrXKj79irMSg1oZR0UyFlIjsjht0HBvCAE0or1U3fDyjKy4qzr2L3HJDi9A0Bj82rfQenBLtix7bDfeyNJEvVp0r86KP_sAoiUoc0pfnbU4Xti-MhX0AGK0JBAXJhVFV8udgeFsxorAdeXz5PpCGrbjQ_3NJIylZ78ATlCdzjG7SNBH4N2xUUaIciwKZK2mTUeHtSoW6w9oJkWUxuYzAoGhngO8rxNNqGyJ8aNqjNQyWe1dlEq28JrQVY08KhB5QJ7LLzh_UeaGoF4gSshyq05b1KPe8hXumFiaTaD-bHtdiucs2kDTCoqyO2dJy3ei4YSCfoxOnvb0uLBoZxXSIVSMiKVNmnMyClL9Zd1OXymwyqG9WFDYe3S51vKQUK1Lono3vBr7ezq5JMM8jVRzrBurUtqpY8yVWZQW5PoWYaH828nyCzJ6NmOZsNa_jPxVNydLwK8Rd9CQWbtuyM-CGSNj2wiPNK6nEh-HipyVDjcgySoyl77-YOoHgiyjdK4_c",
    "Content-Type: application/json"
  ),
));
$response = curl_exec($curl);
curl_close($curl);

$z5 =json_decode($response, true);
$image =$z5['image_url'];
$cover =$z5['cover_image'];
$title =$z5['title'];
$des =$z5['description'];
$release =$z5['release_date'];
$actor =$z5['actors'];
$gen =$z5['genre'][0]['id'];
$gen1 =$z5['genre'][1]['id'];
$lang =$z5['languages'];

$vhls =$z5['hls'][0];
$vdash =$z5['video'][0];

$sub =$z5['video_details']['vtt_thumbnail_url'];
$drmkey = $z5['drm_key_id'];
$error =$z5['error_code'];
$vidt = str_replace('drm', 'hls', $vhls);

$img = str_replace('270x152', '1170x658', $image);                                     // Landscape Image
$pro = "https://akamaividz2.zee5.com/image/upload/resources/".$id."/portrait/".$cover; // portrait Image

$hls = "https://zee5vodnd.akamaized.net".$vidt.$vtoken;  // HLS Url
$dash = "https://zee5vodnd.akamaized.net".$vdash;        // Dash URL

header("Content-Type: application/json");
$errr= array("error" => "Put Here Only ZEE5 Proper URL ,  Invalid Input " );
$err =json_encode($errr);

$apii = array("title" => $title, "description" => $des,  "Release" => $release, "language" => $lang, "genre" => $gen.",".$gen1 , "thumbnail" => $img, "portrait" => $pro, "actor" => $actor, "drm_key" => $drmkey, "video_url" => $hls, "dash" => $dash, "subtitle_url" => $sub);

$api =json_encode($apii, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);


if($error ==101){
echo $err;
}
else{
echo $api;
}
}
else{
  header("Content-Type: application/json");
  echo "Hello There Is Problem In Your Link Or Check Your Link Format !!";
}
?>
