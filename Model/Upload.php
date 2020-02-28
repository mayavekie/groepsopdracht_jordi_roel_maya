<?php


class Upload
{
    private $target_dir = "../img/";
    private $max_size = 20000000;
    private $allowed_extensions = [ "jpeg", "jpg", "png", "gif" ];
    private $returnvalue = true;

    /**
     * @return string
     */
    public function getTargetDir()
    {
        return $this->target_dir;
    }

    /**
     * @return int
     */
    public function getMaxSize()
    {
        return $this->max_size;
    }

    /**
     * @return array
     */
    public function getAllowedExtensions()
    {
        return $this->allowed_extensions;
    }

    /**
     * @param bool $returnvalue
     */
    public function setReturnvalue($returnvalue)
    {
        $this->returnvalue = $returnvalue;
    }

    /**
     * @return bool
     */
    public function isReturnvalue()
    {
        return $this->returnvalue;
    }


}