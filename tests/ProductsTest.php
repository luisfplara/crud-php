<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

/*this file is used to test all end points, the test will get all products firs
 * then, it will create a products, update it, read it and then delete this product automatically 
 */


class ProductsTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = new Client(['base_uri' => 'http://localhost:8080']);

    }

    //get all products - teste GET /products 
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

    //create product - teste Post /products 

    public function testCreateProduct()
    {


        $response = $this->client->request(
            'POST',
            '/products',

            [
                GuzzleHttp\RequestOptions::JSON => [
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
        return $data['id'];
    }


    //teste PUT /products - update one product, this test depends of testCreateProduct(), it's not recommended but it's ok for this purpose. 

    /**
     * @depends testCreateProduct
     */
    public function testUpdateProductById($id_test)
    {
        $response = $this->client->request('PUT', '/products/' . $id_test, [
            GuzzleHttp\RequestOptions::JSON => [
                'id' => 101010,
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

    //teste GET /products/1
    public function testGetProductById()
    {
        $response = $this->client->request('GET', '/products/101010');
        $data = json_decode($response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('nome', $data);
        $this->assertArrayHasKey('descricao', $data);
        $this->assertArrayHasKey('preco', $data);
        $this->assertArrayHasKey('quantidade', $data);
    }
    //teste DELETE /products/{id} - delete one product
    public function testDeleteProductById()
    {
        $response = $this->client->request('DELETE', '/products/101010');
        $data = json_decode($response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('id', $data);

    }

}
