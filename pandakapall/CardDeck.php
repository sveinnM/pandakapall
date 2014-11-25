<?php
class CardDeck{
	protected $deck = array();

	public function __construct() {
		$this->newDeck();
		shuffle($this->deck);
	}
	
	public function newDeck(){
		$suit = array('H','S','D','C');
		$number = array('1','2','3','4','5','6','7','8','9','10','J','Q','K');
		foreach ($suit as $i) {
			foreach ($number as $k) {
				$card = $i . $k;
				array_push($this->deck, $card);
			}
		}
	}

	public function draw(){
		return array_pop($this->deck);
	}
	
	public function isEmpty(){
		return !(sizeof($this->deck) > 0);
	}

	public function	getDeck(){
		return $this->deck;
	}

	public function count(){
		return sizeof($this->deck);
	}

	public function putBack($card){
		array_push($this->deck, $card);
	}
}