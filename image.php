<?php // ♣
	
	require_once 'config.php';
	
	$x     = ( isset($_GET['x']   ) ) ? $_GET['x']    : $options['size']['width']  ;
	$y     = ( isset($_GET['y']   ) ) ? $_GET['y']    : $options['size']['height'] ;
	$ext   = ( isset($_GET['ext'] ) ) ? $_GET['ext']  : ""                         ;
	$fName = ( isset($_GET['file']) ) ? $_GET['file'] : ""                         ;
	
	$file = utf8_decode( "{$options['basedir']}/$fName.$ext" );

	// Caso o arquivo exista no caminho especificado
	if( !empty($fName) && !empty($ext) && file_exists($file) ){
		// Gera Hash MD5 do arquivo especificado
		$md5_filename = md5_file( $file );
		
		// Monta path da imagem buffer
		$fileBuff = "buffer/{$md5_filename}_-_{$x}_x_{$y}.$ext";
			
		// Se não existe um arquivo já gerado para a 
		// imagem e tamanho solicitado cria um e retorna
		if( !file_exists($fileBuff) ){
			require_once 'phpthumb/ThumbLib.inc.php';
			$thumb = PhpThumbFactory::create($file);
			$thumb->adaptiveResize($x, $y);
			$thumb->show();
			$thumb->save($fileBuff);
		}
		
		// Se existe um arquivo já criado para a 
		// imagem e tamanho solicitado, redireciona para ele
		else{
			$thisDir = basename( dirname($_SERVER['SCRIPT_FILENAME']) );
			$uri = $_SERVER['REQUEST_URI'];
			$goTo = preg_replace("/\/.*/", "", strtolower($_SERVER['SERVER_PROTOCOL'])) ."://". $_SERVER['HTTP_HOST'] . substr($uri, 0, strpos($uri, $thisDir)).$thisDir."/$fileBuff";
			header("Location: $goTo");
		}
	}
	
	// Caso o arquivo não exista no caminho especificado
	else{
		require_once 'phpthumb/ThumbLib.inc.php';
		$thumb = PhpThumbFactory::create($options['notfound']['path']);
		$thumb->adaptiveResize($x, $y);
		$thumb->show();
	}