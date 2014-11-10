<?php
    //print_r($_GET); die;
// --------------------------------------------------------------------------------------------------    


    // Configurações
    // ---------------------------------------------------------------------------------------------
    
    
        $config = require_once __DIR__ . "/../config.php";
    
    
    // Busca dados da url
    // ---------------------------------------------------------------------------------------------
    
    
        if(
            isset($_GET['file']) &&
            isset($_GET['meta']) &&
            isset($_GET['size']) &&
            isset($_GET['method'])
        ){
            $url = $_GET;
            $url['size'] = explode("x", $url['size']);
        }else{
            $url['file']   = $config['on-error']['image'];
            $url['method'] = $config['on-error']['method'];
            $url['size']   = $config['on-error']['size'];
            $url['meta']   = $config['on-error']['meta'];
        }
    
    
    // Configura imagem original
    // ---------------------------------------------------------------------------------------------
    
    
        if(strpos($url['file'], "http") === 0){
            $image["path"] = $url['file'];
        }else{
            $image["path"] = 
                file_exists($image["path"] = $config['base-dir']."/".$url['file']) 
                    ? $image["path"]
                    : $config['on-error']['image'];
        }
        
    
    // Busca extenção
    // ---------------------------------------------------------------------------------------------
    
    
        $ext = explode(".", $url['file']);
        $ext = strtolower(array_pop($ext));
    
    
    // Gera cabeçalho da imagem
    // ---------------------------------------------------------------------------------------------
    
    
        switch($ext){
            case "png":
                header('Content-type: image/png');
                break;                
                
            case "jpg":
            case "jpeg":
                header('Content-type: image/jpeg');
                break;
        }
    
    
    // Copia a imagem original caso seja configurado
    // ---------------------------------------------------------------------------------------------
    
        
        $originalFile = strtoupper(md5(file_get_contents($image["path"], false, null, null, $config['original']['md5']['size'])));
        if($config['original']['stock']){
            if(file_exists($file = "{$config['original']['folder']}/{$originalFile}.{$ext}")){
                $image["path"] = $file;
            }else{
                if(!is_dir($config['original']['folder']))
                    mkdir($config['original']['folder'], 0777, true);
                $fileBin = file_get_contents($image["path"]);
                file_put_contents($file, $fileBin);
                $imgOriginal = imagecreatefromstring($fileBin);
            }
        }

        
    // Cria o buffer
    // ---------------------------------------------------------------------------------------------
    
    
        $saveFile = $config["buffer"] ."/{$originalFile}_{$url['size'][0]}x{$url['size'][1]}__{$url['method']}__{$url['meta']}.{$ext}";
        if(file_exists($saveFile)){
            fpassthru(fopen($saveFile, 'rb'));
            die;
        }else{
            $dir = dirname($saveFile);
            if(!is_dir($dir))
                mkdir($dir, 0777, true);
        }
        
        
    // Busca dimenções da imagem original
    // ---------------------------------------------------------------------------------------------
    
        
        list($image['largura'], $image['altura']) = getimagesize($image['path']);
    
    
    // Configura nova imagem
    // ---------------------------------------------------------------------------------------------
    
    
        $thumb = [
            "metodo"  => $url['method'],
            "altura"  => $url['size'][0],
            "largura" => $url['size'][1]
        ];
    
    
    // Cria nova imagem
    // ---------------------------------------------------------------------------------------------
    
        if(!isset($imgOriginal))
            switch($ext){
                case 'png': $imgOriginal = imagecreatefrompng($image['path']); break;
                case 'jpg': $imgOriginal = imagecreatefromjpeg($image['path']); break;
            }
    
    
    // Calcula como a nova umagem será gerada conforme o método de criação
    // ---------------------------------------------------------------------------------------------
    
    
        switch($thumb['metodo']){
            case 'stretch':
                $imgThumb = imagecreatetruecolor($thumb['largura'], $thumb['altura']);
                imagecopyresampled($imgThumb, $imgOriginal, 0, 0, 0, 0, $thumb['largura'], $thumb['altura'], $image['largura'], $image['altura']);
                break;
                
            case 'crop':
                $imgThumb = imagecreatetruecolor($thumb['largura'], $thumb['altura']);
                $position = isset($url['meta']) ? explode("x", $url['meta']) : [0, 0];
                $to_crop_array = array(
                    'x'     => $position[0], 
                    'y'     => $position[1], 
                    'width' => $thumb['largura'], 
                    'height'=> $thumb['altura']
                );
                $imgThumb = imagecrop($imgOriginal, $to_crop_array);
                break;
                
            case 'fit':
                if($image['largura'] >= $image['altura']){
                    $index = $image['largura']/$image['altura'];
                    $newLargura = $thumb['largura'];
                    $newAltura  = $thumb['largura']/$index;
                }else{
                    $index = $image['altura']/$image['largura'];
                    $newLargura = $thumb['altura']/$index;
                    $newAltura  = $thumb['altura'];
                }
                $imgThumb = imagecreatetruecolor($thumb['largura'], $thumb['altura']);

                $alturaCenter  = $thumb['altura']/2  - $newAltura/2;
                $larguraCenter = $thumb['largura']/2 - $newLargura/2;
                $bgColor = (isset($url['meta']) && strlen($url['meta'])===6)? $url['meta'] : "000000";
                $r = hexdec($bgColor[0].$bgColor[1]);
                $g = hexdec($bgColor[2].$bgColor[3]);
                $b = hexdec($bgColor[4].$bgColor[5]);
                imagecolorallocate($imgThumb, $r, $g, $b);
                imagecopyresampled($imgThumb, $imgOriginal, $larguraCenter, $alturaCenter, 0, 0, $newLargura, $newAltura, $image['largura'], $image['altura']);
                break;
                
            case 'cover':
                if($image['largura'] <= $image['altura']){
                    $index      = $image['largura']/$image['altura'];
                    $newLargura = $thumb['largura'];
                    $newAltura  = $thumb['largura']/$index;
                }else{
                    $index      = $image['altura']/$image['largura'];
                    $newLargura = $thumb['altura']/$index;
                    $newAltura  = $thumb['altura'];
                }
                
                $imgThumb = imagecreatetruecolor($thumb['largura'], $thumb['altura']);
                $position = 
                    isset($url['meta']) && !empty($url['meta']) 
                        ? explode("_", $url['meta']) 
                        : ['center', 'center'];
                $position[0] = trim(strtolower($position[0]));
                $position[1] = trim(strtolower($position[1]));
                switch($position[0]){
                    case 'left'   : $larguraPos = 0; break;
                    case 'right'  : $larguraPos = $thumb['largura'] - $newLargura; break;
                    case 'center' : 
                    case 'middle' : $larguraPos = $thumb['largura']/2 - $newLargura/2; break;
                    default       :
                        $larguraPos =
                            is_numeric($position[0])
                                ? abs(($thumb['largura']-$newLargura) * $position[0] / 100) * -1
                                : $larguraPos = $thumb['largura']/2 - $newLargura/2;
                        break;
                }
                switch($position[1]){
                    case 'top'    : $alturaPos = 0; break;
                    case 'bottom' : $alturaPos = $thumb['altura'] - $newAltura; break;
                    case 'center' : 
                    case 'middle' : $alturaPos = $thumb['altura']/2 - $newAltura/2; break;
                    default       : 
                        $alturaPos = 
                            is_numeric($position[1])
                                ? abs(($thumb['altura']-$newAltura) * $position[1] / 100) * -1
                                : $alturaPos = $thumb['altura']/2 - $newAltura/2;
                        break;
                }
                imagecopyresampled($imgThumb, $imgOriginal, $larguraPos, $alturaPos, 0, 0, $newLargura, $newAltura, $image['largura'], $image['altura']);
                break;
                
            case 'by-width':
                $index = $image['largura']/$image['altura'];
                $thumb['altura'] = $thumb['largura']/$index;
                $imgThumb = imagecreatetruecolor($thumb['largura'], $thumb['altura']);
                imagecopyresampled($imgThumb, $imgOriginal, 0, 0, 0, 0, $thumb['largura'], $thumb['altura'], $image['largura'], $image['altura']);
                break;
                
            case 'by-height':
                $index = $image['altura']/$image['largura'];
                $thumb['largura'] = $thumb['altura']/$index;
                $imgThumb = imagecreatetruecolor($thumb['largura'], $thumb['altura']);
                imagecopyresampled($imgThumb, $imgOriginal, 0, 0, 0, 0, $thumb['largura'], $thumb['altura'], $image['largura'], $image['altura']);
                break;
        }

        
    // Gera a imagem
    // ---------------------------------------------------------------------------------------------

        switch($ext){
            case "png":
                imagepng($imgThumb);
                imagepng($imgThumb, $saveFile);
                break;
                
            case "jpg":
            case "jpeg":
                imagejpeg($imgThumb, null, 99);
                imagejpeg($imgThumb, $saveFile, 99);
                break;
        }
        
        imagedestroy($imgThumb);