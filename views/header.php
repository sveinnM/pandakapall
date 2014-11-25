<!DOCTYPE html>
<html lang="IS">
<head>
  <title>Panda kapall</title>
  <meta charset="UTF-8">

  <link href="public/css/stylesheet.css" rel="stylesheet" type="text/css">
  <link href="//fonts.googleapis.com/css?family=Quicksand:400,700" rel="stylesheet" type="text/css">
</head>
<body>
<header>

  <h1>Panda kapall.</h1>

  <div id="signUpDiv">
    <?php 
      // require("/pandakapall/playGame.php");
      // $cookie = new playGame();
      if (isset($_COOKIE["login_cookie"]) && isset($_COOKIE["name_cookie"])) {
        ?>
          <p>Velkomin/n <?php echo $_COOKIE["name_cookie"]; ?> !</p>
          <a class="signOut">Skrá út</a>
        <?php
      } else { ?>
    <p><a href="index.php?part=register" id="register">Skrá inn</a></p>
      <?php } ?>
  </div>

  <nav class="navbar">
    <a class="home" href="index.php">Heim</a>
    <a class="play" href="index.php?part=play">Spila</a>
    <a class="highscore" href="index.php?part=highscore">Stigatafla</a>
    <?php
      if (isset($_COOKIE["login_cookie"])) {
    ?>  <a class="myHighscore" href="index.php?part=myhighscore">Mín stigatafla</a>
    <?php    
      }
    ?>
    <a class="about" href="index.php?part=about">Um síðu</a>
    <a class="rules" href="index.php?part=rules">Reglur</a>
    <a class="contact" href="index.php?part=contact">Hafa samband</a>
  </nav>

</header>