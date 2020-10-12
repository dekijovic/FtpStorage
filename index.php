<?php

include_once 'FtpStorage.php';

$host = 'ftp.testos.com';
$port = 21;
$user = 'tzar';
$pass = '653421';

$ftp = new FtpStorage($host, $user, $pass, $port);

$files = $ftp->allFiles();

foreach ($files as $file){
    $ftp->downloadFile('./download/'.$file, $file);
    $ftp->destroyFile($file);
}

$ftp->closeConnection();