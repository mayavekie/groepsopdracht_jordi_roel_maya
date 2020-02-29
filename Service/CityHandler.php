<?php
class CityHandler
{
    private $pdo;
    private $city;
    private $pageloader;
    private $messageService;


    /**
     * CityHandler constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
        $this->city = new City();
        $this->pageloader = new PageLoader();
        $this->messageService = new MessageService();

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
            $statement = $pdo->prepare('SELECT * FROM images where img_id= '.$id );
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
        $template = $this->pageloader->LoadTemplate($cityTemplate);
        $cities = $this->Load();
        print $this->pageloader->ReplaceCities( $cities, $template);
    }

    public function LoadIntoCity(){
        $this->city->Load();
    }

    public function LoopThroughFieldAndValue(){

        foreach( $_POST as $field => $value )
        {
            if ( in_array($field, array("tablename", "formname", "afterinsert", "pkey", "savebutton", $this->city->getPkey()))) continue;

            $sql_body[]  = " $field = '" . htmlentities($value, ENT_QUOTES) . "' " ;
            $this->city->setSqlBody($sql_body);
        }
    }

    public function SaveCityToDatabase(){
        global $_application_folder;
        global $Container;

        $pkey = $this->city->getPkey();

        if ( $_POST[$this->city->getPkey()] > 0 ) //update
        {
            $sql = "UPDATE " . $this->city->getTablename() . " SET " . implode( ", " , $this->city->getSqlBody() ) . " WHERE $pkey=" . $_POST[$pkey];
            if ( $Container->getPDOtoExecute($sql) ) {
                $this->city->setNewUrl( $_application_folder  . "/".$this->city->getFormname().".php?id=" . $_POST[$pkey] . "&updateOK=true");
                $this->messageService->AddMessage('Changes saved to database');
            }
            else $this->messageService->AddMessage('Changes not saved to database', 'error');
        }
        else //insert
        {
            $sql = "INSERT INTO " . $this->city->getTablename() . " SET " . implode( ", " , $this->city->getSqlBody() );
            if ( $Container->getPDOtoExecute($sql) ) {
                $this->city->setNewUrl($_application_folder . "/".$this->city->getAfterinsert()."?insertOK=true");
                $this->messageService->AddMessage('City saved to database');
            }
            else $this->messageService->AddMessage('City saved to database', 'error');
        }
    }

    public function GetNewUrlFromCity(){
        $new_url = $this->city->getNewUrl();
        return $new_url;
    }

}