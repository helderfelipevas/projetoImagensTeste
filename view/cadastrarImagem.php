<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastrar Imagens</title>
    </head>
    <body>
    <center>
        <h1>Cadastrar Imagens</h1>
        <form id="formCadastro" name="formCadastro" method="POST" action="../controller/cadastrarImagemController.php" enctype="multipart/form-data">               
            Imagem:<input type="file" name="inFile" /><br/><br/>
            <rigth>Descrição da Imagem:<br/></rigth>
            <textarea name="txtDescricao" cols="40" rows="10"/></textarea><br/><br/>                
            <input type="button" name="btnVoltar" value="Voltar" onclick="javascript: location.href = '../index.php';" />
            <input type="submit" name="btnCadastrar" value="cadastrar" />
        </form> 
    </center>
</body>
</html>
