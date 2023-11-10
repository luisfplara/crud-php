<?php

include_once 'config.php';

function getAllProducts($page, $pageSize)
{
    global $conn;

    $start = ($page - 1) * $pageSize;

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
    echo ($products_count[0]);


    return $products;
}
function getAllProductsCount()
{
    global $conn;


    $sql = "SELECT COUNT(*) FROM produtos";

    $products_count = $conn->query($sql);

    return $products_count->fetch_assoc();
}
function getProductById($id)
{
    global $conn;

    $sql = "SELECT * FROM produtos WHERE id = $id";
    $result = $conn->query($sql);

    return $result->fetch_assoc();
}
function createProduct($nome, $descricao, $preco, $quantidade)
{
    global $conn;

    $sql = "INSERT INTO produtos (nome, descricao, preco, quantidade) VALUES ('$nome', '$descricao', $preco, $quantidade)";

    $conn->query($sql);

    return $conn->insert_id;
}
function updateProduct($id, array $changes)
{
    global $conn;

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
function deleteProduct($id)
{
    global $conn;

    $sql = "DELETE FROM produtos WHERE id = $id";
    $conn->query($sql);

    return $id;
}
?>