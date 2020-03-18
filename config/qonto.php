<?php

return [
    'api' => [
        'url' 		=>  env('QONTO_URL', 'https://thirdparty.qonto.eu/v2/'),
        'login'		=> env('QONTO_LOGIN', ''),
        'secret' 	=> env('QONTO_SECRET', '')
    ],
];