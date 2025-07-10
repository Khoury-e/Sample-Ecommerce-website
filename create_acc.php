<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $pass = htmlspecialchars($_POST['pass']);
    $hashed = "";
    $confirm = htmlspecialchars($_POST['confirm']);
    $date = date("Y-m-d h:i");

    if (!preg_match("/^[a-zA-Z-']*$/", $name)) {
        error_log("User attempted to enter name containing unwanted chars");
        echo json_encode(["status" => "error", "message" => "Only english characters are allowed, and whitespaces"]);
        exit();
    }

    else {
        $_SESSION["Name"] = $name;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        error_log("Email is invalid");
        echo '{"status":"Invalid Email Address"}';
        exit();
    }

    else {
        $_SESSION["Email"] = $email;
    }

    if(strlen($pass)<6) {
        error_log("User entered a weak password");
        echo '{"status":"Password should be more than 6 characters-long"}';
        exit();
    }

    else if($pass != $confirm) {
        error_log("Password not confirmed");
        echo '{"status":"Password Not Confirmed"}';
        exit();
    }

    else {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        $_SESSION["HashedPassword"] = $hashed;
    }    

    $host = "127.0.0.1";
    $u = "root";
    $p = "";
    $db = "groomifydb";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $u, $p);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO `users` (Name, Email, Password, CreatedAt) VALUES (:name, :email, :pass, :date)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":pass", $hashed);
        $stmt->bindParam(":date", $date);
        $stmt->execute();

        echo '{"status":"success"}';
        header('Location: signin.html');
        exit();
    } catch (PDOException $e) {
        echo '{"status":"Error"}';
        exit();
    } finally {
        $pdo = null;
    }
}
?>
