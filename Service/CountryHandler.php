<?php


class CountryHandler extends AbstractPlaceHandler implements PlaceInterface
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
            $statement = $pdo->prepare("SELECT * FROM images WHERE img_what = 'country'");
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
            $content = str_replace("@@img_country@@", $city->getCountry(), $content);
            $content = str_replace("@@img_capital@@", $city->getCapital(), $content);
            $content = str_replace("@@img_population@@", $city->getPopulation(), $content);
            $content = str_replace("@@img_currency@@", $city->getCurrency(), $content);

            $returnval .= $content;
        }

        return $returnval;
    }

    public function Load()
    {
        $countries = array();

        $sql = $this->queryForPlaces($id = $_GET['id']);

        $data = $this->getPDOData($sql);

        foreach ($data as $row)
        {
            $country = new Countries();

            $country->setId( $row['img_id'] );
            $country->setFileName( $row['img_filename'] );
            $country->setTitle( $row['img_title'] );
            $country->setCapital( $row['img_capital'] );
            $country->setPopulation( $row['img_population'] );
            $country->setCurrency( $row['img_currency'] );
            $country->setCountry( $row['img_country'] );

            $countries[] = $country;
        }

        return $countries;
    }
}