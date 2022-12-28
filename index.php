<?php

$url =$_GET['c'];
if($url !=""){
$id = end(explode('/', $url));
$tlink ="https://apiv2.sonyliv.com/AGL/3.0/A/ENG/MWEB/IN/JH/CONTENT/VIDEOURL/VOD/$url/freepreview";
$tokenurl =file_get_contents("https://useraction.zee5.com/token/platform_tokens.php?platform_name=web_app");
$tok =json_decode($tokenurl, true);
$token =$tok['token'];

$vtok =file_get_contents("http://useraction.zee5.com/tokennd/");
$vtokn =json_decode($vtok, true);
$vtoken =$vtokn['video_token'];


$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $tlink,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Security_Token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjgzMDc2IiwiZW1haWwiOiJzcG5zcjRtZUBnbWFpbC5jb20iLCJ0aW1lc3RhbXAiOjE2NzIyMDQyMDd9.C1fEkf-J5SVkojBPGTLqgUSHKjpF30zlGpYL3VLhtNI",
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
