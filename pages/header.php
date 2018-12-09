<?php require 'config.php';  ?>

<html>
<head>
    <title>Classificados</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>    
    <script src="assets/js/script.js" type="text/javascript"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a hef="index.php" class="navbar-brand">Classificados</a>
        </div>
            <ul class="nav navbar-nav navbar-right">                
                <?php if(isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])): 
                    require 'classes/usuarios.class.php';
                    ?>
                <li>
                <?= Usuarios::exibeUsuario($_SESSION['cLogin']); ?>
                </li>
                <li><a href="index.php">Home</a></li>
                <li><a href="meus_anuncios.php">Meus anúncios</a></li>
                <li><a href="sair.php">Sair</a></li>
                <?php else: ?>
                <li><a href="index.php">Home</a></li>
                <li><a href="cadastre-se.php">Cadastre-se</a></li>
                <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>          
    </div>    
</nav>
