<?php
    $host = "127.0.0.1";
    $username = "root";
    $password = "";
    $db = "groomifydb";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT Name, Price, Image FROM `products`";
        $stmt = $pdo->query($sql);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($data);
    } catch (PDOException $e) {
        echo "Connection failed: ".$e->getMessage();
    } finally {
        $pdo = null;
    }
?>