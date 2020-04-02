<?php

  // sessiooni käivitamine või kasutamine
  //session_start();


  function signUp($name, $surname, $email, $gender, $birthDate, $password) {

    $notice = null;
 		//loon andmebaasiühenduse
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    //valmistan ette SQL päringu
    $stmt = $conn->prepare("INSERT INTO vr20_users (firstname, lastname, birthdate, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    // kui viga, siis väljastan vea
    echo $conn->error;

    // krüpteerin parooli
    $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
    $pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);

    // NB! Jälgi järjekorda
    $stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);

    if ($stmt->execute()) {
      $notice = "ok";
    } else {
        $notice = $stmt->error;
    }

    //sulgen päringu ja andmebaasiühenduse
		$stmt->close();
		$conn->close();

    return $notice;

  }


  function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
  }
  

  function signIn($email, $password) {
    
    $notice = null;
 		//loon andmebaasiühenduse
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    //valmistan ette SQL päringu
    $stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM vr20_users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->bind_result($idFromDB, $firstnameFromDB, $lastnameFromDB, $passwordFromDB);
    // kui viga, siis väljastan vea
    echo $conn->error;

    $stmt->execute();

    if ($stmt->fetch()) {
      if (password_verify($password, $passwordFromDB)) {
        $_SESSION["userid"] = $idFromDB;
        $_SESSION["userFirstName"] = $firstnameFromDB;
        $_SESSION["userLastName"] = $lastnameFromDB;

        $stmt->close();
        $conn->close();
        header("Location: home.php");
        exit();    
      } else {
        $notice = "Vale salasõna!";
      }
    } else {
        $notice = "Sellist kasutajat (" . $email . ") ei leitud!";
    }

    //sulgen päringu ja andmebaasiühenduse
		$stmt->close();
		$conn->close();

    return $notice;

  }