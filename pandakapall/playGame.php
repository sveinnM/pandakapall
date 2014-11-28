<?php
require("CardDeck.php");
require("Game.php");
require("database.php");

session_start();

if (isset($_SESSION["game"]) && isset($_SESSION["timeStamp"]) && (time() - $_SESSION["timeStamp"] < 86400*7)) {
	$game = unserialize($_SESSION["game"]);
	$_SESSION["isWin"] = null;
} else {
	$_SESSION["timeStamp"] = time();
	$game = new Game();
}


$method = key($_POST);
switch ($method) {
	case "newGame":
		$game = new Game();
		break;
	case "drawCard":
		$game->add();
		break;
	case "load":
		break;
	case "undo":
		$game->undo();
		break;
	case "hint":
		$index = $game->hint();

		if ($index !== false) {
			$card =  $game->getHand()[$index];
			echo "<label id='hintCard'>$index</label>";
		}
		break;
	case "remove":
		$index = $_POST["remove"];

		if ($game->checkFour($index)) {
			$game->removeFour($index);
		} else if ($game->checkTwo($index)) {
			$game->removeTwo($index);
		}
		break;
	case "lastfirst":
		$game->moveLast();
		break;
	case "":
	default:
		break;
}
var_dump($_SESSION['score']);

refresh($game);
if ($game->isWin() or isset($_POST["nameScoreBoard"])) {
	$db = new Database();
	$_SESSION["score"] = $game->getScore();

	if (isset($_POST["nameScoreBoard"])) {
		$db->insertIntoHighscores($_POST["nameScoreBoard"], intval($_SESSION["score"]));
		$game = new Game();
	} else {
		if (isset($_COOKIE["login_cookie"])) {
			$db->insertIntoMyHighscores($_COOKIE["name_cookie"], intval($_SESSION["score"]), $_COOKIE["login_cookie"]);
		}
	  	echo "<p class='win'><strong>WINNER WINNER CHICKEN DINNER</strong></p>";
	}
}

$_SESSION["game"] = serialize($game);

function refresh($game) {
	$hendi = $game->getHand();
	echo "<p id='score'>Þú ert með ". $game->getScore() ." stig</p>";

	foreach ($hendi as $index => $card) {
		echo "<img class='img' data-id='$index' src='pandakapall/img/$card.png' height='100px' width='80px'>";
	}

	if ($game->isDeckEmpty()) {
		echo "<label class='emptyDeck'>EmptyDeck</label>";
	}
}

if (isset($_POST["resetTable"])) {
	$db = new Database();
	$db->resetMyScores();
}

