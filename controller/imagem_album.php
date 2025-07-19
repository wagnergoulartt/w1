<?php
    require_once ('../database/config.php');
    require_once ('../database/config.database.php');
    require_once ('../includes/funcoes.php');
    $id = get('imagem');
    $album = get('album');
?>
<?php $Query = DBRead('fotos_album','*',"WHERE id = '{$id}'"); if (is_array($Query)) { foreach ($Query as $fotos) { ?>
<form method="post" action="?AtualizarImagem=<?php echo $fotos['id']; ?>" enctype="multipart/form-data">
    <div class="form-group">
        <input type="hidden" name="album" value="<?php echo $album; ?>">
        <label>Título da Imagem:</label>
        <input class="form-control" name="titulo" value="<?php echo $fotos['titulo']; ?>" required>
    </div>

    <center>
        <a href="?ExcluirImagem=<?php echo $fotos['id']; ?>&album=<?php echo $album; ?>">
            <button type="button" class="btn btn-danger">Excluir</button>
        </a>
        <button class="btn btn-primary">Salvar</button>
    </center>

</form>
<?php } } ?>