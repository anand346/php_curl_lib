<?php
// function input(string $input_text = null):string{
//     echo $input_text;
//     $handle = fopen("php://stdin","rb");
//     $output = fgets($handle);
//     return trim($output);
// }
// $name = input("enter your name : ");
// $ch = curl_init();
// curl_setopt($ch,CURLOPT)

// unset($argv[0]);
// print_r($argv);
// echo implode(" ",$argv)."\n";
// $input = trim(fgets(STDIN));
// echo "\n".$input;


while(true){
    echo "Enter Something : ";
    $input = trim(fgets(STDIN));
    echo $input."\n";
}
?>