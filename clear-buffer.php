<?php // ♣
	
	$pass = "f06d22b607bc47dad31df5c2bb89d0e3"; // change this - deleteme
	$img_path = "buffer";
	$ext_path = "buffer-external";
	$img = scandir($img_path);
	$ext = scandir($ext_path);
		
	if( isset($_GET['pass']) && md5($_GET['pass'])==$pass ){
		echo "<pre>";
		echo "Deleted: \r\n";
		foreach( $img as $val){
			if( $val !== '.' && $val !== ".." && $val !== ".htaccess" ){
				$del = "$img_path/$val";
				echo "- $del\r\n";
				unlink($del);
			}
		}
		
		foreach( $ext as $val){
			if( $val !== '.' && $val !== ".." && $val !== ".htaccess" ){
				$del = "$ext_path/$val";
				echo "- $del\r\n";
				unlink($del);
			}
		}
		echo "</pre>";
	}else{
		echo "<pre>";
		echo "What is the password?";
		echo "</pre>";
	}