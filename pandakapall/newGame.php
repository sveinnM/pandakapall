<?php
	require_once("CardDeck.php");
	require_once("Game.php");

class NewGame {

	public $game;
	public $hendi;
	public $img = array();
	
	public function __construct() {
	}

	public function newGame() {
		$this->game = new Game();
		$this->hendi = $this->game->getHand();
		$this->refreshDraw($this->hendi);
	}

	public function drawCard() {
		$this->game->add();
		$this->hendi = $this->game->getHand();
		$this->refreshDraw($this->hendi);
	}

	public function undo() {
		$this->game->undo();
		$this->hendi = $this->game->getHand();
		$this->refreshDraw($this->hendi);
	}

	public function remove($index) {
		if ($this->game->checkTwo($index)) {
			$this->game->removeTwo($index);
			$this->hendi = $this->game->getHand();
			$this->refreshDraw($this->hendi);
		} else if ($this->game->checkFour($index)) {
			$this->game->removeFour($index);
			$this->hendi = $this->game->getHand();
			$this->refreshDraw($this->hendi);
		} else {
			$this->refreshDraw($this->hendi);
		}
	}

	public function refreshDraw($hendi) {
		if ($this->game->isWin()) {
			echo "<p>Þú vannst !</p>";
		} else {
			foreach ($hendi as $key=>$card) {
				?><img class="img" data-id="<?php echo $key ?>"src="pandakapall/img/<?php echo $card ?>.png"><?php
			}
		}
	}

}