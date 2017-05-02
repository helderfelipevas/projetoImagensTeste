<?php

abstract class AbstractDAO {

    abstract protected function getTabela();

    abstract protected function getCon();

    public function listAll() {

        $query = "SELECT * FROM {$this->getTabela()}";
        $pdo = $this->getCon()->getConexao()->prepare($query);
        $pdo->execute();

        $dados = $pdo->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }

}
