<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");


$host = 'localhost';
$dbname = 'crm';
$user = 'root';
$password = '';

try {
 
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $request = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
    
    #GET 
    if ($method === 'GET') {
        if (preg_match('/\/firms\/(\d+)/', $request, $matches)) {
            $id = intval($matches[1]);
            getFirmById($pdo, $id);
        } elseif (preg_match('/\/firms/', $request)) {
            getAllFirms($pdo);
        } else {
            sendResponse(404, ["error" => "Invalid endpoint"]);
        }

/*
active TINYINT
name VARCHAR(500)|
surname VARCHAR(500)|
email VARCHAR(500)
phone varchar(14)
subject_id INT
source VARCHAR(500)|
date_of_contract DATE
date_of_2_contract DATE
date_of_meeting DATE
result VARCHAR(500)
workshop VARCHAR(500)
brigade VARCHAR(500)
practice VARCHAR(500)
cv TINYINT
note VARCHAR (500)
c14 VARCHAR(500)
c15 VARCHAR(500)
c16 VARCHAR(500)
c17 VARCHAR(500)
c18 VARCHAR(500)
c19 VARCHAR(500)
c20 VARCHAR(500)
c22 VARCHAR(500)
c23 VARCHAR(500)
c24 VARCHAR(500)
c25 VARCHAR(500)
c31 VARCHAR(500)
c32 VARCHAR(500)
c33 VARCHAR(500)
*/


    } elseif ($method === 'POST') {
        if(preg_match('/\/firms/', $request)) { // <-- TODO: add /firms/save or whatever (regex)
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO firms (active, name, surname, email, phone, subject_id, source, date_of_contract, date_of_2_contract, date_of_meeting, result, workshop, brigade, practice, cv, note, c14, c15, c16, c17, c18, c19, c20, c22, c23, c24, c25, c31, c32, c33) VALUES (:active, :name, :surname, :email, :phone, :subject_id, :source, :date_of_contract, :date_of_2_contract, :date_of_meeting, :result, :workshop, :brigade, :practice, :cv, :note, :c14, :c15, :c16, :c17, :c18, :c19, :c20, :c22, :c23, :c24, :c25, :c31, :c32, :c33)");
            $stmt->execute($data);
            sendResponse(201, ["id" => $pdo->lastInsertId()]);
        } else {
            sendResponse(404, ["error" => "Invalid endpoint"]);
        }
    } 
    
    
    
    else { 
        sendResponse(405, ["error" => "Method not allowed"]);
    }












header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, DELETE, PATCH");
header("Access-Control-Allow-Headers: Content-Type");


$host = 'localhost';
$dbname = 'your_database_name';
$user = 'your_username';
$password = 'your_password';



    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $request = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'PATCH') {
        if (preg_match('/\/firms\/update\/(\d+)/', $request, $matches)) {
            $id = intval($matches[1]);
            $data = json_decode(file_get_contents('php://input'), true);
            updateFirmById($pdo, $id, $data);
        } else {
            sendResponse(404, ["error" => "Invalid endpoint"]);
        }
    } elseif ($method === 'GET') {
        if (preg_match('/\/firms\/list/', $request)) {
            getAllFirms($pdo);
        } elseif (preg_match('/\/firms\/(\d+)/', $request, $matches)) {
            $id = intval($matches[1]);
            getFirmById($pdo, $id);
        } else {
            sendResponse(404, ["error" => "Invalid endpoint"]);
        }
    } elseif ($method === 'DELETE') {
        if (preg_match('/\/firms\/remove\/(\d+)/', $request, $matches)) {
            $id = intval($matches[1]);
            deleteFirmById($pdo, $id);
        } else {
            sendResponse(404, ["error" => "Invalid endpoint"]);
        }
    } else {
        sendResponse(405, ["error" => "Method not allowed"]);
    }


function updateFirmById($pdo, $id, $data) {
    if (empty($data)) {
        sendResponse(400, ["error" => "No data provided for update"]);
    }

   
    $fields = [];
    $params = [];
    foreach ($data as $key => $value) {
        $fields[] = "$key = :$key";
        $params[$key] = $value;
    }

    $sql = "UPDATE firms SET " . implode(", ", $fields) . " WHERE id = :id";
    $params['id'] = $id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    if ($stmt->rowCount() > 0) {
        sendResponse(200, ["message" => "Firm with ID $id has been updated"]);
    } else {
        sendResponse(404, ["error" => "Firm not found or no changes made"]);
    }
}


function getAllFirms($pdo) {
    $stmt = $pdo->query("SELECT * FROM firms");
    $firms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    sendResponse(200, $firms);
}


function getFirmById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM firms WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $firm = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($firm) {
        sendResponse(200, $firm);
    } else {
        sendResponse(404, ["error" => "Firm not found"]);
    }
}

function deleteFirmById($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM firms WHERE id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() > 0) {
        sendResponse(200, ["message" => "Firm with ID $id has been deleted"]);
    } else {
        sendResponse(404, ["error" => "Firm not found"]);
    }
}



function getAllFirms($pdo) {
    $stmt = $pdo->query("SELECT * FROM firms");
    $firms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    sendResponse(200, $firms);
}


function getFirmById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM firms WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $firm = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($firm) {
        sendResponse(200, $firm);
    } else {
        sendResponse(404, ["error" => "Firm not found"]);
    }
}
} catch (PDOException $e) {
    sendResponse(500, ["error" => "Database connection failed: " . $e->getMessage()]);
}
function sendResponse($status, $data) {
    http_response_code($status);
    echo json_encode($data);
    exit();
}

function sendResponse($status, $data) {
    http_response_code($status);
    echo json_encode($data);
    exit();
}
