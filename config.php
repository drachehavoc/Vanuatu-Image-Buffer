<?php

    return [
        "base-dir" => __DIR__ . "/examples/",
        "buffer"   => __DIR__ . "/cache/",
    
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