<?php require 'pages/header.php'; ?>

<?php
require 'classes/anuncios.class.php';
$a = new Anuncios();
$total_anuncios = $a->getTotalAnuncios();
$anuncios = $a->getUltimosAnuncios();

//a classe de usuários já está sendo chamada no arquivo pages/header.php
$u = new Usuarios();
$total_usuarios = $u->getTotalUsuarios();
?>


<div class="container-fluid">
    <div class="jumbotron">
        <h2>Nós temos hoje <?php echo $total_anuncios; ?> anúncios.</h2>
        <p>E mais <?php echo $total_usuarios; ?> usuários cadastrados.</p>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <h4>Pesquisa avançada</h4>
        </div>
        <div class="col-sm-9">
            <h4>Últimos anúncios</h4>
            <table class="table table-striped">
                <tbody>
                    <?php foreach($anuncios as $anuncio): ?>
                    <tr>
                         
                        <td>
                            <?php if(!empty($anuncio['url'])):?>
                            <img src="assets/images/anuncios/<?php echo $anuncio['url'];?>" height="50" border="0"/>
                            <?php else: ?>
                                 <img src="assets/images/default.JPG" height="50" border="0" />
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="produto.php?id=<?php echo $anuncio['id'];?>"><?php echo $anuncio['titulo'];?></a>
                            <?php echo utf8_encode($anuncio['categoria']);?>                         
                        </td>
                        <td>
                            R$ <?php echo number_format($anuncio['valor'],2);?>
                        </td>
                       
                    </tr>
                    <?php endforeach;?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php require 'pages/footer.php'; ?>
