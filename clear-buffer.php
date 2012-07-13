<?php // ♣

	# #
	# Copyright 2012 Daniel de Andrade Varela
    # Licensed under the Apache License, Version 2.0 (the “License”);
    # you may not use this file except in compliance with the License.
    # You may obtain a copy of the License at
    # 
    # http://www.apache.org/licenses/LICENSE-2.0
    # 
    # Unless required by applicable law or agreed to in writing, software
    # distributed under the License is distributed on an “AS IS” BASIS,
    # WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    # See the License for the specific language governing permissions and
    # limitations under the License.
	
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