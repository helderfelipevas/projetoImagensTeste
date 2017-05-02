<?php

class ImagemBEAN {

    private $cdImagem;
    private $nmImagem;
    private $dsImagem;

    function getCdImagem() {
        return $this->cdImagem;
    }

    function getNmImagem() {
        return $this->nmImagem;
    }

    function getDsImagem() {
        return $this->dsImagem;
    }

    function setCdImagem($cdImagem) {
        $this->cdImagem = $cdImagem;
    }

    function setNmImagem($nmImagem) {
        $this->nmImagem = $nmImagem;
    }

    function setDsImagem($dsImagem) {
        $this->dsImagem = $dsImagem;
    }

}
