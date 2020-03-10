<?php


abstract class AbstractPlaceHandler
{
    private $pdo;
    private $city;
    private $country;
    private $pageloader;
    private $messageService;

//    abstract public function queryForPlaces($id = null);
    abstract public function ReplaceCities( $cities, $template_html );
    abstract public function Load();

    /**
     * CityHandler constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
        $this->city = new City();
        $this->country = new Countries();
        $this->pageloader = new PageLoader();
        $this->messageService = new MessageService();
    }

    public function getPDOData($sql){
        $this->pdo = $sql;
        return $sql;
    }

    public function LoadCityTemplate($cityTemplate) {
        $template = $this->pageloader->LoadTemplate($cityTemplate);
        $cities = $this->Load();
        print $this->ReplaceCities( $cities, $template);
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