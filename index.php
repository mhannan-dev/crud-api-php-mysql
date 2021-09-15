<?php
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case "GET":
        handleGetRequest();
        break;
    case "POST":
        $data = json_decode(file_get_contents('php://input'), true);
        handlePostRequest($data);
        break;
    case "PUT":
        $data = json_decode(file_get_contents('php://input'), true);
        handlePutRequest($data);
        break;
    case "DELETE":
        $data = json_decode(file_get_contents('php://input'), true);
        handleDeleteRequest($data);
        break;
    default:
        echo "Response not supported";
}
function handleGetRequest()
{
    //Connect db
    include "db_connection.php";
    //Query
    $sql = "SELECT * FROM categories where status = 1";
    $result = mysqli_query($conn, $sql);
    //Connection with query
    if (mysqli_num_rows($result) > 0) {
        $rows = array();
        while ($a = mysqli_fetch_assoc($result)) {
            $rows['result'][] =  $a;
        }
        echo json_encode($rows);
    } else {
        echo '{"result": "No data found"}';
    }
}
function handlePostRequest($data)
{
    //Connect db
    include "db_connection.php";
    $category_name = $data['category_name'];
    $status = $data['status'];
    //Query
    $sql = "INSERT INTO categories (category_name,status) VALUES ('$category_name', '$status')";
    //Connection with query
    if (mysqli_query($conn, $sql)) {
        echo '{"result":"Successfull"}';
    } else {
        echo '{"result": "Failed"}';
    }
}
// Put
function handlePutRequest($data)
{
    //Connect db
    include "db_connection.php";
    $id = $data['id'];
    $category_name = $data['category_name'];
    $status = $data['status'];
    //Query
    $sql = "UPDATE categories SET category_name = '$category_name', status= '$status' WHERE id = '$id'";
    //Connection with query
    if (mysqli_query($conn, $sql)) {
        echo '{"result":"Successfully updated"}';
    } else {
        echo '{"result": "Failed not updated record"}';
    }
}
// Delete
function handleDeleteRequest($data)
{
    //Connect db
    include "db_connection.php";
    $id = $data['id'];
    //Query
    $sql = "DELETE from categories WHERE id = '$id'";
    //Connection with query
    if (mysqli_query($conn, $sql)) {
        echo '{"result":"Successfully deleted"}';
    } else {
        echo '{"result": "Failed not deleted record"}';
    }
}
