<?php

declare(strict_types = 1);

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/functions.php');

use Symfony\Component\HttpClient\HttpClient;

$url = 'http://applicant-test.us-east-1.elasticbeanstalk.com/';

try {
    $client = HttpClient::create();
    $response = $client->request('GET', $url);
    $cookie = getCookie($response);
    $tokenValue = getTokenForm($response);
    $tokenConvertedValue = findAnswer($tokenValue);

    $response = $client->request('POST', $url, [
        'headers' => [
            'Referer' => $url,
            'Cookie' => $cookie,
        ],
        'body' => [
            'token' => $tokenConvertedValue,
        ],
    ]);

    echo $response->getContent();
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(-1);
}
