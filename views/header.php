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
    // Displays different welcome message depending on if you're logged in or not.
      if (isset($_COOKIE["login_cookie"]) && isset($_COOKIE["name_cookie"])) {
        ?>
          <p>Velkomin/n <?php echo $_COOKIE["name_cookie"]; ?>!</p>
          <a class="signOut">Skrá út</a>
        <?php
      } else { ?>
    <p><a href="index.php?part=register" class="register">Skrá inn</a></p>
      <?php } ?>
  </div>

  <nav class="navbar">
    <a class="dropDownMenu">&#9776;</a> <!-- 3 línur -->
    <a class="home defaultNavbar" href="index.php">Heim</a>
    <a class="play defaultNavbar" href="index.php?part=play">Spila</a>
    <a class="highscore defaultNavbar" href="index.php?part=highscore">Stigatafla</a>
    <?php
      // Your personal scoreboard appears in the navigation if you're logged in.
      if (isset($_COOKIE["login_cookie"])) {
    ?>  <a class="myHighscore defaultNavbar" href="index.php?part=myhighscore">Mín stigatafla</a>
    <?php    
      }
    ?>
    <a class="about defaultNavbar" href="index.php?part=about">Um síðu</a>
    <a class="rules defaultNavbar" href="index.php?part=rules">Reglur</a>
    <a class="contact defaultNavbar" href="index.php?part=contact">Hafa samband</a>
  </nav>

  <div class="dropDownMenuBar">
    <ul>
      <li><a class="home" href="index.php">Heim</a></li>
      <li><a class="play" href="index.php?part=play">Spila</a></li>
      <li><a class="highscore" href="index.php?part=highscore">Stigatafla</a></li>
      <?php
        // Your personal scoreboard appears in the navigation if you're logged in.
        if (isset($_COOKIE["login_cookie"])) {
      ?>  <li><a class="myHighscore" href="index.php?part=myhighscore">Mín stigatafla</a></li>
      <?php    
        }
      ?>
      <li><a class="about" href="index.php?part=about">Um síðu</a></li>
      <li><a class="rules" href="index.php?part=rules">Reglur</a></li>
      <li><a class="contact" href="index.php?part=contact">Hafa samband</a></li>
      <li>
      <?php 
        if (isset($_COOKIE["login_cookie"]) && isset($_COOKIE["name_cookie"])) {
      ?>
          <a class="signOut">Skrá út</a></li>
      <?php
        } else { ?>
          <p><a href="index.php?part=register" class="register">Skrá inn</a></p></li>
      <?php 
        } 
      ?>
    </ul>
  </div>

</header>