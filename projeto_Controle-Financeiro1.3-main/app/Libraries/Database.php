<?php 

class Database
{
    private $host = 'localhost';
    private $usuario = 'root';
    private $senha = '12345';
    private $banco = 'bisa_teste';
    private $porta = '3306';
    private $dbh;
    private $stmt;
    
    
    public function conexao()
    {
      $dsn = 'mysql:host='.$this->host.';port='.$this->porta.';dbname='.$this->banco.'password='.$this->senha;
      $opcoes = 
      [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        
      ];
     try {
       $this->dbh = new PDO($dsn, $this->usuario, $this->senha, $this->host, $opcoes);
       
     } 
        catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
       
        die();
     }
    }

    public function query($sql){
      
        $this->stmt = $this->dbh->prepare($sql);
    }

    public function bind($parametro, $valor, $tipo = null){
        if(is_null($tipo)):
            switch(true):
                case is_int($valor):
                    $tipo = PDO::PARAM_INT;
                break;
                case is_bool($valor):
                    $tipo = PDO::PARAM_BOOL;
                break;
                case is_null($valor):
                    $tipo = PDO::PARAM_NULL;
                break;
                default:
                    $tipo = PDO::PARAM_STR;
                break;

            endswitch;
        endif;    

        $this->stmt->bindValue($parametro, $valor, $tipo);

    }

    public function executa(){
        return $this->stmt->execute();
    }

    public function resultado(){
        $this->executa();   
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function resultados(){
        $this->executa();   
        return $this->stmt->fetchALL(PDO::FETCH_OBJ);
    }

    public function totalResultados(){
        return $this->stmt->rowCount();
    }

    public function ultimoIdInserido(){
        return $this->dbh->lastInsertId();
    }



}
 ?>
