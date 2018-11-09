<?php

class Anuncios {

    public function getMeusAnuncios() {
        global $pdo;

        $array = array();
        $sql = $pdo->prepare("SELECT *,
                             (SELECT anuncios_imagens.url
                                FROM anuncios_imagens
                               WHERE anuncios_imagens.id_anuncio = anuncios.id
                               LIMIT 1
                                ) AS url
                                FROM anuncios
                               WHERE id_usuario = :id_usuario");
        $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function getAnuncio($id) {
        $array = array();
        global $pdo;

        $sql = $pdo->prepare("SELECT * FROM anuncios WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();
            $array['fotos'] = array();

            $sql = $pdo->prepare("SELECT id, url FROM anuncios_imagens WHERE id_anuncio = :id_anuncio");
            $sql->bindValue(":id_anuncio", $id);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $array['fotos'] = $sql->fetchAll();
            }
        }
        return $array;
    }

    public function addAnuncio($titulo, $categoria, $valor, $descricao, $estado) {
        global $pdo;
        $sql = $pdo->prepare(" INSERT INTO anuncios "
                . "   SET titulo = :titulo"
                . " , id_categoria = :id_categoria"
                . " , id_usuario = :id_usuario"
                . " , descricao = :descricao"
                . " , valor = :valor"
                . " , estado = :estado");
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":id_categoria", $categoria);
        $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":estado", $estado);
        $sql->execute();
    }

    public function excluirAnuncio($id) {

        global $pdo;


        $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id_anuncio = :id_anuncio");
        $sql->bindValue(":id_anuncio", $id);
        $sql->execute();

        $sql = $pdo->prepare("DELETE FROM anuncios WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function editAnuncio($titulo, $categoria, $valor, $descricao, $estado, $fotos, $id) {
        global $pdo;
        $sql = $pdo->prepare("UPDATE anuncios
                                 SET titulo = :titulo,
                                     id_categoria = :id_categoria,
                                     descricao = :descricao,
                                     valor = :valor,
                                     estado = :estado                                     
                               WHERE id = :id");
        //$sql->bindValue(":id_usuario", $_SESSION['cLogin']);        
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":id_categoria", $categoria);
		$sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":estado", $estado);
        $sql->bindValue(":id", $id);
        $sql->execute();

        //se houver inclusão de imagem...
        $qtd_fotos = count($fotos['tmp_name']);

        if ($qtd_fotos > 0) {
            for ($q = 0; $q < $qtd_fotos; $q++) {
                $tipo = $fotos['type'][$q]; //na primeira foto o tipo será...
                //aceitando somente imagens com tipos jpeg ou png
                if (in_array($tipo, array('image/jpeg', 'image/png'))) {
                    //todas as imagens serão convertidas em jpeg com um nome de hash aleatório.
                    $tmpname = md5(time() . rand(0, 99)) . '.jpg';
                    //movendo as fotos inclusas para a pasta...
                    move_uploaded_file($fotos['tmp_name'][$q], 'assets/images/anuncios/' . $tmpname);

                    //tratamento do tamanho da imagem original
                    list($width_orig, $height_orig) = getimagesize('assets/images/anuncios/' . $tmpname);
                    $ratio = $width_orig / $height_orig;

                    //definir o limite da imagem
                    $width = 500;
                    $height = 500;

                    //verifica o tamanho da imagem original e restringe ao limite dos parâmetros da imagem
                    if ($width / $height > $ratio) {
                        $width = $height * $ratio;
                    } else {
                        $height = $width / $ratio;
                    }

                    //criando a nova imagem com as medidas padrões do sistema
                    $img = imagecreatetruecolor($width, $height);
                    //verificando primeiro qual o tipo de imagem
                    if ($tipo == 'image/jpeg') {
                        $origi = imagecreatefromjpeg('assets/images/anuncios/' . $tmpname);
                    } elseif ($tipo == 'image/png') {
                        $origi = imagecreatefrompng('assets/images/anuncios/' . $tmpname);
                    }

                    imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                    //salvando a nova imagem no servidor com a qualidade 80
                    imagejpeg($img, 'assets/images/anuncios/' . $tmpname, 80);

                    //salvando a imagem no banco de dados
                    $sql = $pdo->prepare("INSERT INTO anuncios_imagens (id, id_anuncio, url)
					                           VALUES (0, :id_anuncio, :url)
										");
                    //recebe a variável do anúncio
                    $sql->bindValue(":id_anuncio", $id);
                    //recebe a variável do tmpname
                    $sql->bindValue(":url", $tmpname);
                    $sql->execute();
                }
            }


            //print_r($fotos);
            //exit;
        }
    }

    public function excluirFoto($id) {
        global $pdo;
        $id_anuncio = 0;

        $sql = $pdo->prepare("SELECT id_anuncio FROM anuncios_imagens WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();
            $id_anuncio = $row['id_anuncio'];
        }

        $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        return $id_anuncio;
    }

    public function getTotalAnuncios() {
        global $pdo;

        $sql = $pdo->query("SELECT COUNT(*) as c FROM anuncios");
        $row = $sql->fetch();

        return $row['c'];
    }
    
    public function getUltimosAnuncios(){
        $array = array();
        global $pdo;
        
          $sql = $pdo->prepare(
                "SELECT *,
                (SELECT anuncios_imagens.url 
                FROM anuncios_imagens
                WHERE anuncios_imagens.id_anuncio = anuncios.id
                LIMIT 1) as url,
                (SELECT categorias.nome
                FROM categorias
                WHERE categorias.id = anuncios.id_categoria) as categoria
                FROM anuncios
                ORDER BY id DESC"
                );
        $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
        $sql->execute();
        
        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }
        return $array;        
    }
}
