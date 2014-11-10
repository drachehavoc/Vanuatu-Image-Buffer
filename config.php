<?php

    return [
        //"base-dir" => __DIR__ . "/examples/",
        "base-dir" => ".",
        "buffer"   => __DIR__ . "/cache/",
        
        "original" => [
            "stock"  => true,
            "folder" => __DIR__ . "/cache/original-file/",
            "md5"    => [
                "size" => 600 * 1024 
            ]
        ],
    
        "on-error" => [
            "image"  => "errors/not-found.png",
            "method" => "cover",
            "meta"   => "center_center",
            "size"   => [410, 410]
        ],
        
        "jpeg" => [
            "quality" => 99
        ]
    ];