Vanuatu Image Buffer
====================
Criado para resolver o eterno 'problema' de criação de thumbs no 
desenvolvimento de sites.

Redimenciona imagens e as grava em um buffer, sempre que solicitado a criação
de uma imagem já existente no buffer o sistema apenas redireciona para a imagem
criada anteriormente evitando processamento desnecessario do servidor.

Facilidades
-----------
* Você não precisa mais se preocupar com a criação de thumbs.
* Sempre que uma imagem não for mais encontrada, retornará uma imagem padrão.

Como Utilizar
-------------
Descompacte o sistema em qualquer pagina no seu servidor, então configure o 
caminho padrão da sua pasta de imagens no arquivo config.php e verifique também
se o .htaccess esta com o RewriteBase correto, após isso você pode acessar:
* `http://seu-host/pasta-do-sistema/200x200/caminho/da/imagem.formato`, para arquivos locais.
* `http://seu-host/pasta-do-sistema/caminho/da/imagem_-_200x200.formato`, para arquivos locais.
* `http://seu-host/pasta-do-sistema/ext/200x200/http://url/da/imagem.formato`, para arquivos extenos.
* `http://seu-host/pasta-do-sistema/ext/http://url/da/imagem_-_200x200.formato`, para arquivos externos.

Como inserir imagens no HTML:
* `<img src="pasta-do-sistema/200x200/caminho/da/imagem.formato">`, para arquivos locais.
* `<img src="pasta-do-sistema/caminho/da/imagem_-_200x200.formato">`, para arquivos locais.
* `<img src="pasta-do-sistema/ext/200x200/http://url/da/imagem.formato">`, para arquivos extenos.
* `<img src="pasta-do-sistema/ext/http://url/da/imagem_-_200x200.formato">`, para arquivos externos.