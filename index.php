<?php 
include('views/header.php');
echo "svenni elskar stjornuna hans reynis";
$part = "";
if (isset($_GET['part'])) {
  $part = $_GET['part'];
}

switch ($part) {
  case 'play':
    include('views/play.php');
    break;
  case 'about':
    include('views/about.php');
    break;
  case 'contact':
    include('views/contact.php');
    break;
  case 'rules':
    include('views/rules.php');
    break;
  case 'highscore':
    include('views/highscore.php');
    break;
  case 'myhighscore':
    include('views/myhighscore.php');
    break;
  case '':
  default:
    include('views/main.php');
    break;
}


include('views/footer.php');



  // if (isset($_POST["drawCard"]) && !isset($_POST["newGame"])) {
  //   echo "You drew a card";
  //   // $game->add();
  //   // var_dump($hendi);
  //   // $game->add();
  // }