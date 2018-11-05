<?php require 'pages/header.php'; ?>

<?php
require 'classes/anuncios.class.php';
$a = new Anuncios();
$total_anuncios = $a->getTotalAnuncios();
?>


<div class="container-fluid">
    <div class="jumbotron">
        <h2>Nós temos hoje <?php echo $total_anuncios; ?> anúncios.</h2>
       
        <?php 
        $total_usuarios = 110;
        //if(isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin']): require 'classes/usuarios.class.php':
        
        
        
        //$u = new Usuarios();
        //$total_usuarios = $u->getTotalUsuarios();
        //?>
        <p>E mais de <?php echo $total_usuarios; ?> usuários cadastrados.</p>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <h4>Pesquisa avançada</h4>
        </div>
        <div class="col-sm-9">
            <h4>Últimos anúncios</h4>
        </div>
    </div>
</div>


<?php require 'pages/footer.php'; ?>
