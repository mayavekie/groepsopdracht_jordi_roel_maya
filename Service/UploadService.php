<?php


class UploadService
{
    private $target_dir = "../img/";
    private $max_size = 20000000;
    private $allowed_extensions = [ "jpeg", "jpg", "png", "gif" ];
    private $returnvalue = true;
    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    // functies voor upload functions

    public function CheckUploadedFile($upfile)
    {
        $this->CheckIfRealImage($upfile);
        $this->CheckIfFileExists($upfile);
        $this->CheckFileSize($upfile);
        $this->CheckFileFormat($upfile);

        return $this->returnvalue;
    }

    private function CheckIfRealImage($upfile) {
        global $MS;
        // Check if image file is a actual image or fake image
        if ($upfile["getimagesize"] === false) {
            $MS->AddMessage("File " . $upfile["name"] . " is not an image.", "error");
            $this->setReturnvalue(false);
        }
    }

    private function CheckIfFileExists($upfile) {
        global $MS;
        // Check if file already exists
        if (file_exists($upfile["target_path_name"])) {
            $MS->AddMessage("File  " . $upfile["name"] . " already exists.", "error");
            $this->setReturnvalue(false);
        }
    }

    private function CheckFileSize($upfile) {
        global $MS;
        // Check file size
        if ($upfile["size"] > $this->max_size) {
           $MS->AddMessage("File  " . $upfile["name"] . "  is too large.", "error");
            $this->setReturnvalue(false);
        }
    }

    private function CheckFileFormat($upfile) {
        global $MS;
        // Allow only certain file formats
        if (!in_array($upfile["extension"], $this->allowed_extensions)) {
            $MS->AddMessage("Wrong extension. Only " . implode(", ", $this->allowed_extensions) . " files are allowed.", "error");
            $this->setReturnvalue(false);
        }
    }

    public function ResponseToUpload($result, $upfile){
        global $MS;
        if ( !$result ) $MS->AddMessage("Sorry, your file was not uploaded.", "error");
        else {
            //bestand verplaatsen naar definitieve locatie + naam
            if ( move_uploaded_file( $upfile["tmp_name"], $upfile["target_path_name"] )) {
                $MS->AddMessage("The file " . $upfile["name"] . " has been uploaded as " . $upfile["target_path_name"]);
            }
            else {
                $MS->AddMessage("Sorry, there was an unexpected error uploading file " . $upfile["name"], "error");
            }
        }
    }

    public function ProcesFiles() {
        //overloop alle bestanden in $_FILES
        foreach ( $_FILES as $f )
        {
            $upfile = array();
            $upfile["name"]             = basename($f["name"]);
            $upfile["tmp_name"]         = $f["tmp_name"];
            $upfile["target_path_name"] = $this->getTargetDir() . $upfile["name"];
            $upfile["extension"]        = pathinfo($upfile["name"], PATHINFO_EXTENSION);
            $upfile["getimagesize"]     = getimagesize($upfile["tmp_name"]);
            $upfile["size"]             = $f["size"];

            $result = $this->CheckUploadedFile( $upfile );
            $this->ResponseToUpload($result, $upfile);
        }
    }

    // functies voor upload functions profile

    public function CheckUploadProfile(){
        $this->CheckProfileSize();
        $this->CheckProfileFormat();
        $this->CheckIfRealProfileImage();
        $this->CheckIfProfileAlreadyExsists();
    }

    public function CheckProfileSize(){
        //grootte
        global $size;
        global $originele_naam;
        global $MS;

        if ( $size > $this->getMaxSize() )
        {
            $MS->AddMessage("Bestand " . $originele_naam . " is te groot (" . $size . " bytes). Maximum " . $this->getMaxSize() . " bytes!", "error");
            $this->setReturnvalue(false);
        }
    }

    public function CheckProfileFormat() {
        global $originele_naam;
        global $MS;

        //toegelaten extensies
        if ( ! in_array( pathinfo($originele_naam, PATHINFO_EXTENSION), $this->getAllowedExtensions() ))
        {
            $MS->AddMessage("Bestand " . $originele_naam . ": verkeerde bestandsextensie!", "error");
            $this->setReturnvalue(false);
        }
    }

    public function CheckIfRealProfileImage() {
        global $tmp_name;
        global $originele_naam;
        global $MS;

        //is het bestand wel echt een afbeelding?
        if ( getimagesize($tmp_name) === false)
        {
            $MS->AddMessage("Bestand " . $originele_naam . " is niet echt een afbeelding!", "error");
            $this->setReturnvalue(false);
        }
    }

    public function CheckIfProfileAlreadyExsists() {
        global $target;
        global $originele_naam;
        global $MS;

        //bestaat het bestand al?
        if ( file_exists($target) )
        {
            $MS->AddMessage("Bestand " . $originele_naam . "bestaat al!", "error");
            $this->setReturnvalue(false);
        }
    }

    public function SaveProfile() {
        global $images;
        global $Container;

        $sql = "update users SET " . implode("," , $images) . " where usr_id=" . $_SESSION['usr']->getId();
        $Container->getPDOtoExecute($sql);
    }

   // Getters and Setters

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
