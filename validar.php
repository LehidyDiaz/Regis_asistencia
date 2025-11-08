<?php
include("db.php");
include('configGoog.php');

session_start();  
error_reporting(0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['btningresar'])) {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            echo "<script>
                alert('LOS CAMPOS ESTÁN VACIOS');
                window.location.href = 'goog.php';
              </script>";
        } else {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $encrypted_password = md5($password);

            $stmt = $enlace->prepare("SELECT * FROM login WHERE username = ? AND password = ?");
            if ($stmt === false) {
                die("Error preparando la consulta: " . $enlace->error);
            }
            $stmt->bind_param("ss", $username, $encrypted_password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION["user"] = $username; // Mover esto aquí
                header("Location: registro.php");
                exit(); 
            } else {
                echo "<script>
                alert('ACCESO DENEGADO');
                window.location.href = 'goog.php';
              </script>";
                exit();
            }

            $stmt->close();
        }
    }
}

//index.php

//Include Configuration File

// $login_button = '';


if (isset($_GET["code"])) {

    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);


    if (!isset($token['error'])) {

        $google_client->setAccessToken($token['access_token']);


        $_SESSION['access_token'] = $token['access_token'];


        $google_service = new Google_Service_Oauth2($google_client);


        $data = $google_service->userinfo->get();


        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}
?>