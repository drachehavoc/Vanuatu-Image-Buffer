<?php
    // crop
    #$strUrl = "tia.png,crop,150x200";
    #$strUrl = "tia.png,crop,150x200,0x0";
    #$strUrl = "tia.png,crop,150x200,10x10";
    
    // stretch
    #$strUrl = "tia.png,stretch,150x200";
    
    // by-width or by-height
    #$strUrl = "tia.png,by-width,250x200";
    #$strUrl = "tia.png,by-height,250x200";
    
    // fit
    #$strUrl = "tia.png,fit,250x200,00FF00";
    #$strUrl = "tia.png,fit,150x200,FF0000";
    
    // cover
    #$strUrl = "tia.png,cover,400x400";
    #$strUrl = "tia.png,cover,400x800,center_top";
    #$strUrl = "tia.png,cover,400x800,center_center";
    #$strUrl = "tia.png,cover,400x800,center_bottom";
    #$strUrl = "tia.png,cover,800x400,left_center";
    #$strUrl = "tia.png,cover,800x400,center_center";
    #$strUrl = "tia.png,cover,800x400,right_center";
    # Cover with percentage
    #$strUrl = "tia.png,cover,800x400,10_center";
    #$strUrl = "tia.png,cover,800x400,20_center";
    #$strUrl = "tia.png,cover,800x400,30_center";
    #$strUrl = "tia.png,cover,800x400,40_center";
    #$strUrl = "tia.png,cover,800x400,50_center";
    #$strUrl = "tia.png,cover,800x400,60_center";
    #$strUrl = "tia.png,cover,800x400,70_center";
    #$strUrl = "tia.png,cover,800x400,80_center";
    #$strUrl = "tia.png,cover,800x400,90_center";
    #$strUrl = "tia.png,cover,800x400,100_center";
    #$strUrl = "tia.png,cover,400x800,center_10";
    #$strUrl = "tia.png,cover,400x800,center_20";
    #$strUrl = "tia.png,cover,400x800,center_30";
    #$strUrl = "tia.png,cover,400x800,center_40";
    #$strUrl = "tia.png,cover,400x800,center_50";
    #$strUrl = "tia.png,cover,400x800,center_60";
    #$strUrl = "tia.png,cover,400x800,center_70";
    #$strUrl = "tia.png,cover,400x800,center_80";
    #$strUrl = "tia.png,cover,400x800,center_90";
    #$strUrl = "tia.png,cover,400x800,center_100";
    
// --------------------------------------------------------------------------------------------------    

    
    // URL
    // ---------------------------------------------------------------------------------------------

    
        $strUrl = 
            isset($_GET['img'])
                ? $_GET['img'] 
                : null;
    

    // Configurações
    // ---------------------------------------------------------------------------------------------
    
    
        $config = [
            "on-error" => [
                "image" => "errors/not-found.png",
                "type"  => "cover",
                "size"  => [410, 410]
            ],
            "jpeg" => [
                "quality" => 99
            ]
        ];
    
    
    // Busca dados da url
    // ---------------------------------------------------------------------------------------------
    
    
        if(isset($strUrl)){
            $url    = explode(",", $strUrl);
            $url[2] = explode("x", $url[2]);
        }else{
            $url[0] = $config['on-error']['image'];
            $url[1] = $config['on-error']['type'];
            $url[2] = $config['on-error']['size'];
        }
            
    
    // Configura imagem original
    // ---------------------------------------------------------------------------------------------
    
    
        $image["path"] = 
            file_exists($url[0]) 
                ? $url[0] 
                : $config['on-error']['image'];
        
        list($image['largura'], $image['altura']) = getimagesize($image['path']);
    
    
    // Configura nova imagem
    // ---------------------------------------------------------------------------------------------
    
    
        $thumb = [
            "type"    => $url[1],
            "altura"  => $url[2][0],
            "largura" => $url[2][1]
        ];
    
    
    // Cria nova imagem
    // ---------------------------------------------------------------------------------------------
    
    
        $ext = explode(".", $url[0]);
        $ext = strtolower(array_pop($ext));
    
    
    // Cria nova imagem
    // ---------------------------------------------------------------------------------------------
    
    
        switch($ext){
            case 'png': $imgOriginal = imagecreatefrompng($image['path']); break;
            case 'jpg': $imgOriginal = imagecreatefromjpeg($image['path']); break;
        }
    
    
    // Calcula como a nova umagem será gerada conforme o método de criação
    // ---------------------------------------------------------------------------------------------
    
    
        switch($thumb['type']){
            case 'stretch':
                $imgThumb = imagecreatetruecolor($thumb['largura'], $thumb['altura']);
                imagecopyresampled($imgThumb, $imgOriginal, 0, 0, 0, 0, $thumb['largura'], $thumb['altura'], $image['largura'], $image['altura']);
                break;
                
            case 'crop':
                $imgThumb = imagecreatetruecolor($thumb['largura'], $thumb['altura']);
                $position = isset($url[3]) ? explode("x", $url[3]) : [0, 0];
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
                $bgColor = (isset($url[3]) && strlen($url[3])===6)? $url[3] : "000000";
                $r = hexdec($bgColor[0].$bgColor[1]);
                $g = hexdec($bgColor[2].$bgColor[3]);
                $b = hexdec($bgColor[4].$bgColor[5]);
                imagecolorallocate($imgThumb, $r, $g, $b);
                imagecopyresampled($imgThumb, $imgOriginal, $larguraCenter, $alturaCenter, 0, 0, $newLargura, $newAltura, $image['largura'], $image['altura']);
                break;
                
            case 'cover':
                if($thumb['largura'] >= $thumb['altura']){
                    $index      = $image['largura']/$image['altura'];
                    $newLargura = $thumb['largura'];
                    $newAltura  = $thumb['largura']/$index;
                }else{
                    $index      = $image['altura']/$image['largura'];
                    $newLargura = $thumb['altura']/$index;
                    $newAltura  = $thumb['altura'];
                }
                
                $imgThumb = imagecreatetruecolor($thumb['largura'], $thumb['altura']);
                $position = isset($url[3]) ? explode("_", $url[3]) : ['center', 'center'];
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
                header('Content-type: image/png');
                imagepng($imgThumb);
                imagedestroy($imgThumb);
                break;
                
            case "jpg":
                header('Content-type: image/jpeg');
                imagejpeg($imgThumb, null, 99);
                imagedestroy($imgThumb);
                break;
        }