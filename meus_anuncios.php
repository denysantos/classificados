<?php require 'pages/header.php'; ?>
<?php
if (empty($_SESSION['cLogin'])) {
    ?>

    <script type="text/javascript">window.location.href = "login.php";</script>

    <?php
    exit;
}
?>
<div class="container">
    <h1>Meus anúncios</h1>    

    <a href="add_anuncio.php" class="btn btn-default">Adicionar Anúncio</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Título</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <?php
        require 'classes/anuncios.class.php';
        $a = new Anuncios();
        $anuncios = $a->getMeusAnuncios();

        foreach ($anuncios as $anuncio) {
            ?>

            <tr>
                <td>
                    <?php if (!empty($anuncio['url'])): ?>

                        <img src="assets/images/anuncios/<?php echo $anuncio['url']; ?>" height="50" border="0">

    <?php else: ?>

                        <img src="assets/images/default.JPG" height="50" border="0" />

    <?php endif; ?>

                </td>
                <td><?php echo $anuncio['titulo']; ?></td>
                <td>R$ <?php echo number_format($anuncio['valor'], 2); ?></td>
                <td>
                    <a href="editar_anuncio.php?id=<?php echo $anuncio['id'] ?>" class="btn btn-success">Editar</a>
                    <a href="excluir_anuncio.php?id=<?php echo $anuncio['id'] ?>" class="btn btn-danger">Excluir</a>
                </td>
    <?php
}
?>
        </tr>

    </table>

</div>
<?php require 'pages/footer.php'; ?>