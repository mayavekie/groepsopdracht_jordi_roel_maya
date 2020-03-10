<?php


interface UploadInterface
{
    /**
     * @param null $upfile
     * @return mixed
     */
    public function CheckUpload($upfile);

    /**
     * @param $upfile
     * @return mixed
     */
    public function CheckIfRealImage($upfile);

    /**
     * @param $upfile
     * @return mixed
     */
    public function CheckIfExists($upfile);

    /**
     * @param $upfile
     * @return mixed
     */
    public function CheckSize($upfile);

    /**
     * @param $upfile
     * @return mixed
     */
    public function CheckFormat($upfile);
}