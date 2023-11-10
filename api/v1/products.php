<?php
//this file implement the SQL queries to g
include_once 'config.php';

//get all products
function getAllProducts($page, $pageSize)
{
    global $conn;

    $start = ($page - 1) * $pageSize;

    //get the products organized in pages or note, depends if the variables $page and $pageSize are setted
    $sql = $pageSize ? "SELECT * FROM produtos LIMIT $start, $pageSize" : "SELECT * FROM produtos";

    $result = $conn->query($sql);

    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $sql = "SELECT COUNT(*) FROM produtos";

    $products_count = $conn->query($sql);


    $products_count = $conn->query($sql);

    $products_count = $products_count->fetch_assoc();

    return $products;
}
//products count to organize the pages
function getAllProductsCount()
{
    global $conn;


    $sql = "SELECT COUNT(*) FROM produtos";

    $products_count = $conn->query($sql);

    return $products_count->fetch_assoc();
}
//get single product using the ID
function getProductById($id)
{
    global $conn;

    $sql = "SELECT * FROM produtos WHERE id = $id";
    $result = $conn->query($sql);

    return $result->fetch_assoc();
}
//create a new product
function createProduct($nome, $descricao, $preco, $quantidade)
{
    global $conn;

    $sql = "INSERT INTO produtos (nome, descricao, preco, quantidade) VALUES ('$nome', '$descricao', $preco, $quantidade)";

    $conn->query($sql);

    return $conn->insert_id;
}
//update one product
function updateProduct($id, array $changes)
{
    global $conn;
    //this part bellow was write to update the variables of the product dynamically, it will update just the variables present in the body.

    $sql = "UPDATE produtos SET ";
    for ($i = 1; $i <= count($changes); $i++) {

        $sql .= key($changes) . " = " . " '" . $changes[key($changes)] . "' ";
        if ($i != count($changes)) {
            $sql .= ' , ';
        }
        next($changes);
    }
    $sql .= " WHERE id = $id";


    $conn->query($sql);

    return $id;
}
//delete one product
function deleteProduct($id)
{
    global $conn;

    $sql = "DELETE FROM produtos WHERE id = $id";
    $conn->query($sql);

    return $id;
}
?>