SELECT *,
(SELECT anuncios_imagens.url
   FROM anuncios_imagens
  WHERE anuncios_imagens.id_anuncio = anuncios.id
) AS url
  FROM anuncios
 WHERE id_usuario = 3