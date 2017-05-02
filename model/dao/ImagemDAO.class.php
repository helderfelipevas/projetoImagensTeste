<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'projetoImagensTeste/model/dao/AbstractDAO.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'projetoImagensTeste/conexao/Conexao.class.php';

class ImagemDAO extends AbstractDAO {

    private $con;

    function __construct() {
        $this->con = new Conexao();
    }

    function buscarQuantRegistros($inicio, $registros) {
        try {
            $query = "SELECT * FROM imagem limit {$inicio},{$registros}";
            $pdo = $this->getCon()->getConexao()->prepare($query);
            $pdo->execute();

            $dados = $pdo->fetchAll(PDO::FETCH_ASSOC);

            return $dados;
        } catch (Exception $ex) {
            echo $ex->getCode(), $ex->getMessage(), $ex->getFile(), $ex->getLine();
        }
    }

    function cadastrarImagem($bean) {
        try {
            $query = "INSERT INTO imagem (nm_imagem, ds_imagem) VALUES (?,?)";

            $pdo = $this->con->getConexao()->prepare($query);

            $pdo->bindValue(1, $bean->getNmImagem());
            $pdo->bindValue(2, $bean->getDsImagem());
            $pdo->execute();

            if ($pdo->rowCount()) {
                return "Imagem Cadastrada";
            }
        } catch (Exception $ex) {
            echo $ex->getCode(), $ex->getMessage(), $ex->getFile(), $ex->getLine();
        }
    }

    protected function getTabela() {
        return "imagem";
    }

    protected function getCon() {
        return $this->con;
    }

}
