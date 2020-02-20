<?php 
class Database{
    
    private $host = DB_HOST;
    private $user = DB_USER;
    private $passwd = DB_PASSWD;
    private $dbname = DB_NAME;
    private $dbport = DB_PORT;
    
    private $dbh;
    private $stmt;
    private $error;
    
    public function __construct()
    {
        $dsn = 'mysql:host='.$this->host.';port='.$this->dbport.';dbname='.$this->dbname;
        $opt = [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        try{
            $this->dbh = new PDO($dsn, $this->user, $this->passwd, $opt);
        }catch(PDOException $err){
            $this->error = $err->getMessage();
            echo "*******".$this->error."*******";
        }

    }

    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    public function placeholders($param, $value, $type = null)
    {
        if(is_null($type))
        {
            if(is_int($value))
                $type = PDO::PARAM_INT;
            else if(is_bool($value))
                $type = PDO::PARAM_BOOL;
            else if(is_null($value))
                $type = PDO::PARAM_NULL;
            else
                $type = PDO::PARAM_STR;
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execution()
    {
        return $this->stmt->execute();
    }

    public function result()
    {
        $this->execution();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function single()
    {
        $this->execution();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

}