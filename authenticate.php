<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json");
    $email = htmlspecialchars($_POST['email']);
    $pass = htmlspecialchars($_POST['pass']);

    $host = "127.0.0.1";
    $u = "root";
    $p = "";
    $db = "groomifydb";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $u, $p);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT `Id`, `Email`, `Password` FROM `users` WHERE `Email` = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $hashedPassword = $user['Password'];
            if (password_verify($pass, $hashedPassword)) {
                $_SESSION['user_id'] = $user['Id'];
                $_SESSION['login_status'] = 'success';
                echo '{"status":"ok"}';
                exit();
            } else {
                $_SESSION['login_status'] = 'failed';
                echo '{"status":"error"}';
                exit();
            }
        } else {
            echo '{"status":"NotAUser"}';
            exit();
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
        exit();
    } finally {
        $pdo = null;
    }
}
?>
