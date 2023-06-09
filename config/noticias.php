<?php

/**
 * Created by Sergio Ruiz Orodea.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Configuración para la llamada de Google News
    |--------------------------------------------------------------------------
    |
    | Configuración del prefijo y sufijo de la llamada que hacemos para obtener las noticias
    |
    */
    'GOOGLE_NEWS' => [
        'PREFIJO_LLAMADA' => 'https://news.google.com/rss/search?q=',
        'SUFIJO_LLAMADA' => '&hl=es&gl=ES&ceid=ES:es'
    ],


    /*
    |--------------------------------------------------------------------------
    | Configuración para la llamada a la API de Full-Text RSS a través de RapidAPI
    |--------------------------------------------------------------------------
    |
    | Configuración de los parámetros para la llamada a RapidAPI para obtener el texto
    | de las noticias
    |
    */
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


    /*
    |--------------------------------------------------------------------------
    | Configuración para la llamada a la API de ChatGPT(OpenAI API)
    |--------------------------------------------------------------------------
    |
    | Configuración de los parámetros de configuración para la llamada
    |
    */
    'CHATGPT' => [
        'QUESTION' => '¿Me puedes devolver en un array la puntuacion de los sentimientos Alegría, Tristeza, Confianza, Miedo, Orgullo, Enfado, Satisfacción, Asco, Amor, Culpa en el siguiente texto?',
        'QUESTION_POSITIVIDAD' => '¿De 0 a 10 cuan positivo es este texto en un número entero?',
        'MODEL' => 'text-davinci-003',
        'TEMPERATURE' => 1,
        'MAX_TOKENS' => 250,
        'TOP_P' => 1,
        'FREQUENCY_PENALTY' => 0,
        'PRESENCE_PENALTY' => 0,
    ]
];