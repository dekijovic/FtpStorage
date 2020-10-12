<?php

class FtpStorage
{
    private $ftp;

    /**
     * FtpStorage constructor.
     * @param $host
     * @param $user
     * @param $password
     * @param $port
     */
    public function __construct($host, $user, $password, $port)
    {
        $this->ftp = ftp_connect($host, $port) or die('Couldn\'t connect to your ftp server');
        ftp_login($this->ftp, $user, $password) or die('Couldn\'t login to your ftp account');
        ftp_pasv($this->ftp, true);
    }

    /**
     * Close Connection
     */
    public function closeConnection()
    {
        ftp_close($this->ftp);
    }

    /**
     * List of file paths
     * @return array
     */
    public function allFiles()
    {
        ftp_pasv($this->ftp, true);
        $files = ftp_nlist($this->ftp, './public_html');

        return $files;
    }

    /**
     * Get Ftp file
     * @param string $localPathFile
     * @return string
     */
    public function downloadFile($localPathFile, $file)
    {
        $file = substr($file, 0,2) == './' ? $file : './'.$file;
        ftp_get($this->ftp, $localPathFile, $file);
        chmod ( $localPathFile , 0755 );
    }

    /**
     * Delete Ftp file
     * @param $file
     */
    public function destroyFile($file)
    {
        $file = substr($file, 0,2) == './' ? $file: './'.$file;
        ftp_delete($this->ftp,$file);;
    }

}
