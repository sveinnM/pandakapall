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

/*
* These guys here talk to the logic class "Game" and decide what to do depending
* on which POST is being sent from the jQuery.
*/
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

		// If hint button is clicked, a label with a hint index is echoed.
		if ($index !== false) {
			$card =  $game->getHand()[$index];
			echo "<label id='hintCard'>$index</label>";
		}
		break;
	case "remove":
		$index = $_POST["remove"];

		// Deleting four cards has priority over deleting two cards.
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

refresh($game);

/*
* If user has won the game or user has entered his name in the input box that 
* appears when a user wins, it goes into this if loop. It starts by connecting 
* to the database and then saves the user's score in a SESSION. Immediately when
* the user wins he has not sent "nameScoreBoard" yet so it goes to the "else" part 
* of the inner if loop. Then if the user is looged in (that is, the login_cookie has
* been made), it inserts into his personal scoreboard the name that the user logged
* in with, the score the session saved in the beginning and then it takes in the key, 
* that is the "login_cookie", and then it echo's the "WINNER WINNER..". So now the user
* has yet to insert his name, when he does and presses enter, it go's again into this 
* loop because "nameScoreBoard" isset, but now it doesn't go to the else, but the if 
* condition itself. There it inserts into the scoreboard the name that was entered and 
* the score that is still kept in the SESSION.
*/
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

/*
* The function that refreshes the current game, that is, it redraws the hand the
* user has.
*/
function refresh($game) {
	$hendi = $game->getHand();
	echo "<p id='score'>Þú ert með ". $game->getScore() ." stig</p>";

	foreach ($hendi as $index => $card) {
		echo "<img class='img' data-id='$index' src='pandakapall/img/$card.png' alt='Card: $card' role='img'>";
	}

	if ($game->isDeckEmpty()) {
		echo "<label class='emptyDeck'>EmptyDeck</label>";
	}
}

if (isset($_POST["resetTable"])) {
	$db = new Database();
	$db->resetMyScores();
}

