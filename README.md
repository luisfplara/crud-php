

# PHP REST API endpoints 
### Requirements

[PHP 8.2.12 (cli)](https://www.php.net/downloads) 

[Composer 2.6.5](https://getcomposer.org/download/)

[MySQL Server 8.0](https://dev.mysql.com/downloads/mysql/)

### How to use
First, it's need to configurate the php.ini file to use the native mysqli function. Uncomment the following lines
	
 	extension_dir = "ext"
  	extension=mysqli
	
It's need to configure the MySql conenction in the file api/v1/config.php, the standard configuration is:

	$servername = "localhost:3306";
	$username = "root";
	$password = "abcd1234";
	$dbname = "loja";

You can use the file DB.sql in the root directory to create the database.

To install the composer

After clone this repo, you need to execute the following command to install the dependencies:

	composer install
 
To run the API, execute the command bellow, you can use any port that you want.

 	php -S localhost:8080 

To execute the PHPunit tests, you need to execute the command:

	./vendor/bin/phpunit  tests

it will run the tests located in the /test directory, make sure that you selected the addres and port in the following line in the header of the ProductsTest.php function:

	$this->client = new Client(['base_uri' => 'http://localhost:8080']);
---

### Get all products

| Enpoint | Headers                    |
| ------------- | ------------------------------ |
| `GET`  ` /products`  OR `/products?page=XXX&pageSize=XXXX`      | `Content-Type : application/json`    |    	

Get all products or set the variables "page" and "pageSize" in the query to get the response organized in pages, the example bellow have this URI /products?page=30&pageSize=3

#### Request body

```json
{}
```
#### Response
```json
{
	"pagina_atual": "30",
	"total_paginas": 38,
	"total_registros": "112",
	"registros_por_pagina": "3",
	"registros": [
		{
			"id": "88",
			"nome": "Produto 17",
			"descricao": "Descrição do produto 17",
			"preco": "267.18",
			"quantidade": "26"
		},
		{
			"id": "89",
			"nome": "Produto 18",
			"descricao": "Descrição do produto 18",
			"preco": "738.45",
			"quantidade": "73"
		},
		{
			"id": "90",
			"nome": "Produto 19",
			"descricao": "Descrição do produto 19",
			"preco": "890.72",
			"quantidade": "89"
		}
	]
}
```
---

### Get single product

| Enpoint | Headers                    |
| ------------- | ------------------------------ |
| `GET`  `/products/{id}`    | Content-Type : application/json    | 

To get a single product, put the product ID in que query, after the /products/HERE

#### Request body

```json
{}
```
#### Response
```json
{
	"id": "100",
	"nome": "Produto 9",
	"descricao": "Descrição do produto 9",
	"preco": "132.70",
	"quantidade": "13"
}
```
---

### Create new product

| Enpoint | Headers                    | 
| ------------- | ------------------------------ |
| `POST` `/products`      | Content-Type : application/json   |    	

Create a new product 

#### Request body

```json
 {
        "nome": "Produto 2",
        "descricao": "Descrição do produto 2",
        "preco": 20.99,
        "quantidade": 200
 }
```
#### Response
```json
{
	"id": 142
}
```
---

### Update one product

| Enpoint | Headers                    | 
| ------------- | ------------------------------ |
| `PUT` `/products/{id}`      | `Content-Type : application/json`   | 

Used to update one product, the product Id that you want to change needs to be in the URI, send the variables that you want to chenge in the body, if sucess, it will return th Id of the products

#### Request body

```json
{
	"nome":"teste"
	"id" : "1233",
	"nome" : "teste update product",
	"descricao" : "Descrição update test",
        "preco" : "20.99",
        "quantidade" : "200"
}
```
#### Response
```json
{
	"id": "133"
}
```
---

### Delete one user

| Enpoint | Headers                    |
| ------------- | ------------------------------ |
| `Delete` `/products/{id}`| `Content-Type : application/json`|

delete one product sending a request type DELETE with the product ID in the URI /products/HERE

#### Request body

```json
{}
```
#### Response
```json
{
	"id": "133"
}
```
---
