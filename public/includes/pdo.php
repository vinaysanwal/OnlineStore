<?php

class dbase{
    
    
    //Local Connection Properties
    
    private $host   =   "localhost";
    private $user   =   "root";
    private $pwd    =   "";
    private $dbname =   "virtualines";
    
    
     //Live Connection Properties

//    private $host   =   "localhost";
//    private $user   =   "";
//    private $pwd    =   "";
//    private $dbname =   "";
    
    //Conection Handler
    private $dbh ;
        
    //Error Handler
    private $error;
    
    //Statement Handler
    private $stmt;
    
    
    //Open our connection 
    
    public function __construct(){
        
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
        
        $options = array(
        
        PDO::ATTR_PERSISTENT => true,
            
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            
        );
        //Procedural Way
        //$con = mysqli_connect($host, $user, $pass, $db);
        
        //PDO
        
        try{
            
            $this->dbh = new PDO($dsn, $this->user, $this->pwd, $options);
            
            //echo "Connection Successful";
                
        }catch(PDOException $errorobj){
            
            $this->error = $errorobj->getMessage();
            
            echo $this->error;
            
        }
        
    
        
    }
    
    //Method to handle query statemtent
    public function query($query){          //query("SELECT * FROM users WHERE email = :email ");
        
        $this->stmt = $this->dbh->prepare($query);
        
    }
        
        
    //Method to handle bind values
    public function bind($param, $value , $type){    //bind(":email, $email, PDO::PARAM_STR");
        
        $this->stmt->bindValue($param, $value , $type);
        
    }
        
        
    //Method to execute or run our statement
    public function execute(){
        
        return $this->stmt->execute();
        
    }
        
        
    //Method to fetch single value
    public function fetchSingle(){          //$result = fetchSingle();
        
        $this->execute(); 
        
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
        
    }
    

    //Method to fetch multiple values
    public function fetchMultiple(){
        
        $this->execute(); 
        
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
    }
    
    //Method to count number of rows
    public function fetchColumn(){
        
        $this->execute(); 
        
        return $this->stmt->fetchColumn();
        
    }
        

}


?>


































