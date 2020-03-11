<?php
class CityHandler extends AbstractPlaceHandler implements PlaceInterface
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        parent::__construct($this->pdo = $pdo);
    }

    public function queryForPlaces($id = null){
        $pdo = $this->pdo;
        if($id >0) {
            $statement = $pdo->prepare('SELECT * FROM images where img_id= '.$id );
        }else{
            $statement = $pdo->prepare("SELECT * FROM images WHERE img_what = 'city'");
        }

        $statement->execute();
        $cityArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $cityArray;
    }

    /* Deze functie voegt data en template samen en print het resultaat */
    function ReplaceCities( $cities, $template_html )
    {
        $returnval = "";

        foreach ( $cities as $city )
        {
            $content = $template_html;
            $content = str_replace("@@img_id@@", $city->getId(), $content);
            $content = str_replace("@@img_title@@", $city->getTitle(), $content);
            $content = str_replace("@@img_filename@@", $city->getFileName(), $content);
            $content = str_replace("@@img_width@@", $city->getWidth(), $content);
            $content = str_replace("@@img_height@@", $city->getHeight(), $content);

            $returnval .= $content;
        }

        return $returnval;
    }

    public function Load(  )
    {
        $cities = array();

        $sql = $this->queryForPlaces($id = $_GET['id']);

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
}