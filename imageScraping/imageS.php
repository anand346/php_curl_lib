<?php
function getLinksWithReg($html,$url){
    // echo $html;die();
    preg_match_all("/(http[s]*:\/\/)([a-z\-_0-9\/.]+)\.([a-z.]{2,3})\/([a-z0-9\-_\/._~:?#\[\]@!$&'()*+,;=%]*)([a-z0-9]+\.)(jpg|jpeg|png)/i",$html,$matches);
    $matches = $matches[0];
    if(sizeof($matches) == 0){
        $crawledArray = getCrawledArray($html,"img");
        $allImageLinks = getAllImageLinks($crawledArray);
        $checkedLinks = checkLink($allImageLinks,$url);
        $matchesSerialize = array();
        if(is_array($checkedLinks)){
            foreach ($checkedLinks as $checkedKey => $checkedValue) {
                $matchesSerialize[] = $checkedValue;
            }
        }else{
            echo "<br>array is empty";
        }
    }else{
        $matches = array_unique($matches);
        foreach($matches as $matchKey => $matchValue){
            if(strpos($matchValue,"thumb") !== false){
                unset($matches[$matchKey]);
            }
        }
        $matchesSerialize = array();
        foreach ($matches as $matchKey => $matchValue) {
            $matchesSerialize[] = $matchValue;
        }
    }
    return $matchesSerialize;
}
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
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, '/cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, '/cookies.txt');
    curl_setopt($ch,CURLOPT_USERAGENT,$agents[array_rand($agents)]);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    $html = curl_exec($ch);
    curl_close($ch);
    // echo $html;die();
    return $html;
}
function getAllImageLinks($crawledArray){
    if(is_array($crawledArray)){
        $Imglinks = array();
        foreach($crawledArray as $Data){
            $Imglinks[] =  $Data->getAttribute("src");
        }
        return $Imglinks;
    }else{
        echo "<br>array is empty";
    }
    
}
function getCrawledArray($html = NULL,$tag = NULL){
    if(empty($html) == true){
        echo $html;
    }else{
        $dom = new DOMDocument();
        $lib_xml_previous_state = libxml_use_internal_errors(true);
        @$dom->loadHTML(mb_convert_encoding($html,'HTML-ENTITIES','UTF-8') ,LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_use_internal_errors($lib_xml_previous_state);
        $tagData = $dom->getElementsByTagName($tag);
        return $tagData;
    }
    
}
function checkLink($getAllLinks,$url){
    if(is_array($getAllLinks)){
        $links = array();
        foreach ($getAllLinks as  $link) {
            if((strpos($link,"https://") === 0) || (strpos($link,"http://") === 0)){
                $links[] = $link;
            }else if(strpos($link,"/") === 0){
                if((substr($url,-1) == "/")){
                    $url = substr($url,0,-1);
                    $link = $url.$link;
                    $links[] = $link;
                }else{
                    $link = $url.$link;
                    $links[] = $link;
                }
            }else{
                if((substr($url,-1) == "/")){
                    $link = $url.$link;
                    $links[] = $link;
                }else{
                    $link = $url."/".$link;
                    $links[] = $link;
                }
            }
            // echo "<br>".$link;
        }
        $links = array_unique($links);
        return $links;
    }else{
        echo "<br>array is empty";
    }
    
}
function saveInFile($fileName=NULL,$crawledDocArray=NULL,$mode="w"){
    $fh = fopen($fileName,$mode);
    foreach ($crawledDocArray as $crawledKey => $crawledValue) {
        $explodeValue = explode("/",$crawledValue);
        if(strpos(end($explodeValue),".") !== false){
            fwrite($fh,$crawledValue."\n");            
        }else{
            unset($crawledDocArray[$crawledKey]);
        }
    }
    fclose($fh);
}
function scrapeImage($url,$fileName){
    $html = GetHtmlFromUrl($url);
    $checkedLinks = getLinksWithReg($html,$url);
    saveInFile($fileName,$checkedLinks,"w");
    echo "<pre>";
    print_r($checkedLinks); 
    echo "</pre>";
    return true;
}

function downloadImage($result,$fileName,$dir,$noOfImage){
    if($result){
        $fileUrls = file($fileName);
        foreach($fileUrls as $singleKey => $singleLink){
            if($singleKey == $noOfImage){
                break;
            }
            $singleLink = preg_replace('/\s+/', ' ', trim($singleLink));
            $dir = $dir;
            if(!(file_exists($dir))){
                mkdir($dir);
            }
            $imageName = basename($singleLink);
            $image = getHtmlFromUrl($singleLink);
            if(empty($image) == true){
                continue;
            }else{
                $finalLoc = $dir.$imageName;
                $fileOpen = fopen($finalLoc,"wb");
                fwrite($fileOpen,$image);
            }
            
        }
    }
}

$url = "https://www.instagram.com/anand_346/?hl=en";
$fileName = "imageLinks.txt";
$dir = "insta/";
$noOfImage = 1;
$result = scrapeImage($url,$fileName);
downloadImage($result,$fileName,$dir,$noOfImage);
?>