<?php
// include("db.php");
include("configGoog.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>INICIO SE SESIÓN</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
</head>

<body class="bg-secondary d-flex justify-content-center align-items-center vh-100">
  <?php
  // require_once 'vendor/autoload.php';

  // // init configuration
  // $clientID = '515550444834-gu5ceqrfge8tkhkg8ubei01aeesosv8o.apps.googleusercontent.com';
  // $clientSecret = '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';
  // $redirectUri = 'http://localhost/EMPLEADO/index.php';

  // // create Client Request to access Google API
  // $client = new Google_Client();
  // $client->setClientId($clientID); 
  // $client->setClientSecret($clientSecret);
  // $client->setRedirectUri($redirectUri);
  // $client->addScope("email");
  // $client->addScope("profile");

  // // authenticate code from Google OAuth Flow
  // // if (isset($_GET['code'])) {
  // //   $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  // //   $client->setAccessToken($token['access_token']);

  // //   // get profile info
  // //   $google_oauth = new Google_Service_OAuth2($client);
  // //   $google_account_info = $google_oauth->userinfo->get();
  // //   $email =  $google_account_info->email;
  // //   $name =  $google_account_info->name;

  // //   // now you can use this profile info to create account in your website and make user logged in.
  // // } 

  ?>
  <form action="validar.php" method="post">
    <div class="bg-white p-5 rounded-5 text-secondary shadow" style="width: 25rem">
      <div class="d-flex justify-content-center">
        <img src="assets/login-icon.svg" alt="login-icon" style="height: 5rem" />
      </div>
      <div class="text-center fs-1 fw-bold">Inicio de sesión</div>
      
      <div class="input-group mt-4">
        <div class="input-group-text bg-secondary">
          <img src="assets/username-icon.svg" alt="username-icon" style="height: 1rem" />
        </div>
        <input class="form-control bg-light" type="text" placeholder="Usuario" name="username" />
      </div>
      <div class="input-group mt-1">
        <div class="input-group-text bg-secondary">
          <img src="assets/password-icon.svg" alt="password-icon" style="height: 1rem" />
        </div>
        <input class="form-control bg-light" type="password" placeholder="Contraseña" name="password" />
      </div>
      <div class="">
        <input name="btningresar" class="btn btn-secondary text-white w-100 mt-4 fw-semibold shadow-sm" type="submit" value="INGRESAR">
        <!-- <a href="index.php">
        </a> -->
      </div>
      <div class="p-3">
        <div class="border-bottom text-center" style="height: 0.9rem">
          <span class="bg-white px-3">o</span>
        </div>
      </div>
      <div class="btn d-flex gap-2 justify-content-center border mt-3 shadow-sm">
        <img src="assets/google-icon.svg" alt="google-icon" style="height: 1.6rem" />
        <div class="fw-semibold text-secondary"><a href="<?php echo $google_client->createAuthUrl()?>">Iniciar con Google</div>
      </div>
    </div>
  </form>
</body>

</html>