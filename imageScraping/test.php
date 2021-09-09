<?php
function getHtmlFromUrl($url){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}
// $fileName = "imageLinks.txt";
// // $f = fopen("hello.txt","w");
// // fwrite($f,"hello");
// $fileUrls = file($fileName);
//     $singleLink = $fileUrls[0];
//     $image = file_get_contents("https://cdn.pixabay.com/photo/2015/03/26/09/52/chain-link-690503__480.jpg");
//     $explodeLinkBySlash = explode("/",$singleLink);
//     $imageName = end($explodeLinkBySlash);
//     $fileOpen = fopen("hello.png","w");
//     fwrite($fileOpen,$image);
//     // echo "<img src =".$singleLink.">";
//     die();
// $html = getHtmlFromUrl("https://flipkart.com");
// $stream = fopen("flipkar.html","w");
 $html = file_get_contents("flipkar.html");
 echo $html;die();
$string = '<img class="_2OHU_q aA9eLq" alt="oppo reno6" srcset="https://rukminim1.flixcart.com/flap/3376/560/image/de0e6ec39f956ae8.jpg?q=50 2x, https://rukminim1.flixcart.com/flap/1688/280/image/de0e6ec39f956ae8.jpg?q=50 1x" src="https://rukminim1.flixcart.com/flap/1688/280/image/de0e6ec39f956ae8.jpg?q=50" data-tkid="M_72c5a6a5-8900-49ab-bc1b-c8a89428dda8_2.M9SZU6DII1SN"><img class="kJjFO0 _3DIhEh" src="https://rukminim1.flixcart.com/flap/50/50/image/de0e6ec39f956ae8.jpg?q=50" alt="oppo reno6">';
preg_match_all("/(http[s]*:\/\/)([a-z\-_0-9\/.]+)\.([a-z.]{2,3})\/([a-z0-9\-_\/._~:?#\[\]@!$&'()*+,;=%]*)([a-z0-9]+\.)(jpg|jpeg|png)/i",$html,$matches);
$matches = array_unique($matches[0]);
foreach($matches as $value){
    echo "<br>".$value;
}
// echo "<pre>";
// print_r($matches);
// echo "</pre>";
?>