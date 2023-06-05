<?php

return [
    'GOOGLE_NEWS' => [
        'PREFIJO_LLAMADA' => 'https://news.google.com/rss/search?q=',
        'SUFIJO_LLAMADA' => '&hl=es&gl=ES&ceid=ES:es'
    ],
    'RAPID_API' => [
        'URL' => 'https://full-text-rss.p.rapidapi.com/extract.php',
        'HOST' => 'full-text-rss.p.rapidapi.com',
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
        'QUESTION' => '¿Me puedes dar en un array, el nombre de los sentimientos que se perciben en este texto, junto con una puntuación, y una variable si es un sentimiento negativo o positivo?'
    ]
];