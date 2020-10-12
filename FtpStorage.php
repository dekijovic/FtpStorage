<?php

class FtpStorage
{
    private $host;
    private $user;
    private $password;
    private $port;
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
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->port = $port;
        $this->ftp = ftp_connect($this->host, $this->port) or die('Couldn\'t connect');
        ftp_login($this->ftp, $this->user, $this->password) or die('Couldn\'t login');
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
