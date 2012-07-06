Vanuatu Image Buffer
====================
Redimenciona imagens e as grava em um buffer, sempre que solicitado a criação
de uma imagem já existente no banco o sistema apenas redireciona para a imagem
criada anteriormente evitando processamento desnecessario do servidor.

Facilidades
-----------
* Você não precisa mais se preocupar com a criação de thumbs
* Sempre que uma imagem não for mais encontrada, retornará uma imagem padrão

Como Utilizar
-------------
Descompacte o sistema em qualquer pagina no seu servidor, então configure o 
caminho padrão da sua pasta de imagens no arquivo config.php, agora acesse:
* http://seusite/PASTA_DO_SISTEMA/200x200/caminho/da/sua/imagem.jpg ou
* http://seusite/PASTA_DO_SISTEMA/caminho/da/sua/imagem_-_200x200.jpg
que o sistema ira gerar thumbs do tamanho 200x200 de sua imagem, se você quizer
gerar imagens em outras proporções, apenas mude o 200x200 para a proporção que
desejar, estas imagens podem ser lincadas em arquivos HTML ou CSS sem problemas:
* <img src="PASTA_DO_SISTEMA/200x200/caminho/da/sua/imagem.jpg"> ou
* <img src="PASTA_DO_SISTEMA/caminho/da/sua/imagem_-_200x200.jpg">