<?php


class UploadService
{
    private $pdo;
    private $upload;
    private $messageService;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
        $this->upload = new Upload();
        $this->messageService = new MessageService();
    }

    public function CheckUploadedFile($upfile)
    {
        $this->CheckIfRealImage($upfile);
        $this->CheckIfFileExists($upfile);
        $this->CheckFileSize($upfile);
        $this->CheckFileFormat($upfile);

        return $this->upload->isReturnvalue();
    }

    private function CheckIfRealImage($upfile) {
        // Check if image file is a actual image or fake image
        if ($upfile["getimagesize"] === false) {
            $this->messageService->AddMessage("File " . $upfile["name"] . " is not an image.", "error");
            $this->upload->setReturnvalue(false);
        }
    }

    private function CheckIfFileExists($upfile) {
        // Check if file already exists
        if (file_exists($upfile["target_path_name"])) {
            $this->messageService->AddMessage("File  " . $upfile["name"] . " already exists.", "error");
            $this->upload->setReturnvalue(false);
        }
    }

    private function CheckFileSize($upfile) {
        // Check file size
        if ($upfile["size"] > $this->upload->getMaxSize()) {
           $this->messageService->AddMessage("File  " . $upfile["name"] . "  is too large.", "error");
            $this->upload->setReturnvalue(false);
        }
    }

    private function CheckFileFormat($upfile) {
        // Allow only certain file formats
        if (!in_array($upfile["extension"], $this->upload->getAllowedExtensions())) {
            $this->messageService->AddMessage("Wrong extension. Only " . implode(", ", $this->upload->getAllowedExtensions()) . " files are allowed.", "error");
            $this->upload->setReturnvalue(false);
        }
    }

    public function ResponseToUpload($result, $upfile){
        if ( !$result ) $this->messageService->AddMessage("Sorry, your file was not uploaded.", "error");
        else {
            //bestand verplaatsen naar definitieve locatie + naam
            if ( move_uploaded_file( $upfile["tmp_name"], $upfile["target_path_name"] )) {
                $this->messageService->AddMessage("The file " . $upfile["name"] . " has been uploaded as " . $upfile["target_path_name"]);
            }
            else {
                $this->messageService->AddMessage("Sorry, there was an unexpected error uploading file " . $upfile["name"], "error");
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
            $upfile["target_path_name"] = $this->upload->getTargetDir() . $upfile["name"];
            $upfile["extension"]        = pathinfo($upfile["name"], PATHINFO_EXTENSION);
            $upfile["getimagesize"]     = getimagesize($upfile["tmp_name"]);
            $upfile["size"]             = $f["size"];

            $result = $this->CheckUploadedFile( $upfile );
            $this->ResponseToUpload($result, $upfile);
        }
    }
}
