<?php
class CityHandler
{

    private $pdo;
    private $sql;

    /**
     * CityHandler constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }


    public function Load(  )
    {
        $cities = array();

        $sql = $this->queryForCities($id = $_GET['id']);

        $data = $this->getPDOData($sql);
        foreach ($data as $row)
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

    private function queryForCities($id = null){
        $pdo = $this->getPDO();
        if($id >0) {
            $statement = $pdo->prepare('SELECT * FROM images where img_id= '.$id.'');
        }else{
            $statement = $pdo->prepare('SELECT * FROM images');
        }

        $statement->execute();
        $cityArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $cityArray;
    }

    /**
     * @return PDO
     */
    private function getPDO(){
        return $this->pdo;
    }

    public function getPDOData($sql){
        $this->pdo = $sql;
        return $sql;
    }



    public function LoadCityTemplate($cityTemplate) {
        global $PL;
        $template = $PL->LoadTemplate($cityTemplate);
        $cities = $this->Load();
        print $PL->ReplaceCities( $cities, $template);
    }

}