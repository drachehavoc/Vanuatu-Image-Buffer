Vanuatu Image Buffer
====================
Criado para resolver o eterno 'problema' de cria��o de thumbs no 
desenvolvimento de sites.

Redimenciona imagens e as grava em um buffer, sempre que solicitado a cria��o
de uma imagem j� existente no buffer o sistema apenas redireciona para a imagem
criada anteriormente evitando processamento desnecessario do servidor.

Facilidades
-----------
* Voc� n�o precisa mais se preocupar com a cria��o de thumbs.
* Sempre que uma imagem n�o for mais encontrada, retornar� uma imagem padr�o.

Como Utilizar
-------------
Descompacte o sistema em qualquer pagina no seu servidor, ent�o configure o 
caminho padr�o da sua pasta de imagens no arquivo config.php e verifique tamb�m
se o .htaccess esta com o RewriteBase correto, ap�s isso voc� pode acessar:
* `http://seu-host/pasta-do-sistema/200x200/caminho/da/imagem.formato`.
* `http://seu-host/pasta-do-sistema/caminho/da/imagem_-_200x200.formato`.
* `http://seu-host/pasta-do-sistema/ext/200x200/url/da/imagem.formato`.
* `http://seu-host/pasta-do-sistema/ext/url/da/imagem_-_200x200.formato`.

exemplo: 
```
	<img src="PASTA_DO_SISTEMA/200x200/caminho/da/sua/imagem.jpg"> ou
	<img src="PASTA_DO_SISTEMA/caminho/da/sua/imagem_-_200x200.jpg">
```