<?php


class Profile extends Upload
{
    private $img_pasfoto;
    private $img_vz_eid;
    private $img_az_eid;
    private $images;
    private $tmp_name;
    private $originele_naam;
    private $size;
    private $extensie;
    private $target;

    /**
     * @param $fileobject
     */
    public function LoadImageInfo($fileobject){
        $this->setTmpName($fileobject["tmp_name"]);
        $this->setOrigineleNaam($fileobject["name"]);
        $this->setSize($fileobject["size"]);
        $this->setExtensie(pathinfo($this->getOrigineleNaam(), PATHINFO_EXTENSION));
        $this->setTarget("");
    }

    /**
     * @param mixed $images
     */
    public function setImages()
    {
        $this->images['profile']['usr_pasfoto'] = $this->getImgPasfoto();
        $this->images['profile']['usr_vz_eid'] = $this->getImgVzEid();
        $this->images['profile']['usr_az_eid'] = $this->getImgAzEid();
    }

    /**
     * @param mixed $img_pasfoto
     */
    public function setImgPasfoto($img_pasfoto)
    {
        $this->img_pasfoto = $img_pasfoto;
    }

    /**
     * @param mixed $img_vz_eid
     */
    public function setImgVzEid($img_vz_eid)
    {
        $this->img_vz_eid = $img_vz_eid;
    }

    /**
     * @param mixed $img_az_eid
     */
    public function setImgAzEid($img_az_eid)
    {
        $this->img_az_eid = $img_az_eid;
    }

    /**
     * @return mixed
     */
    public function getImgPasfoto()
    {
        return $this->img_pasfoto;
    }

    /**
     * @return mixed
     */
    public function getImgVzEid()
    {
        return $this->img_vz_eid;
    }

    /**
     * @return mixed
     */
    public function getImgAzEid()
    {
        return $this->img_az_eid;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return mixed
     */
    public function getTmpName()
    {
        return $this->tmp_name;
    }

    /**
     * @param mixed $tmp_name
     */
    public function setTmpName($tmp_name)
    {
        $this->tmp_name = $tmp_name;
    }

    /**
     * @return mixed
     */
    public function getOrigineleNaam()
    {
        return $this->originele_naam;
    }

    /**
     * @param mixed $originele_naam
     */
    public function setOrigineleNaam($originele_naam)
    {
        $this->originele_naam = $originele_naam;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getExtensie()
    {
        return $this->extensie;
    }

    /**
     * @param mixed $extensie
     */
    public function setExtensie($extensie)
    {
        $this->extensie = $extensie;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }
}