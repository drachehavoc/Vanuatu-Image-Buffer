<?php // ♣

	$img = scandir("./buffer");
	$buf = scandir("./buffer-external");
	
	
	foreach( $img as $val => $val){
		if( $val !== '.' && $val !== ".." && $val !== ".htaccess" )
		unlink("buffer/$val");
	}
	
	foreach( $buf as $val => $val){
		if( $val !== '.' && $val !== ".." && $val !== ".htaccess" )
		unlink("buffer-external/$val");
	}
	