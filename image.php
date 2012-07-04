<?php // ♣

	// http://127.0.0.1/acetenis/image/adm/uploads/gallery/1/Desert_-_200_x_200.jpg
		
	$x = @$_GET['x'];
	$y = @$_GET['y'];
	$ext = @$_GET['ext'];
	$file = "../" . @$_GET['file'] . ".$ext";
	
	if( file_exists($file) ){
		$md5_filename = md5_file( $file );
		$fileBuff = "buffer/{$md5_filename}_-_{$x}_x_{$y}.$ext";
	
		if( !file_exists($fileBuff) ){
			require_once 'phpthumb/ThumbLib.inc.php';
			$thumb = PhpThumbFactory::create($file);
			$thumb->adaptiveResize($x, $y);
			$thumb->show();
			$thumb->save($fileBuff);
		}else{
			$thisDir = basename( dirname($_SERVER['SCRIPT_FILENAME']) );
			$uri = $_SERVER['REQUEST_URI'];
			$goTo = preg_replace("/\/.*/", "", strtolower($_SERVER['SERVER_PROTOCOL'])) ."://". $_SERVER['HTTP_HOST'] . substr($uri, 0, strpos($uri, $thisDir)).$thisDir."/$fileBuff";
			header("Location: $goTo");
		}
	}else{
		$x = ( empty($x) )? 150 : $x;
		$y = ( empty($y) )? 150 : $y;
		require_once 'phpthumb/ThumbLib.inc.php';
		$thumb = PhpThumbFactory::create("notFound.jpg");
		$thumb->adaptiveResize($x, $y);
		$thumb->show();
	}