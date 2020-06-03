<?php
require "db/configuration.php";
require "fnc_news.php";
require "fnc_users.php";

require "classes/Session.class.php";

SessionManager::sessionStart("vr20", 0, "/~reino.ristissaar/", "tigu.hk.tlu.ee");

$pageName = "Reino";
$pageTitle = " Veebirakendused ja nende loomine ";
$pageYear = date("Y");
$fullpageTitle = $pageName . $pageTitle . $pageYear;

$notice        = null;
$email         = null;
$emailError    = null;
$passwordError = null;

if (isset($_POST["login"])) {
  if (isset($_POST["email"]) and !empty($_POST["email"])) {
    $email = test_input($_POST["email"]);
  } else {
    $emailError = "Palun sisesta kasutajatunnusena e-posti aadress!";
  }

  if (!isset($_POST["password"]) or strlen($_POST["password"]) < 8) {
    $passwordError = 'Palun sisesta parool, vähemalt 8 märki!';
  }

  if (empty($emailError) and empty($passwordError)) {
    $notice = signIn($email, $_POST["password"]);
  } else {
    $notice = "Ei saa sisse logida!";
  }
}
?>
<!DOCTYPE html>
<html lang="et">

<head>
  <meta charset="utf-8">
  <title>Veebirakendused ja nende loomine 2020</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
</head>

<body>
  <div class="container text-center">

    <h2 class="my-3"><?php echo $fullpageTitle; ?></h2>
    <hr>

    <div class="row d-flex justify-content-center">
      <div class="col-md-3">
        <div class="card my-4" style="width: 18rem;">
          <article class="card-body">
            <h4 class="card-title text-center mb-4 mt-1">Palun logi sisse</h4>
            <hr>
            <div class="my-3">
              <span class="text-warning text-danger"><?php echo $emailError; ?></span>
              <span class="text-warning text-danger"><?php echo $passwordError; ?></span>
              <span class="text-warning text-danger"><?php echo $notice; ?></span>
            </div>
            <form class="form-signin" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                  </div>
                  <input type="email" name="email" value="<?php echo $email; ?>" class="form-control"
                    placeholder="E-post (kasutajatunnus)">
                </div> <!-- input-group.// -->
              </div> <!-- form-group// -->
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                  </div>
                  <input type="password" name="password" class="form-control" placeholder="Salasõna">
                </div> <!-- input-group.// -->
              </div> <!-- form-group// -->
              <div class="form-group">
                <button name="login" type="submit" value="Logi sisse" class="btn btn-primary btn-block"> Logi sisse
                </button>
              </div> <!-- form-group// -->
              <p class="text-center py-0 mb-0"><a href="newuser.php" class="nav-link">Loo endale kasutajakonto</a></p>
              <p class="text-center"><a href="#" class="nav-link disabled">Unustasid salasõna?</a></p>
            </form>
          </article>
        </div> <!-- card.// -->
      </div>
    </div>
  </div>
  <?php 
		require "includes/footer.inc.php";
	?>