<?php
require '../Models/tipo_entrada_model.php';

class TipoEntrada
{
    private $tipoModelo;
    public function __construct()
    {
        $this->tipoModelo = new EntradasModel();
    }
    public function salvarTipo()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo 'Metodo invalido';
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $nomeTipo = $data['nome'];

        if (trim($nomeTipo) == null) {
            echo  'error nulo';
        } else if (is_numeric($nomeTipo)) {
            echo 'e numeros';
        } else if (strlen($nomeTipo) > 15) {
            echo 'error';
        } else {
            $resposta = $this->tipoModelo->salvar($nomeTipo);
            $arrayz['nome'] = $data['nome'];
            $arrayz['id'] = $resposta;
            echo json_encode($arrayz);
        }

  
    }

}  

$funcao = $_GET['funcao'];
$classe = new TipoEntrada();

$classe->$funcao();
