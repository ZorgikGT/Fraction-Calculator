<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class MainControllerTest extends WebTestCase
{
    public function testHealthCheckJson()
    {
        $client = static::createClient();
        $client->request('GET', '/healthcheck',[],[],['CONTENT_TYPE' => 'application/json']);

        self::assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertEquals('application/json',  $client->getResponse()->headers->get("content-type"));
        self::assertJson(json_encode(['status' => 'UP']), $client->getResponse()->getContent());

    }

    public function testHealthCheckText()
    {
        $client = static::createClient();
        $client->request('GET', '/healthcheck',[],[],['CONTENT_TYPE' => 'text/plain']);

        self::assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertEquals('text/plain; charset=UTF-8',  $client->getResponse()->headers->get("content-type"));
        self::assertEquals('status: 	UP', $client->getResponse()->getContent());

    }

    public function testPostCalculate()
    {
        $client = static::createClient();
        $equation = '1/2 + 2/3';

        $client->request('POST', '/calc', [], [], [], json_encode(['equation' => $equation]));

        self::assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertJson(json_encode(['equation' => $equation, 'result' => '7/6']), $client->getResponse()->getContent());
    }
}
