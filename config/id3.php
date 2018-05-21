<?php

return [

    //File storage location for uploaded files
    'file_storage' => storage_path('files'),

    //ID3 Driver (Registered in IOC)
    'driver' => [
        'binding' => 'ID3Adapter',
        'path' => \App\ID3\ID3Adapter::class,
    ]

];