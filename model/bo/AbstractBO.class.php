<?php

abstract class AbstractBO {

    abstract protected function getDAO();

    //Função para listar todos os registros de uma tabela. 

    public function listAll() {
        $dados = $this->getDAO()->listAll();

        return $dados;
    }

}
