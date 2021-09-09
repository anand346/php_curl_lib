<?php
if(isset($_GET['url'])){
    function getHtmlFromUrl($url){
        $agents = array(
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
            'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.9) Gecko/20100508 SeaMonkey/2.0.4',
            'Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)',
            'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; da-dk) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1'
         
        );
        $header = array();
        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = "Pragma: ";
    //assign to the curl request.
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_AUTOREFERER,true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_USERAGENT,$agents[array_rand($agents)]);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($ch);
        curl_close($ch);
        // echo $html;die();
        return $html;
    }
    function getJsonData($html){
        $pattern = "/window._sharedData = (.*);/";
        preg_match($pattern,$html,$matches);
        $data = json_decode($matches[1],true);
        return $data;    
    }
   
    function getVideoUrl($Jsondata){
        $url = $Jsondata["entry_data"]["PostPage"][0]["graphql"]["shortcode_media"]["video_url"];
        preg_match("/(http[s]*:\/\/)([a-z\-_0-9\/.]+)\.([a-z.]{2,3})\/([a-z0-9\-_\/._~:?#\[\]@!$&'()*+,;=%]*)([a-z0-9]+\.)(mp4)/i",$url,$videoUrl);
        $videoUrl = $videoUrl[0];
        return $videoUrl;
    }
    function getVideoName($videoUrl){
        $videoUrl = explode("/",$videoUrl);
        $videoName = end($videoUrl);
        return $videoName;
    }
    function downloadVideo($videoUrl){
        $videoMedia = getHtmlFromUrl($videoUrl);
        $videoName = getVideoName($videoUrl);
        $fileHandle =  fopen($videoName,"wb");
        if(fwrite($fileHandle,$videoMedia)){
            echo '<a href="'.$videoName.'" download>Download In Computer</a><br>';
            fclose($fileHandle);
        }
    }
    $url = $_GET['url'];
    $html = getHtmlFromUrl($url);
    $Jsondata = getJsonData($html);
    $videoUrl = getVideoUrl($Jsondata);
    downloadVideo($videoUrl);
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InstaDownloader</title>
</head>
<body>
    <form action="" method = "GET">
        <input type="text" name = "url">
        <input type="submit" value="Download">
    </form>
</body>
</html>