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

* O link gerado para a vizualização de imagens devera ser algo assim, [http://seu-dominio/pasta-do-imageBuffer/?img={caminho-da-imagem}.{formato},{método-de-geração},{largura}x{altura},{meta-dados}](#), onde:
    * {caminho-da-imagem}
        * caminho da imagem considerando BASE-DIR configurado no arquivo _config.php_
    * {formato}
        * png
        * jpg
    * {método-de-geração}
        * stretch
        * crop
        * fit
        * cover
        * by-width
        * by-height
    * {largura}
        * largura da imagem a ser gerada
    * {altura}
        * altura da imagem a ser gerada
    * {meta-dados}
        * em casos método-de-geração específicos é preciso passar parametros a mais como altura e largura, estes valores são passados utilizando este parametro

Bugs
----
* Utilizando o método COVER de geração, em alguns momentos a imagem gera bordas pretas
