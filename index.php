<?php
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://www.youtube.com/watch?v=U2RWu6b-Tws");
$file = __DIR__.DIRECTORY_SEPARATOR."video.html";
$file_handle = fopen($file,"w");
// curl_setopt($ch,CURLOPT_POST,true);
// curl_setopt($ch,CURLOPT_POSTFIELDS,"id=333");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_FILE,$file_handle);
// curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
// curl_setopt($ch,CURLOPT_HEADER,true);
// curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
$result = curl_exec($ch);
echo $result;
fclose($file_handle);
curl_close($ch);
?>