<!DOCTYPE html>
<html lang="IS">
<head>
  <title>Panda kapall</title>
  <meta charset="UTF-8">

  <link href="public/css/stylesheet.css" rel="stylesheet" type="text/css">
  <link href="//fonts.googleapis.com/css?family=Quicksand:400,700" rel="stylesheet" type="text/css">
</head>
<body role="document">
<header role="header">

  <h1 role="heading">Panda kapall.</h1>

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

  <nav class="navbar" role="navigation">
    <a class="dropDownMenu" role="menuitem">&#9776;</a> <!-- 3 línur -->
    <a class="home defaultNavbar" href="index.php" role="menuitem">Heim</a>
    <a class="play defaultNavbar" href="index.php?part=play" role="menuitem">Spila</a>
    <a class="highscore defaultNavbar" href="index.php?part=highscore" role="menuitem">Stigatafla</a>
    <?php
      // Your personal scoreboard appears in the navigation if you're logged in.
      if (isset($_COOKIE["login_cookie"])) {
    ?>  <a class="myHighscore defaultNavbar" href="index.php?part=myhighscore" role="menuitem">Mín stigatafla</a>
    <?php    
      }
    ?>
    <a class="about defaultNavbar" href="index.php?part=about" role="menuitem">Um síðu</a>
    <a class="rules defaultNavbar" href="index.php?part=rules" role="menuitem">Reglur</a>
    <a class="contact defaultNavbar" href="index.php?part=contact" role="menuitem">Hafa samband</a>
  </nav>

  <nav class="dropDownMenuBar" role="dropdown navigation">
    <ul role="list">
      <li role="listitem"><a class="home" href="index.php" role="menuitem">Heim</a></li>
      <li role="listitem"><a class="play" href="index.php?part=play" role="menuitem">Spila</a></li>
      <li role="listitem"><a class="highscore" href="index.php?part=highscore" role="menuitem">Stigatafla</a></li>
      <?php
        // Your personal scoreboard appears in the navigation if you're logged in.
        if (isset($_COOKIE["login_cookie"])) {
      ?>  <li role="listitem"><a class="myHighscore" href="index.php?part=myhighscore" role="menuitem">Mín stigatafla</a></li>
      <?php    
        }
      ?>
      <li role="listitem"><a class="about" href="index.php?part=about" role="menuitem">Um síðu</a></li>
      <li role="listitem"><a class="rules" href="index.php?part=rules" role="menuitem">Reglur</a></li>
      <li role="listitem"><a class="contact" href="index.php?part=contact" role="menuitem">Hafa samband</a></li>
      <li role="listitem">
      <?php 
        if (isset($_COOKIE["login_cookie"]) && isset($_COOKIE["name_cookie"])) {
      ?>
          <a class="signOut" role="menuitem">Skrá út</a></li>
      <?php
        } else { ?>
          <p><a href="index.php?part=register" class="register" role="menuitem">Skrá inn</a></p></li>
      <?php 
        } 
      ?>
    </ul>
  </div>

</header>