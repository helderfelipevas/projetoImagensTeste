<?php

require_once($_SERVER['DOCUMENT_ROOT'] . 'projetoImagensTeste/model/bo/Resize.class.php');

require_once($_SERVER['DOCUMENT_ROOT'] . 'projetoImagensTeste/model/bo/ImagemBO.class.php');

$acao = $_POST['btnCadastrar'];

if (isset($_FILES["inFile"])) {
    $file = $_FILES["inFile"];
    $nome = $file["name"];
    $tipo = $file["type"];
    $rotaProvisoria = $file["tmp_name"];
    $size = $file["size"];
    $dimensoes = getimagesize($rotaProvisoria);
    $width = $dimensoes[0];
    $height = $dimensoes[1];
    $diretorio = "../view/imagens/";

    //verifica a extensão para ver se é mesmo uma imagem
    if ($tipo != "image/jpg" && $tipo != "image/jpeg" && $tipo != "image/png" && $tipo != "image/gif") {
        echo "Erro. O Arquivo não é uma Imagem.";
    } else {
        //renomeia as imagens
        preg_match("/\.(gif|png|jpg|jpeg){1}$/i", $file["name"], $ext);
        $novoNome = md5(uniqid(time())) . "." . $ext[1];
        //cria o caminho onde vai salvar
        $src = $diretorio . $novoNome;
        //move para onde vai salvar
        move_uploaded_file($rotaProvisoria, $src);
        //echo "<img src='$src'>";
        //Instancia da classe resize que foi utilizada para redimencionar        
        $resizeObj = new resize($diretorio . $novoNome);
        //utilizando o metodo resize
        $resizeObj->resizeImage(1920, 1080, 'crop');
        //salvando a nova imagem
        $resizeObj->saveImage($diretorio . $novoNome, 100);
    }
}

$dados = [
    'cd_imagem' => '',
    'nm_imagem' => $novoNome,
    'ds_imagem' => $_POST['txtDescricao']
];



switch ($acao) {
    CASE "cadastrar":
        $bo = new ImagemBO();
        $bean = $bo->populaBean($dados);
        $bo->cadastrarImagem($bean);
        echo "<script>alert('Cadastro realizado com sucesso!')</script>";
        echo "<script>window.location.assign('../index.php')</script>";
        break;
}


