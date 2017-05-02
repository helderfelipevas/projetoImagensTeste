<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'projetoImagensTeste/model/dao/ImagemDAO.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'projetoImagensTeste/model/bo/AbstractBO.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'projetoImagensTeste/model/bean/ImagemBEAN.class.php';

class ImagemBO extends AbstractBO {

    private $dao;

    function __construct() {
        $this->dao = new ImagemDAO();
    }

    //Funções

    function cadastrarImagem($bean) {
        return $this->dao->cadastrarImagem($bean);
    }

    function buscarQuantRegistros($inicio, $registros) {
        return $this->dao->buscarQuantRegistros($inicio, $registros);
    }

    function populaBean($dados) {
        $bean = new ImagemBean();

        $bean->setCdImagem($dados['cd_imagem']);
        $bean->setNmImagem($dados['nm_imagem']);
        $bean->setDsImagem($dados['ds_imagem']);

        return $bean;
    }

    protected function getDAO() {
        return $this->dao;
    }

}
