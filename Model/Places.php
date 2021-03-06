<?php


 abstract class Places
{
    private $id;
    private $filename;
    private $title;
    private $sql_body;
    private $tablename;
    private $formname;
    private $afterinsert;
    private $pkey;
    private $new_url;

    public function Load(){
        $this->tablename = $_POST["tablename"];
        $this->formname = $_POST["formname"];
        $this->afterinsert = $_POST["afterinsert"];
        $this->pkey = $_POST["pkey"];
    }

    /**
     * @return mixed
     */
    public function getNewUrl()
    {
        return $this->new_url;
    }

    /**
     * @param mixed $new_url
     */
    public function setNewUrl($new_url)
    {
        $this->new_url = $new_url;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->filename;
    }

    /**
     * @param mixed $name
     */
    public function setFileName($name)
    {
        $this->filename = $name;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getSqlBody()
    {
        return $this->sql_body;
    }

    /**
     * @param mixed $sql_body
     */
    public function setSqlBody($sql_body)
    {
        $this->sql_body = $sql_body;
    }

    /**
     * @return mixed
     */
    public function getTablename()
    {
        return $this->tablename;
    }

    /**
     * @param mixed $tablename
     */
    public function setTablename($tablename)
    {
        $this->tablename = $tablename;
    }

    /**
     * @return mixed
     */
    public function getFormname()
    {
        return $this->formname;
    }

    /**
     * @param mixed $formname
     */
    public function setFormname($formname)
    {
        $this->formname = $formname;
    }

    /**
     * @return mixed
     */
    public function getAfterinsert()
    {
        return $this->afterinsert;
    }

    /**
     * @param mixed $afterinsert
     */
    public function setAfterinsert($afterinsert)
    {
        $this->afterinsert = $afterinsert;
    }

    /**
     * @return mixed
     */
    public function getPkey()
    {
        return $this->pkey;
    }

    /**
     * @param mixed $pkey
     */
    public function setPkey($pkey)
    {
        $this->pkey = $pkey;
    }
}