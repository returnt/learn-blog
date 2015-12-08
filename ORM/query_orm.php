<?php defined('SECURITY') or die('No direct script access.');

 require_once 'ORM/FluentPDO/FluentPDO.php';

class query_orm{
    
    protected $HOST = 'localhost';
    protected $USER = 'root';
    protected $PASSWORD = '';
    protected $DB = 'blog';
    protected $fpdo;
            
    function __construct() {
        
        $pdo = new PDO("mysql:dbname=$this->DB; host=$this->HOST", $this->USER, $this->PASSWORD);
        $this->fpdo = new FluentPDO($pdo);
    }

    public function query_select_orm($sql) {

        $mysqli = mysqli_connect($this->HOST, $this->USER, $this->PASSWORD, $this->DB) or die("Не могу соединиться с MySQL.");
        mysqli_query($mysqli, "SET NAMES 'UTF8'");
        $temp_res = mysqli_query($mysqli, $sql);

        $result = array();

        while($row = mysqli_fetch_array($temp_res))
        {
            $result[] = $row;
        }
        
        mysqli_close($mysqli);
        
        return $result;
    }
    
    public function query_insert_orm($sql) {
        
        $mysqli = mysqli_connect($this->HOST, $this->USER, $this->PASSWORD, $this->DB) or die("Не могу соединиться с MySQL.");
        mysqli_query($mysqli, "SET NAMES 'UTF8'");
        mysqli_query($mysqli, $sql);
        $id = mysqli_insert_id($mysqli);
        
        mysqli_close($mysqli);
        
        return $id;
        
    }
    
    public function query_updata_orm($sql) {
        
        $mysqli = mysqli_connect($this->HOST, $this->USER, $this->PASSWORD, $this->DB) or die("Не могу соединиться с MySQL.");
        mysqli_query($mysqli, "SET NAMES 'UTF8'");
        mysqli_query($mysqli, $sql);

        mysqli_close($mysqli);
        
    }
    
    public function query_delete_orm($sql) {
        
        $mysqli = mysqli_connect($this->HOST, $this->USER, $this->PASSWORD, $this->DB) or die("Не могу соединиться с MySQL.");
        mysqli_query($mysqli, "SET NAMES 'UTF8'");
        mysqli_query($mysqli, $sql);
        
        mysqli_close($mysqli);
        
    }
    
    public function slashes($param) {
        
        $mysqli = mysqli_connect($this->HOST, $this->USER, $this->PASSWORD, $this->DB) or die("Не могу соединиться с MySQL.");
        mysqli_query($mysqli, "SET NAMES 'UTF8'");
        $res = mysqli_real_escape_string($mysqli, $param);
        mysqli_close($mysqli);
        
        return $res;
        
    }

}