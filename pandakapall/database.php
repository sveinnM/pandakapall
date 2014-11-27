<?php
class Database {
	private $pdo;

	public function __construct() {
		$root = $_SERVER["DOCUMENT_ROOT"];

		$file_db = new PDO("sqlite:" . $root . "/pandakapall/games.db");
		$file_db->setAttribute(PDO::ATTR_ERRMODE, 
                        PDO::ERRMODE_EXCEPTION);

		$file_db->exec("CREATE TABLE IF NOT EXISTS Highscores (
        				name TEXT, 
        				score TEXT)");

		$file_db->exec("CREATE TABLE IF NOT EXISTS MyHighscore (
        				name TEXT, 
        				score TEXT,
        				key TEXT)");
		
		$this->pdo = $file_db;
	}

	public function insertIntoHighscores($name, $score) {
		$query = $this->pdo->prepare("INSERT INTO Highscores(name, score) VALUES (:name, :score)");
		$result = $query->execute(array("name" => $name, "score" => $score, ));
	}

	public function getHighestScores() {
		$query = $this->pdo->prepare("SELECT name, score FROM Highscores ORDER BY score DESC LIMIT 10");
		$result = $query->execute(array());
		$highscores = $query->fetchAll(PDO::FETCH_ASSOC);
		return $highscores;
	}

	public function insertIntoMyHighscores($name, $score, $key) {
		$query = $this->pdo->prepare("INSERT INTO MyHighscore(name, score, key) VALUES (:name, :score, :key)");
		$result = $query->execute(array("name" => $name, "score" => $score, "key" => $key, ));
	}

	public function getMyHighestScores() {
		$query = $this->pdo->prepare("SELECT name, score FROM MyHighscore WHERE key=? ORDER BY score DESC LIMIT 10");
		$result = $query->execute(array($_COOKIE["login_cookie"]));
		$myHighscores = $query->fetchAll(PDO::FETCH_ASSOC);
		return $myHighscores;
	}

	public function resetMyScores() {
		$cookie = $_COOKIE["login_cookie"];

		$query = $this->pdo->prepare("DELETE FROM MyHighscore WHERE key = ?");
		$result = $query->execute(array($cookie));
	}

	public function newGame($key, $game){
		$game = serialize($game);
		try{
			$query = $this->pdo->prepare("INSERT INTO Saves (key, game) VALUES (:key, :game)");
			$result = $query->execute(array('key' => $key, 'game' => $game, ));
		}catch(PDOException $ex){
			$game = unserialize($game);
			$this->saveGame($key, $game);
		}
	}

	public function saveGame($key, $game){
		$game = serialize($game);
		$query = $this->pdo->prepare("UPDATE Saves SET game=? WHERE key=?");
		$result = $query->execute(array($game, $key));
	}

	public function loadGame($key){
		$query = $this->pdo->prepare("SELECT game FROM Saves WHERE key = :key");
		$result = $query->execute(array('key' => $key));
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		return unserialize($data[0]['game']);
	}
}