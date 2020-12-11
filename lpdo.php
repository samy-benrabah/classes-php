<?php

class lpdo
{
    public $host;
    public $username;
    public $password;
    public $db;
    public $query;
    public $result;

    public function constructeur($host, $username, $password, $db)
    {
        $bdd = '';
        $bdd = mysqli_connect($host, $username, $password, $db);
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;

        if ($bdd) {
            $this->bdd = $bdd;
            echo " Vous êtes connectés ";
        } else {
            echo "Connexion échoué";
        }

    }
    public function connect($host, $username, $password, $db)
    {
        if (isset($this->bdd)) {
            unset($this->bdd);
        } else {
            $this->db = mysqli_connect($host, $username, $password, $db);
        }
    }
    public function destructeur()
    {
        if (isset($this->bdd)) {
            unset($this->bdd);
        } else {
            return false;
        }
    }
    public function close()
    {
        if (isset($this->bdd)) {
            unset($this->bdd);
        } else {
            return false;
        }
    }
    public function execute($query)
    {
        if (isset($this->bdd)) {
            $this->query = $query;
            $requête = mysqli_query($this->bdd, $this->query);
            $this->result = mysli_fetch_all($requête);
            return $this->result;
        } else {
            return false;
        }
        var_dump($this->result);
    }
    public function getLastQuery()
    {
        if (isset($this->query)) {
            return $this->query;
        } else {
            return false;
        }

    }
    public function getLastResult()
    {
        if (isset($this->query)) {
            return $this->result;
        } else {
            return false;
        }

    }
    public function getTables()
    {

        if (isset($this->bdd)) {
            $this->query = "SHOW TABLES";
            $requête = mysqli_query($this->bdd, $this->query);
            $this->result = mysqli_fetch_all($requête);
        } else {
            return false;
        }

    }
    public function getFields($table)
    {
        if (isset($this->bdd)) {
            $this->query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' AND TABLE_SCHEMA='classes'";
            $requête = mysqli_query($this->bdd, $this->query);
            $this->result = mysqli_fetch_all($requête);
            return $result;
            return false;
        } else {
            return false;
        }

    }

}
