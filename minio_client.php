<?php

require "vendor/autoload.php";

use Aws\S3\S3Client;

function getClient()
{
    return new S3Client([
        'version'     => 'latest',
        'region'      => 'us-east-1',
        'endpoint'    => 'http://localhost:9000',
        'use_path_style_endpoint' => true,
        'credentials' => [
            'key'    => 'john',
            'secret' => 'johngithiyon',
        ],
    ]);
}
