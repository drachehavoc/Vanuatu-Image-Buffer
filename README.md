Vanuatu Image Buffer
====================
Criado para resolver o eterno 'problema' de criação de thumbs no desenvolvimento de sites.

Redimenciona imagens e as grava em um buffer, sempre que solicitado a criação de uma imagem já existente no buffer o sistema apenas redireciona para a imagem criada anteriormente evitando processamento desnecessario do servidor.

Facilidades
-----------

* Você não precisa mais se preocupar com a criação de thumbs.
* Sempre que uma imagem não for mais encontrada, retornará uma imagem padrão.

Como Utilizar
-------------
Descompacte o sistema em qualquer pagina no seu servidor, então configure o caminho padrão da sua pasta de imagens no arquivo config.php e verifique também se o .htaccess esta com o RewriteBase correto, após isso você pode acessar:

...

estamos reformulando o sistema de links, por hora não temos mais nenhum .htaccess então
utilize http://seu-dominio/pasta-do-imageBuffer/?img={caminho-da-imagem}.{formato},{método-de-geração},{largura}x{altura},{meta-dados}