<?php
require_once $_SERVER['DOCUMENT_ROOT'] . 'projetoImagensTeste/model/bo/ImagemBO.class.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Listar Imagens</title>

        <link rel="stylesheet" href="dist/css/lightbox.min.css">
        <link rel="stylesheet" href="dist/css/lightbox.css">
        <script src="dist/js/lightbox-plus-jquery.min.js"></script>

    </head>
    <body> 
        <center>
            <h1>Listar Imagens</h1>
            <?php
                //verifica a página atual caso seja informada na URL, senão atribui como 1ª página
                $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

                //seleciona todos os itens da tabela
                $bo = new ImagemBO();
                $imagens = $bo->listAll();

                //conta o total de itens
                $quant = count($imagens);

                //seta a quantidade de itens por página
                $registros = 10;

                //calcula o número de páginas arredondando o resultado para cima
                $numPaginas = ceil($quant / $registros);

                //variavel para calcular o início da visualização com base na página atual
                $inicio = ($registros * $pagina) - $registros;

                //seleciona os itens por página
                $imagens = $bo->buscarQuantRegistros($inicio, $registros);
                $quant = count($imagens);

                //exibe as imagens selecionadas
                foreach ($imagens as $imagem) {
                    echo "<a class='example-image-link' href='imagens/" . $imagem['nm_imagem'] . "' data-lightbox='example-set' data-title='" . $imagem['ds_imagem'] . "'><img class='example-image' src='imagens/" . $imagem['nm_imagem'] . "' alt='' width='120' height='120'/></a>";
                }
                echo '<br/>';

                //exibe a paginação
                if ($pagina > 1) {
                    echo "<a href='listarImagem.php?pagina=" . ($pagina - 1) . "' class='controle'>&laquo; anterior</a>";
                }

                for ($i = 1; $i < $numPaginas + 1; $i++) {
                    $ativo = ($i == $pagina) ? 'numativo' : '';
                    echo "<a href='listarImagem.php?pagina=" . $i . "' class='numero " . $ativo . "'> " . $i . " </a>";
                }

                if ($pagina < $numPaginas) {
                    echo "<a href='listarImagem.php?pagina=" . ($pagina + 1) . "' class='controle'>proximo &raquo;</a>";
                }
            ?>
        </center>
    </body>
</html>
