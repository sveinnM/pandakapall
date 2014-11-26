<main>
	<div class="content">
		<?php var_dump($_COOKIE); ?>
		<button id="newgame">New Game</button>
		<div id="newGame">
		</div>
		<button id="addCard">Draw</button>
		<button id="undo">Undo</button>
		<div id="myScoreBoardDiv">
			<form class="myScoreBoardForm">
				<input type="text" placeholder="Nafn fyrir stigatöflu" class="myScoreBoardName" />
				<div><label id="errorScoreBoardName"></label></div>
			</form>
		</div>
	</div>
</main>