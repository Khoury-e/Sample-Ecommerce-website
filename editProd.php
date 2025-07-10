<?php
$host = "127.0.0.1";
$u = "root";
$p = "";
$db = "groomifydb";
$date = date("Y-m-d h:i");

if($_SERVER['REQUEST_METHOD']=='POST') {

    if(isset($_POST['productId'])) {
        $id = $_POST['productId'];
    }

    if(isset($_POST['productName'])) {
        $name = htmlspecialchars($_POST['productName']);
    }

    if(isset($_POST['productPrice'])) {
        $price = htmlspecialchars($_POST['productPrice']);
    }

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $u, $p);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE `products` SET  `Name`=(:name), `Price`=(:price), `UpdatedAt`=(:date) WHERE `Id`=(:id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":date", $date);
        $stmt->execute();

        echo '{"status":"success"}';
        header('Location: admin.php');
        exit();
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    } finally{
        $pdo = null;
    }
    
}

?>