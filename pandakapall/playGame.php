<?php
require("CardDeck.php");
require("Game.php");
require("Database.php");

if (isset($_POST["nameID"])) {
	$cookie_value = md5($_POST["nameID"]);
	$cookie_namevalue = $_POST["name"];

	if (!isset($_COOKIE[$cookie_name])) {
		setcookie("login_cookie", $cookie_value, time() + 86400, "/");
		setcookie("name_cookie", $cookie_namevalue, time() + 86400, "/");
	}
}

session_start();

// $_SESSION["game"] = null;
// $_SESSION["timeStamp"] = null;
// $_SESSION["playGame"] = null;
// $_SESSION["playgame"] = null;
// $_SESSION["hand"] = null;
// session_destroy();

if (isset($_SESSION["game"]) && isset($_SESSION["timeStamp"]) && (time() - $_SESSION["timeStamp"] < 86400*7)) {
  $game = unserialize($_SESSION["game"]);
  $_SESSION["isWin"] = null;
} else {
  $_SESSION["timeStamp"] = time();
  $game = new Game();
}


$method = key($_POST);
switch ($method) {
  case 'newGame':
    $game = new Game();
    break;
  case 'drawCard':
    $game->add();
    break;
  case 'load':
    break;
  case 'undo':
    $game->undo();
    break;
  case "remove":
	$index = $_POST["remove"];

	if ($game->checkTwo($index) and $game->checkFour($index)) {
  		echo "YOLOSWAG";
	} else if ($game->checkTwo($index)) {
		$game->removeTwo($index);
	} else if ($game->checkFour($index)) {
		$game->removeFour($index);
	}
	break;
  case 'lastfirst':
    $game->moveLast();
    break;
  case "":
  default:
  	break;
}

function refresh($game) {
	if(!$game->isWin()){
		$hendi = $game->getHand();
		foreach ($hendi as $index => $card) {
			echo "<img class='img' data-id='$index' src='pandakapall/img/$card.png' height='100px' width='80px'>";
		}

		echo "<p id='score'>Score ". $game->getScore() ."</p>";
		if ($game->isDeckEmpty()) {
			// setcookie("empty_cookie", uniqid(), time() + 86400*7, "/");
			echo "<button id='moveLast' onclick='moveLast()'>Put last card first</button>";
		}
	}
}
refresh($game);

if ($game->isWin()) {
	$_SESSION["isWin"] = $game->isWin();
	// var_dump($_SESSION);
	// var_dump($_SESSION["isWin"]);
	$db = new Database();
  	echo "<p class='win'>WINNER</p>";
  	// require("../views/play.php");
  	// echo "<input type='text' placeholder='Nafn á stigatöflu' />";
	$db->insertIntoHighscores('oli', $game->getScore());
	$_SESSION["name"] = $_POST["name"];
	$db->insertIntoMyHighscores($_SESSION["name"], $game->getScore());
	$game = new Game();
}

if (isset($_POST["signOut"])) {
	setcookie("login_cookie", uniqid(), time() - 86400, "/");
	setcookie("name_cookie", uniqid(), time() - 86400, "/");
}



$_SESSION["game"] = serialize($game);
// } 
// else if (isset($_COOKIE["game_cookie"])) {

// 	$key = $_COOKIE["game_cookie"];
// 	$name = $_COOKIE["name_cookie"];

// 	$db = setDB();

// 	for ($i=0; $i < 1; $i++) {
//   		$db->newGame("CPU" . $i, new Game());
// 	}

// 	$method = key($_POST);

// 	switch($method) {
// 		case "newGame":
// 			$game = new Game();
// 			$db->newGame($key, $game);
//     		refreshCookie($key, $db);
//     		break;
//     	case "drawCard":
//     		$game = $db->loadGame($key);
//     		$game->add();
//     		$db->saveGame($key, $game);
//     		refreshCookie($key, $db);
//     		break;
//     	case "undo":
//     		$game = $db->loadGame($key);
//     		$game->undo();
//     		$db->saveGame($key, $game);
//     		refreshCookie($key, $db);	
//     		break;
//     	case "index":
// 	    	$game = $db->loadGame($key);
// 	    	$index = $_POST["index"];

// 			if ($game->checkTwo($index) and $game->checkFour($index)){
// 	  			echo "YOLOSWAG";
// 			} else if ($game->checkTwo($index)) {
// 	  			$game->indexTwo($index);
// 				$db->saveGame($key, $game);
// 				refreshCookie($key, $db);
// 			} else if ($game->checkFour($index)) {
// 	  			$game->indexFour($index);
// 	  			$db->saveGame($key, $game);
// 	  			refreshCookie($key, $db);
// 			} else {
// 				refreshCookie($key,$db);
// 			}
// 			break;
// 		case "":
// 			break;
// 	}

// }

// function refreshCookie($key, $db)	{
// 		$game = $db->loadGame($key);
//   		$hendi = $game->getHand();
//   		foreach ($hendi as $card) {
//   		}
// }

// function refresh($hendi, $game) {
// 		if ($game->isWin()) {
// 			echo "<h1>Þú vannst !</h1>";
// 			echo "<p>Stigatöflur hafa verið uppfærðar</p>";
// 		} else {
// 			foreach ($hendi as $key=>$card) {
// 			}
// 		}
// 	}

// function setDB() {
// 	$file_db = new PDO('sqlite:/games.db');
// 	$file_db->setAttribute(PDO::ATTR_ERRMODE, 
//                        		PDO::ERRMODE_EXCEPTION);

// 	$file_db->exec("CREATE TABLE IF NOT EXISTS Saves (
//         			key TEXT PRIMARY KEY,
//         			game TEXT)");

// 	$db = new Database($file_db);

// 	return $db;
// }