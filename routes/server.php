<?php
    // $base = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
    // $base .= '://'.$_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    // $base = 'https://casbara.himachalsociety.com/';
    $base = request()->getSchemeAndHttpHost();

?>