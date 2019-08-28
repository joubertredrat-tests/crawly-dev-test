<?php

declare(strict_types = 1);

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Based on javascript findAnswer() function into /adpagespeed.js
 *
 * @param string $token
 * @return string
 */
function findAnswer(string $token): string {
    $replacements = [
        'a' => 'z',
        'b' => 'y',
        'c' => 'x',
        'd' => 'w',
        'e' => 'v',
        'f' => 'u',
        'g' => 't',
        'h' => 's',
        'i' => 'r',
        'j' => 'q',
        'k' => 'p',
        'l' => 'o',
        'm' => 'n',
        'n' => 'm',
        'o' => 'l',
        'p' => 'k',
        'q' => 'j',
        'r' => 'i',
        's' => 'h',
        't' => 'g',
        'u' => 'f',
        'v' => 'e',
        'w' => 'd',
        'x' => 'c',
        'y' => 'b',
        'z' => 'a',
    ];

    for ($t = 0; $t < strlen($token); $t++) {
        $token[$t] = array_key_exists($token[$t], $replacements) ? $replacements[$token[$t]] : $token[$t];
    }

    return $token;
}

/**
 * @param ResponseInterface $response
 * @return string
 * @throws ClientExceptionInterface
 * @throws RedirectionExceptionInterface
 * @throws ServerExceptionInterface
 * @throws TransportExceptionInterface
 */
function getCookie(ResponseInterface $response): string {
    return $response->getHeaders()['set-cookie'][0];
}

/**
 * @param ResponseInterface $response
 * @return string
 * @throws ClientExceptionInterface
 * @throws RedirectionExceptionInterface
 * @throws ServerExceptionInterface
 * @throws TransportExceptionInterface
 */
function getTokenForm(ResponseInterface $response): string {
    $crawler = new Crawler($response->getContent());

    return $crawler
        ->filter("#token")
        ->getNode(0)
        ->attributes
        ->getNamedItem('value')
        ->nodeValue
    ;
}
