<?php
if(isset($_GET['dlUrl'])){
    $dlUrl = $_GET['dlUrl'];
    function forceDownload($remoteUrl, $fileName){
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
    preg_match("/(http[s]*:\/\/)([a-z\-_0-9\/.]+)\.([a-z.]{2,3})\/([a-z0-9\-_\/._~:?#\[\]@!$&'()*+,;=%]*)([a-z0-9]+\.)(mp4|jpg|jpeg|png)/i",$dlUrl,$videoAbsoluteUrl);
    $videoAbsoluteUrl = $videoAbsoluteUrl[0];
    $videoAbsoluteUrl = explode("/",$videoAbsoluteUrl);
    $videoName = end($videoAbsoluteUrl);
    // set_time_limit(0);
    session_write_close();
    forceDownload($dlUrl,$videoName);
}


?>