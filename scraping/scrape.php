<?php

function extractDomainName($url = NULL){
    
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : NULL;
    
    $domainExplode = explode(".",$domain);
    if(strpos($url,"www.")){
        $domainName = $domainExplode[1];
    }else{
        $domainName = $domainExplode[0];        
    }
    return $domainName;
}
function extractFullDomain($url = NULL){
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : NULL;
    $scheme = isset($pieces['scheme']) ? $pieces['scheme'] : NULL;
    return $scheme."://".$domain;
}

function getHtmlFromUrl($url){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    $html = curl_exec($ch);
    return $html;
    curl_close($ch);
}
function getCrawledArray($html = NULL,$tag = NULL){
    $dom = new DOMDocument();
    $lib_xml_previous_state = libxml_use_internal_errors(true);
    @$dom->loadHTML(mb_convert_encoding($html,'HTML-ENTITIES','UTF-8') ,LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_use_internal_errors($lib_xml_previous_state);
    $tagData = $dom->getElementsByTagName($tag);
    return $tagData;
}

// $a = $as->item(0);
function saveInFile($file=NULL,$crawledDocArray=NULL,$mode="w"){
    $fh = fopen($file,$mode);
    foreach($crawledDocArray as $Data){
        fwrite($fh,$Data->getAttribute("href")."\n");
    }
    fclose($fh);
    return $file;
}
function checkData($file=NULL,$domain,$fullDomain=NULL,$exceptDomain = NULL){
    // $file = "links.txt";
    $lines = file($file);
    $lines = array_unique($lines);
    if($exceptDomain != NULL){
        $exceptDomainArray = parse_url($exceptDomain);
        $exceptDomainHost = isset($exceptDomainArray['host']) ? $exceptDomainArray['host'] : NULL;
        $exceptDomainHostArray = explode(".",$exceptDomainHost);
        if($exceptDomainHostArray[0] == "www"){
            $exceptDomainHostName = $exceptDomainHostArray[1];
        }else{
            $exceptDomainHostName = $exceptDomainHostArray[0];
        }
    }
    foreach ($lines as $key =>  $line) {
        if((strpos($line,"http://") === 0) || (strpos($line,"https://") === 0) ){
            $linePieces = parse_url($line);
            $lineDomain = isset($linePieces['host']) ? $linePieces['host'] : NULL;
            $lineDomainFromSubdomainExplode = explode(".",$lineDomain);
            $lineDomainFromSubdomain1 = isset($lineDomainFromSubdomainExplode[1]) ? $lineDomainFromSubdomainExplode[1] : NULL;
            $lineDomainFromSubdomain0 = isset($lineDomainFromSubdomainExplode[0]) ? $lineDomainFromSubdomainExplode[0] : NULL;    
        }else if(strpos($line,"/") === 0){
            // echo "hello---------------------------------------------------------<br>";
            // // echo $line."<br>";
            // echo $line."<br>";
            if((substr($fullDomain,-1) == "/")){
                $fullDomain = substr($fullDomain,0,-1);
                $line = $fullDomain.$line;
            }else{
                $line = $fullDomain.$line;
            }
            $lines[$key] = $line;
            $lines = array_unique($lines);
            $linePieces = parse_url($line);
            $lineDomain = isset($linePieces['host']) ? $linePieces['host'] : NULL;
            $lineDomainFromSubdomainExplode = explode(".",$lineDomain);
            $lineDomainFromSubdomain1 = isset($lineDomainFromSubdomainExplode[1]) ? $lineDomainFromSubdomainExplode[1] : NULL;
            $lineDomainFromSubdomain0 = isset($lineDomainFromSubdomainExplode[0]) ? $lineDomainFromSubdomainExplode[0] : NULL;
        }else if((strpos($line,"?") === 0)){
            if((substr($fullDomain,-1) == "/")){
                $line = $fullDomain.$line;
            }else{
                $line = $fullDomain."/".$line;
            }
            // $line = $lastUrl."/".$line;
            $lines[$key] = $line;
            $lines = array_unique($lines);
            $linePieces = parse_url($line);
            $lineDomain = isset($linePieces['host']) ? $linePieces['host'] : NULL;
            $lineDomainFromSubdomainExplode = explode(".",$lineDomain);
            $lineDomainFromSubdomain1 = isset($lineDomainFromSubdomainExplode[1]) ? $lineDomainFromSubdomainExplode[1] : NULL;
            $lineDomainFromSubdomain0 = isset($lineDomainFromSubdomainExplode[0]) ? $lineDomainFromSubdomainExplode[0] : NULL;
        }else if(strpos($line,"www.") === 0){
            $line = $line;
            $lines[$key] = $line;
            $lines = array_unique($lines);
            $linePieces = parse_url($line);
            $lineDomain = isset($linePieces['host']) ? $linePieces['host'] : NULL;
            $lineDomainFromSubdomainExplode = explode(".",$lineDomain);
            $lineDomainFromSubdomain1 = isset($lineDomainFromSubdomainExplode[1]) ? $lineDomainFromSubdomainExplode[1] : NULL;
            $lineDomainFromSubdomain0 = isset($lineDomainFromSubdomainExplode[0]) ? $lineDomainFromSubdomainExplode[0] : NULL;
        }else{
            $explodeNew = explode(".",$line);
            if($explodeNew[0] == $domain){
                $line = $line;
                $lines = array_unique($lines);
                $linePieces = parse_url($line);
                $lineDomain = isset($linePieces['host']) ? $linePieces['host'] : NULL;
                $lineDomainFromSubdomainExplode = explode(".",$lineDomain);
                $lineDomainFromSubdomain1 = isset($lineDomainFromSubdomainExplode[1]) ? $lineDomainFromSubdomainExplode[1] : NULL;
                $lineDomainFromSubdomain0 = isset($lineDomainFromSubdomainExplode[0]) ? $lineDomainFromSubdomainExplode[0] : NULL;        
            }else if((strpos($line,"#") === 0) || (strpos($line,"mailto") === 0) ){
                unset($lines[$key]);
            }else{
                if((substr($fullDomain,-1) == "/")){
                    $line = $fullDomain.$line;
                }else{
                    $line = $fullDomain."/".$line;
                }
                $lines[$key] = $line;
                $lines = array_unique($lines);
                $linePieces = parse_url($line);
                $lineDomain = isset($linePieces['host']) ? $linePieces['host'] : NULL;
                $lineDomainFromSubdomainExplode = explode(".",$lineDomain);
                $lineDomainFromSubdomain1 = isset($lineDomainFromSubdomainExplode[1]) ? $lineDomainFromSubdomainExplode[1] : NULL;
                $lineDomainFromSubdomain0 = isset($lineDomainFromSubdomainExplode[0]) ? $lineDomainFromSubdomainExplode[0] : NULL;        
            }
            
        }
        // echo $line."<br>";
        // $linePieces = parse_url($line);
        // $lineDomain = isset($linePieces['host']) ? $linePieces['host'] : NULL;
        // $lineDomainFromSubdomainExplode = explode(".",$lineDomain);
        // $lineDomainFromSubdomain1 = isset($lineDomainFromSubdomainExplode[1]) ? $lineDomainFromSubdomainExplode[1] : NULL;
        // $lineDomainFromSubdomain0 = isset($lineDomainFromSubdomainExplode[0]) ? $lineDomainFromSubdomainExplode[0] : NULL;
        
        // if(strpos($line,"/") === 0){
        //     echo "hello---------------------------------------------------------<br>";
        //     // echo $line."<br>";
        //     echo $line."<br>";
        //     $line = $fullDomain.$line;
        //     $lines[$key] = $line;
        //     $lines = array_unique($lines);
        //     $linePieces = parse_url($line);
        //     $lineDomain = isset($linePieces['host']) ? $linePieces['host'] : NULL;
        //     $lineDomainFromSubdomainExplode = explode(".",$lineDomain);
        //     $lineDomainFromSubdomain1 = isset($lineDomainFromSubdomainExplode[1]) ? $lineDomainFromSubdomainExplode[1] : NULL;
        //     $lineDomainFromSubdomain0 = isset($lineDomainFromSubdomainExplode[0]) ? $lineDomainFromSubdomainExplode[0] : NULL;
        // }
        if($exceptDomain != NULL){
            $check = true;
            if(($domain == $lineDomainFromSubdomain1) || ($domain == $lineDomainFromSubdomain0)){
                $check = false;
            }
            if (($exceptDomainHostName == $lineDomainFromSubdomain1) || ($exceptDomainHostName == $lineDomainFromSubdomain0)) {
                $check = false;
            }
            if($check){
                unset($lines[$key]);
            }    
        }else{
            if(($domain == strtolower($lineDomainFromSubdomain1)) || ($domain == strtolower($lineDomainFromSubdomain0))){
            
            }else{
                unset($lines[$key]);
            }
            // if(($domain == $lineDomainFromSubdomain)){
            
            // }else{
            //     unset($lines[$key]);
            // }
        }
        
        // if((strpos(trim($line),"#") !== false ) || (strpos(trim($line),"javascript:void(0);") !== false)){
        //     unset($lines[$key]);
        // }
        if(strpos(trim($line),"javascript:void(0);") !== false){
            unset($lines[$key]);
        }
        if(strpos(trim($line),"#") === 0 ){
            unset($lines[$key]);
        }
    }
    return $lines;
}
function saveNewData($lines,$file,$mode = "w"){
    $fh = fopen($file,$mode);
    $newData = implode("",$lines);
    file_put_contents($file,$newData);
    fclose($fh);
    return true;
}
function scrape($url=NULL,$fileName=NULL,$exceptDomain=NULL){
    if(isset($url) && isset($fileName)){
        $domain = extractDomainName($url);
        $html = getHtmlFromUrl($url);
        $crawledDocArray = getCrawledArray($html,"a");
        saveInFile($fileName,$crawledDocArray,"w");
        $fullDomain = extractFullDomain($url);
        $checkedData = checkData($fileName,$domain,$fullDomain);
        $savedNew =  saveNewData($checkedData,$fileName,"w");
        if($savedNew){
            echo "crawled successfully";
            return true;
        }else{
            echo "crawling unsuccessful";
            return false;
        }
    }
}
$url = "https://www.mponline.gov.in/portal/CitizenHome.aspx";
// $url = "http://testphp.vulnweb.com/";
// $url = "https://sageuniversity.edu.in";
$fileName = "links.txt";
$exceptDomain = "https://linkedin.com";
$result = scrape($url,$fileName);
// goto maaro;
// $result = true;
if($result){
    $fileUrls = file($fileName);
    for($i = 0 ; $i < sizeof($fileUrls); $i++){
        $fileUrl = $fileUrls[$i];
        $fileUrl =  preg_replace('/\s+/', ' ', trim($fileUrl));
        $domain = extractDomainName($url);
        $parseFileUrl = parse_url($fileUrl);
        $explodeFileUrlHost = explode(".",$parseFileUrl['host']);
        if(($explodeFileUrlHost[0] == "www") || ($explodeFileUrlHost[0] == $domain) ){
            $html = getHtmlFromUrl($fileUrl);
            if(empty($html) === true){
                continue;
            }else{
                $crawledDocArray = getCrawledArray($html,"a");
                saveInFile($fileName,$crawledDocArray,"a");
                $fullDomain = extractFullDomain($url);
                $checkedData = checkData($fileName,$domain,$fullDomain);
                if(is_array($checkedData)){
                    foreach($checkedData as $newUrl){
                        $fileUrls[] = $newUrl;
                        $fileUrls = array_unique($fileUrls);
                        saveNewData($fileUrls,$fileName,"a");
                    }
                }else{
                    $fileUrls[] = $checkedData;            
                    $fileUrls = array_unique($fileUrls);
                    saveNewData($fileUrls,$fileName,"a");
                }
                echo "<br>".$i."  =>  ".$fileUrl."<br>";
            }
            
        }
        
    }
    $fileUrls = array_unique($fileUrls);
    echo "<pre>";
    print_r($fileUrls);
    echo "</pre>";
}

?>