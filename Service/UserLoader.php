<?php


class UserLoader
{
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
        $this->user = new User();
        $this->messageService = new MessageService();
    }

    private function Load( $row )
    {


        $this->user->setId( $row['usr_id']);
        $this->user->setVoornaam( $row['usr_voornaam'] );
        $this->user->setNaam($row['usr_naam']);
        $this->user->setLogin($row['usr_login']);
        $this->user->setPaswd($row['usr_paswd']);
        $this->user->setStraat($row['usr_straat']);
        $this->user->setHuisnr( $row['usr_huisnr']);
        $this->user->setBusnr( $row['usr_busnr']);
        $this->user->setPostcode( $row['usr_postcode']);
        $this->user->setGemeente( $row['usr_gemeente']);
        $this->user->setTelefoon( $row['usr_telefoon']);
        $this->user->setPasfoto($row['usr_pasfoto']);
        $this->user->setVzEid( $row['usr_vz_eid']);
        $this->user->setAzEid( $row['usr_az_eid']);
    }

    private function getPDO(){
        return $this->pdo;
    }

    public function getPDOData($sql){
        $this->pdo = $sql;
        return $sql;
    }


    public function CheckLogin()
    {
        //gebruiker opzoeken ahv zijn login (e-mail)
        $sql = "SELECT * FROM users WHERE usr_login='" . $this->user->getId(). "' ";

        $data = $this->getPDOData($sql);

        if ( count($data) == 1 )
        {
            $row = $data[0];
            //password controleren
            if ( password_verify( $this->user->getPaswd(), $row['usr_paswd'] ) ) $login_ok = true;
        }

        if ( $login_ok )
        {
            session_start();
            $this->Load($row);
            $_SESSION['usr'] = $this;
            $this->LogLoginUser();
            return true;
        }

        return false;
    }


    public function LogLoginUser()
    {
        global $Container;
        $session = session_id();
        $timenow = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
        $now = $timenow->format('Y-m-d H:i:s') ;
        $sql = "INSERT INTO log_user SET log_usr_id=".$this->id.", log_session_id='".$session."', log_in= '".$now."'";
        $Container->getPDOtoExecute($sql);
    }

    public function LogLogoutUser()
    {
        global $Container;

        $session = session_id();
        $timenow = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
        $now = $timenow->format('Y-m-d H:i:s') ;
        $sql = "UPDATE log_user SET  log_out='".$now."' where log_session_id='".$session."'";
        $Container->getPDOtoExecute($sql);
    }

    public function CheckIfUserExistsAlready()
    {

        //controle of gebruiker al bestaat
        $sql = "SELECT * FROM users WHERE usr_login='" . $_POST['usr_login'] . "' ";
        $data = $this->getPDOData($sql);
        if ( count($data) > 0 ) die("Deze gebruiker bestaat reeds! Gelieve een andere login te gebruiken.");
    }

    public function ValidatePostedUserData()
    {
        $this->CheckIfUserExistsAlready();

        //controle wachtwoord minimaal 8 tekens
        if ( strlen($_POST["usr_paswd"]) < 8 ) die("Uw wachtwoord moet minstens 8 tekens bevatten!");

        //controle geldig e-mailadres
        if (!filter_var($_POST["usr_login"], FILTER_VALIDATE_EMAIL)) die("Ongeldig email formaat voor login");
    }

    public function RegisterUser()
    {
        global $Container;
        global $tablename;
        global $_application_folder;


        //wachtwoord coderen
        $password_encrypted = password_hash ( $_POST["usr_paswd"] , PASSWORD_DEFAULT );

        $sql = "INSERT INTO $tablename SET " .
            " usr_voornaam='" . htmlentities($_POST['usr_voornaam'], ENT_QUOTES) . "' , " .
            " usr_naam='" . htmlentities($_POST['usr_naam'], ENT_QUOTES) . "' , " .
            " usr_straat='" . htmlentities($_POST['usr_straat'], ENT_QUOTES) . "' , " .
            " usr_huisnr='" . htmlentities($_POST['usr_huisnr'], ENT_QUOTES) . "' , " .
            " usr_busnr='" . htmlentities($_POST['usr_busnr'], ENT_QUOTES) . "' , " .
            " usr_postcode='" . htmlentities($_POST['usr_postcode'], ENT_QUOTES) . "' , " .
            " usr_gemeente='" . htmlentities($_POST['usr_gemeente'], ENT_QUOTES) . "' , " .
            " usr_telefoon='" . htmlentities($_POST['usr_telefoon'], ENT_QUOTES) . "' , " .
            " usr_login='" . $_POST['usr_login'] . "' , " .
            " usr_paswd='" . $password_encrypted . "'  " ;

        if ( $Container->getPDOtoExecute($sql) )
        {

            $this->messageService->AddMessage( "Bedankt voor uw registratie!" );

            $this->user->setLogin($_POST['usr_login']);
            $this->user->setPaswd($_POST['usr_paswd']);

            if ( $this->CheckLogin() )
            {
                header("Location: " . $_application_folder . "/steden.php");
            }
            else
            {
                $this->messageService->AddMessage( "Sorry! Verkeerde login of wachtwoord na registratie!", "error" );
                header("Location: " . $_application_folder . "/login.php");
            }
        }
        else
        {
            $this->messageService->AddMessage( "Sorry, er liep iets fout. Uw gegevens werden niet goed opgeslagen", "error" ) ;
        }
    }
}