<?php
if(isset($_GET['url'])){
    $url = $_GET['url'];
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
    $data = getHtmlFromUrl($url);
    $pattern = "/window._sharedData = (.*);/";
    preg_match($pattern,$data,$matches);
    // echo $matches;
    $data = json_decode($matches[1],true);
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";die();

    // $tagsString = $data["entry_data"]["PostPage"][0]["graphql"]["shortcode_media"]["edge_media_to_caption"]["edges"]["0"]["node"]["text"];
    $tagsEdgeString = $data["entry_data"]["PostPage"][0]["graphql"]["shortcode_media"]["edge_media_to_caption"]["edges"];
    if(array_key_exists("0",$tagsEdgeString)){
        $tagsString = $data["entry_data"]["PostPage"][0]["graphql"]["shortcode_media"]["edge_media_to_caption"]["edges"]["0"]["node"]["text"];        
        preg_match_all("/#(.*)/",$tagsString,$tagMatches);
        // echo "<pre>";
        // print_r($tagMatches[0][0]);
        // echo "</pre>";die();
        $tagsArr = explode(" ",$tagMatches[0][0]);
        echo "<pre>";
        print_r($tagsArr);
        echo "</pre>";
    }else{
        echo "tags not exists";
    }
    if($data["entry_data"]["PostPage"][0]["graphql"]["shortcode_media"]["__typename"] == "GraphImage"){
        $imageUrl = $data["entry_data"]["PostPage"][0]["graphql"]["shortcode_media"]["display_url"];
        $contentUrl = $imageUrl;        
    }else if($data["entry_data"]["PostPage"][0]["graphql"]["shortcode_media"]["__typename"] == "GraphVideo"){
        $videoUrl = $data["entry_data"]["PostPage"][0]["graphql"]["shortcode_media"]["video_url"];
        $contentUrl = $videoUrl;        
    }else if ($data["entry_data"]["PostPage"][0]["graphql"]["shortcode_media"]["__typename"] == "GraphSidecar") {
        $sideCarImageUrls = array();
        $children = $data["entry_data"]["PostPage"][0]["graphql"]["shortcode_media"]["edge_sidecar_to_children"]["edges"];
        for($i = 0; $i < sizeof($children); $i++){
            $sideCarImageUrls[] = $data["entry_data"]["PostPage"][0]["graphql"]["shortcode_media"]["edge_sidecar_to_children"]["edges"][$i]["node"]["display_url"];
        }
        $contentUrl = array();
        $contentUrl = $sideCarImageUrls;
        // echo "<pre>";
        // print_r($contentUrl);
        // echo "</pre>";die();
    } else{
        echo "url is not valid";die();
    }
    // echo "<br>$url";die();
    // preg_match("/(http[s]*:\/\/)([a-z\-_0-9\/.]+)\.([a-z.]{2,3})\/([a-z0-9\-_\/._~:?#\[\]@!$&'()*+,;=%]*)([a-z0-9]+\.)(mp4)/i",$url,$videoAbsoluteUrl);
    // $videoAbsoluteUrl = $videoAbsoluteUrl[0];

    // $videoAbsoluteUrl = explode("/",$videoAbsoluteUrl);
    // $videoName = end($videoAbsoluteUrl);

    // $videoMedia = getHtmlFromUrl($url);
    // $fileHandle =  fopen($videoName,"wb");
    // if(fwrite($fileHandle,$videoMedia)){
    //     echo '<a  href="http://localhost/php_curl/instadownloader/'.$videoName.'" download>Download In Computer</a><br>';
    //     fclose($fileHandle);

    // }
    // forceDownload($videoUrl,"newDownlaod","mp4");
    // echo '
    // <a target = "_blank" href = "'.$videoUrl.'" download = "insta video">Download</a>
    // ';
    
    function forceDownload($remoteUrl, $fileName){
        echo "<br>{$remoteUrl}";
        // if (empty($fileName)) {
        //     $fileName = "hello world";
        // }
        // $fileName = $fileName . "." . "$fileType";
        $context_options = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Pragma: public');
        if (isset($_SERVER['HTTP_REQUEST_USER_AGENT']) && strpos($_SERVER['HTTP_REQUEST_USER_AGENT'], 'MSIE') !== FALSE) {
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        }
        header('Connection: Close');
        ob_clean();
        flush();
        readfile($remoteUrl, "", stream_context_create($context_options));
        exit;
    }
    if(is_array($contentUrl)){
        foreach ($contentUrl as $contentKey => $contentValue) {
            // echo "<br><br>".$contentValue;
            preg_match("/(http[s]*:\/\/)([a-z\-_0-9\/.]+)\.([a-z.]{2,3})\/([a-z0-9\-_\/._~:?#\[\]@!$&'()*+,;=%]*)([a-z0-9]+\.)(mp4|jpg|jpeg|png)/i",$contentValue,$videoAbsoluteUrl);
            $videoAbsoluteUrl = $videoAbsoluteUrl[0];
            $videoAbsoluteUrl = explode("/",$videoAbsoluteUrl);
            $videoName = end($videoAbsoluteUrl);
            set_time_limit(0);
            // echo "<br><a href = 'dl.php?dlUrl={$contentValue}'>{$contentKey}</a>";
            // session_write_close();
            forceDownload($contentValue,$videoName);
        }
    }else{
        preg_match("/(http[s]*:\/\/)([a-z\-_0-9\/.]+)\.([a-z.]{2,3})\/([a-z0-9\-_\/._~:?#\[\]@!$&'()*+,;=%]*)([a-z0-9]+\.)(mp4|jpg|jpeg|png)/i",$contentUrl,$videoAbsoluteUrl);
        $videoAbsoluteUrl = $videoAbsoluteUrl[0];
        $videoAbsoluteUrl = explode("/",$videoAbsoluteUrl);
        $videoName = end($videoAbsoluteUrl);
        set_time_limit(0);
        // echo "<br><a href = 'dl.php?dlUrl={$contentUrl}'>Download</a>";
        forceDownload($contentUrl,$videoName);
    }
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
        <input type="submit" value="download">
    </form>
    <!-- <img src="https://scontent-bom1-1.cdninstagram.com/v/t51.2885-19/s150x150/200973494_3603266606439647_7102691797641779143_n.jpg?_nc_ht=scontent-bom1-1.cdninstagram.com&_nc_ohc=UppxoqVIT64AX-myBcy&edm=AABBvjUBAAAA&ccb=7-4&oh=4c863a90d37b06927ca66b5cff6b4d0e&oe=6107B2C1&_nc_sid=83d603" alt=""> -->
    
</body>
</html>