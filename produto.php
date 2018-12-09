<?php require 'pages/header.php'; ?>
<?php
require 'classes/anuncios.class.php';
//require 'classes/usuarios.class.php';
$a = new Anuncios();
//$u = new Usuarios();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = addslashes($_GET['id']);
} else {
    ?>
    <script type="text/javascript">window.location.href = "login.php"; ></script>
    <?php
    exit;
}

$info = $a->getAnuncio($id);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <div class="carousel slide" data-ride="carousel" id="meuCarousel">
                <div class="carousel-inner" role="listbox">
                    <?php foreach ($info['fotos'] as $chave => $foto): ?>
                        <div class="item <?php echo ($chave == '0') ? 'active' : ''; ?>">
                            <img src="assets/images/anuncios/<?php echo $foto['url']; ?>"/>
                        </div>
                    <?php endforeach; ?>
                </div>   
                <a class="left carousel-control" href="#meuCarousel" role="button" data-slide="prev">
                    <div class="produto-botoes">
                        <span class='glyphicon glyphicon-chevron-left'></span>
                
                    </div>
                </a>
                <a class="right carousel-control" href="#meuCarousel" role="button" data-slide="next">
                    <div class="produto-botoes">
                        <span class='glyphicon glyphicon-chevron-right'></span>
                    </div>
                </a>
            </div>
        </div>
    
    <div class="col-sm-8">
        <h1><?php echo $info['titulo']; ?></h1>
        <h4><?php echo utf8_encode($info['categoria']); ?></h4>
        <p><?php echo $info['descricao']; ?></p>
        <h3>R$ <?php echo number_format($info['valor'], 2); ?></h3>
        <h3>Fone: <?php echo $info['telefone']; ?></h3>
    </div>
    </div>
</div>





<?php require 'pages/footer.php'; ?>
