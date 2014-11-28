<?php
class Game {
	protected $hand;
	protected $handhistory = array();
	protected $deck;
	protected $score;
	protected $scorehistory = array();
	protected $undo_punishment;

	public function __construct() {
		$this->newGame();
	}

	public function newGame() {
		$this->hand = array();
		$this->deck = new CardDeck();
		$this->score = 100;
		$this->victory = False;
		$this->undo_punishment = 2;

		for($i = 0; $i < 4; $i++){
			array_push($this->hand, $this->deck->draw());
		}
	}

	public function	getHand() {
		return $this->hand;
	}

	public function getScore() {
		return $this->score;
	}

	public function removeTwo($index) {
		if ($this->checkTwo($index)){
			$this->gamehistory();
			unset($this->hand[$index], $this->hand[$index+1]);
			$this->hand = array_values($this->hand);
			$this->score += 10;
		}
	}

	public function removeFour($index) {
		if ($this->checkFour($index)){
			$this->gamehistory();

			for ($i=0;$i < 4; $i++){ 
				unset($this->hand[$index+$i]);
			}

			$this->hand = array_values($this->hand);
			$this->score += 25;
		}
	}

	public function checkTwo($index) {
		if ($index <= 0 or $index+2 >= sizeof($this->hand)){
			return False;
		}

		$firstCard_str = $this->hand[$index-1];
		$lastCard_str = $this->hand[$index+2];

		if (substr($firstCard_str, 0, 1) == substr($lastCard_str, 0, 1)){
			return True;
		}

		return False;
	}

	public function checkFour($index) {
		if ($index < 0 or $index+4 > sizeof($this->hand)){
			return False;
		}

		$firstCard_str = $this->hand[$index];
		$lastCard_str = $this->hand[$index+3];

		if(substr($firstCard_str, 1) == substr($lastCard_str, 1)){
			return True;
		}

		return False;
	}

	public function add() {
		if (!$this->deck->isEmpty()) {
			$this->gamehistory();
			array_push($this->hand, $this->deck->draw());
			$this->score--;
			return True;
		}

		return False;
	}

	public function undo() {
		if (sizeof($this->handhistory) > 0) {
			$lasthand = array_pop($this->handhistory);
			$lastscore = array_pop($this->scorehistory) - $this->undo_punishment;

			if (sizeof($this->hand) - sizeof($lasthand) == 1 && !$this->isDeckEmpty()) {
				$this->deck->putBack(array_pop($this->hand));
			}

			$this->hand = $lasthand;
			$this->score = $lastscore;
			$this->undo_punishment += 2;
		}
	}

	public function hint() {
		for ($i=0; $i < sizeof($this->hand); $i++) { 

			if ($this->checkTwo($i) or $this->checkFour($i)) {
				return $i;
			}
		}

		return false;
	}

	public function gamehistory() {
		$this->handhistory[] = $this->hand;
		$this->scorehistory[] = $this->score;
	}

	public function moveLast() {
		$this->gamehistory();
		$last = array(array_pop($this->hand));
		$this->hand = array_merge($last, $this->hand);
		$this->score--;
	}

	public function isDeckEmpty() {
		return $this->deck->isEmpty();
	}

	public function isWin() {
		if (sizeof($this->hand) <= 2) {
			return True;
		}

		return False;
	}
}