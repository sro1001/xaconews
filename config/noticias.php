<?php

return [
    'GOOGLE_NEWS' => [
        'PREFIJO_LLAMADA' => 'https://news.google.com/rss/search?q=',
        'SUFIJO_LLAMADA' => '&hl=es&gl=ES&ceid=ES:es'
    ],
    'RAPID_API' => [
        'URL' => 'https://full-text-rss.p.rapidapi.com/extract.php',
        'HOST' => 'full-text-rss.p.rapidapi.com',
        'KEY' => '00ac508dd0msh485be7ea9e920b7p13cba6jsnf65359f940c6',
        'CONTENT_TYPE' => 'application/x-www-form-urlencoded',
        'MAX_REDIRECTS' => 10,
        'TIMEOUT' => 30,
        'HTTP_VERSION' => 'CURL_HTTP_VERSION_1_1',
        'XSS_PARAMETER' => '0',
        'LANG_PARAMETER' => '2',
        'LINKS_PARAMETER' => 'remove',
        'CONTENT_PARAMETER' => 'text0'
    ],
    'CHATGPT' => [
        'KEY' => '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',
        'QUESTION' => 'Can you delete the Html content in this text?'
    ]
];