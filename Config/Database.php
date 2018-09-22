<?php
class Database{

    private $host = "localhost";
    private $db_name = "todo";
    private $username = "root";
    private $password = "";
    private $csvfile = "db.csv";
    public $conn;
    
    // Fungsi untuk pengesetan database
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password, array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

    public function getCSV(){
        if(!file_exists($this->csvfile)) 
        {
            die("File not found. Make sure you specified the correct path.");
        }

        $affectedRows = $this->conn->exec
        (
            "LOAD DATA LOCAL INFILE "
            .$this->conn->quote($this->csvfile)
            ." INTO TABLE `tbltodo` FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n'"
        );
        echo "Loaded a total of $affectedRows records from this csv file.\n";

    }


    
    
}
?>