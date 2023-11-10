<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ProductsTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = new Client(['base_uri' => 'http://localhost:8080']);
    }

    public function testGetAllProducts()
    {
        $response = $this->client->request('GET', '/products');
        $data = json_decode($response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('pagina_atual', $data);
        $this->assertArrayHasKey('total_paginas', $data);
        $this->assertArrayHasKey('total_registros', $data);
        $this->assertArrayHasKey('registros_por_pagina', $data);
        $this->assertArrayHasKey('registros', $data);
    }

    public function testGetProductById()
    {
        $response = $this->client->request('GET', '/products/1');
        $data = json_decode($response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('nome', $data);
        $this->assertArrayHasKey('descricao', $data);
        $this->assertArrayHasKey('preco', $data);
        $this->assertArrayHasKey('quantidade', $data);
    }
    public function testCreateProduct()
    {
        $response = $this->client->request(
            'POST',
            '/products',

            [
                GuzzleHttp\RequestOptions::JSON => [
                    'id' => 1233,
                    'nome' => 'teste product',
                    "descricao" => "Descrição test",
                    "preco" => 20.99,
                    "quantidade" => 200

                ]
            ]
        );
        $data = json_decode($response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('id', $data);

    }
    public function testUpdateProductById()
    {
        $response = $this->client->request('PUT', '/products/134', [
            GuzzleHttp\RequestOptions::JSON => [
                'id' => 1233,
                'nome' => 'teste update product',
                "descricao" => "Descrição update test",
                "preco" => 20.99,
                "quantidade" => 200

            ]
        ]);
        $data = json_decode($response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('id', $data);

    }
    public function testDeleteProductById()
    {
        $response = $this->client->request('DELETE', '/products/134');
        $data = json_decode($response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('id', $data);

    }

}
