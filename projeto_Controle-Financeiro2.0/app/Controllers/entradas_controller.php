<?php

require '../Models/entradas_model.php';

class Entrada
{

    private $entradaModel;

     public function __construct()
    {
        $this->entradaModel = new EntradasModelo();
    }
     public function salvarEntrada()
    {
       if ($_SERVER['REQUEST_METHOD'] != 'POST') {
          echo 'Metodo invalido';
         return;
     }
     $data = json_decode(file_get_contents('php://input'), true);
     $id_tipo = $data['id2'];
    $date = date("Y-m-d H:i:s");
     $descricao = $data['descricao'];
     $valor = $data['valor'];

     
     $entrada = $this->entradaModel->salvarEntrada($id_tipo, $date, $descricao, $valor);

     if ($entrada == null) {
          echo 'Possivel error';
          return;
        }

     echo 'Entrada salva.';
    }

     public function listarEntrada()
    {
     if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        echo 'Metodo invalido';
         return;
      }
        
     $entradas = $this->entradaModelo->listarModel();
        $total = $this->entradaModelo->pegarTotal();
     $resultado['entradas'] = $entradas;
    $resultado['total'] = $total[0]['total'];
     echo json_encode($resultado);

    }
     public function deletEntrada()
    {
     if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo 'Metodo invalido';
        return;
  }

  $data = json_decode(file_get_contents('php://input'), true);
     $id = $data['id'];
        
     if(trim($id == null)){
        echo 'O id_tipo é nulo';
        return;
  }
    else if (is_string($id)){
         echo 'O id_tipo não pode ser string';
        return;
     }
     
     $del = $this->entradaModelo->deletarModel($id);
     $arrayz['id'] = $id;
     $arrayz['status'] = $del;
     $arrayz['msg'] = "DELETEI";
     echo json_encode($arrayz);
    }

     public function editarEntrada()
    {
     if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
     echo 'Metodo invalido';
     return;
     }
    
      $data = json_decode(file_get_contents('php://input'), true);
      $id = $data['id'];
     $id2 = $data['id2'];
      $descricao = $data['descricao'];
     $valor = $data['valor'];


     $resposta = $this->entradaModelo->editarModel($id, $id2, $descricao, $valor);
    $arrayz['id'] = $id;
     $arrayz['descricao'] = $descricao;
     $arrayz['status'] =  $resposta;
     $arrayz['valor'] =  $valor;
      echo json_encode($arrayz);
    }
}
$funcao = $_GET['funcao'];
$classe = new Entrada();

$classe->$funcao();
