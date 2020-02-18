<?php
class CityHandler
{
    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function Load( $id = null )
    {
        $cities = array();

        $sql = "select * from images";
        if ( $id > 0 ) $sql .= " where img_id=$id";

        $data = GetData($sql);
        foreach ( $data as $row )
        {
            $city = new City();

            $city->setId( $row['img_id'] );
            $city->setFileName( $row['img_filename'] );
            $city->setTitle( $row['img_title'] );
            $city->setWidth( $row['img_width'] );
            $city->setHeight( $row['img_height'] );

            $cities[] = $city;
        }

        return $cities;
    }

    public function LoadCityTemplate($cityTemplate, $id = null) {
        $template = LoadTemplate($cityTemplate);
        $cities = $this->Load($id);
        print ReplaceCities( $cities, $template);
    }

}