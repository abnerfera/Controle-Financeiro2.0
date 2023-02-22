<?php

require '../Models/saidas_model.php';



class Saida
{

     private $saidaModelo;

     public function __construct()
    {
     $this->saidaModel = new SaidaModelo();
    }
     public function salvarSaida()
    {
     if ($_SERVER['REQUEST_METHOD'] != 'POST') {
     echo 'Método invalido';
     return;
      }
     $data = json_decode(file_get_contents('php://input'), true);
     $id_tipo = $data['id2'];
     $date = date("Y-m-d H:i:s");
     $descricao = $data['descricao'];
     $valor = $data['valor'];

      $resposta = $this->saidaModelo->salvarModel($id_tipo, $descricao, $date, $valor);
         $arrayz['descricao'] = $data['descricao'];
         $arrayz['date'] = date("Y/m/d");
         $arrayz['id'] =  $resposta;
         $arrayz['id2'] =  $data['id2'];
         $arrayz['valor'] =  $data['valor'];
        echo json_encode($arrayz);
        

    }
     public function listarSaidas()
    {
     if($_SERVER['REQUEST_METHOD'] != 'GET'){
        echo 'Método invalido';
           return;
     }
    $saidas = $this->saidaModelo->listarModel();
    $total = $this->saidaModelo->pegarTotal();
     $resultado['saidas'] = $saidas;
     $resultado['total'] = $total[0]['total'];
     echo json_encode($resultado);
    }
     public function deletSaida()
    {
     if($_SERVER['REQUEST_METHOD'] != 'POST'){
         echo 'Método invalido';
        return;
        }
        
     $data = json_decode(file_get_contents('php://input'), true);
     $id = $data['id'];

     if(trim($id == null)){
        echo 'O id_tipo é nulo';
        return;
        }
     else if (is_string($id)){
        echo 'O id_tipo não pode ser uma string';
         return;
        }

    $del = $this->saidaModelo->deletarModel($data['id']);
       $arrayz['id'] = $data['id'];
    $arrayz['status'] = $del;
     $arrayz['msg'] = "DELETEI";
     echo json_encode($arrayz);
    }
    public function editarSaida()
    {
     if($_SERVER['REQUEST_METHOD'] != 'PUT'){
            echo 'Método invalido';
            return;
     }
        
     $data = json_decode(file_get_contents('php://input'), true);
     $id = $data['id'];
     $id2 = $data['id2'];
     $descricao = $data['descricao'];
     $valor = $data['valor'];

       
        
      $resposta = $this->saidaModelo->editarModel($id, $id2, $descricao, $valor);
      $arrayz['id'] = $id;
      $arrayz['descricao'] = $data['descricao'];
      $arrayz['status'] =  $resposta;
     $arrayz['valor'] =  $valor;
     echo json_encode($arrayz);
    }
}
$funcao = $_GET['funcao'];
$classe = new Saida();

$classe->$funcao();
