<?php // ♣
	
	// 127.0.0.1/projetos/vanuatu/Vanuatu-Image-Buffer/ext/200x200/http://fc02.deviantart.net/fs71/f/2010/056/e/9/Japanese_Girl_by_Dreamsofnight.jpg
	
	require_once 'config.php';
	
	$x   = ( isset($_GET['x']   ) ) ? $_GET['x']   : $options['size']['width']  ;
	$y   = ( isset($_GET['y']   ) ) ? $_GET['y']   : $options['size']['height'] ;
	$ext = ( isset($_GET['ext'] ) ) ? $_GET['ext'] : ""                         ;
	$url = ( isset($_GET['url'] ) ) ? $_GET['url'] : ""                         ;
	
	echo $url;