<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => 'vendor/bin/wkhtmltoimage-amd64.bat',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => '"/usr/local/bin/wkhtmltoimage"',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);