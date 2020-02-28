<?php


class Profile
{
    private $img_pasfoto;
    private $img_vz_eid;
    private $img_az_eid;
    private $images;

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
     * @param mixed $images
     */
    public function setImages()
    {
        $this->images['profile']['img_pasfoto'] = $this->getImgPasfoto();
        $this->images['profile']['img_vz_eid'] = $this->getImgVzEid();
        $this->images['profile']['img_az_eid'] = $this->getImgAzEid();
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

    public function GetUserDataFromDatabase(){
        global $Container;

        //gebruikersgegevens ophalen uit databank
        $sql = "select * from users where usr_id=" . $_SESSION["usr"]->getId();
        $data = $Container->getPDOData($sql);

        print "<table class='table table-striped table-bordered'>";
        foreach( $data as $row )
        {
            foreach( $row as $field => $value )
            {
                $notintable = false;

                //foto's afhandelen
                if ( $field == "usr_pasfoto" AND $value > "" ) { $this->setImgPasfoto("<img class='thumbnail' src=img/$value>"); $notintable = true; }
                if ( $field == "usr_vz_eid" AND $value > "" ) { $this->setImgVzEid("<img class='thumbnail' src=img/$value>"); $notintable = true; }
                if ( $field == "usr_az_eid" AND $value > "" ) { $this->setImgAzEid("<img class='thumbnail' src=img/$value>"); $notintable = true; }

                //password niet tonen
                if ( $field == "usr_paswd" ) $notintable = true;

                //alle andere velden weergeven
                if ( !$notintable )
                {
                    $caption = str_replace("usr_", "", $field);
                    $caption = strtoupper(substr($caption,0,1)) . substr($caption,1);
                    print "<tr><td>$caption</td><td>$value</td></tr>";
                }
            }
            $this->setImages();
        }
        print "</table>";
    }

}