<footer>
	<p>&copy; Sveinn Már Ásgeirsson og Ólafur Magnússon - Vefforritun 2014</p>
</footer>

<div id="overlay">
</div>

<form id="signUpBox" autocomplete="off">
	<div class="signUpSet">
	<input type="text" name="username" placeholder="Nafn" id="name" role="textbox" autofocus />
	<div class="circle hintName" title="Nafnið sem þú setur hér verður nafnið sem birtist í stigatöflunni þinni.">?</div>
	<div><label id="errorName"></label></div>
	</div>
	
	<div class="signUpSet">
	<input type="text" name="nameID" placeholder="Notendanafn" id="nameID" role="textbox"/>
	<div class="circle hintNameID" title="Mundu notendanafnið sem þú setur inn hér. Þetta er nafnið sem heldur utan um stigatöfluna þína.">?</div>
	<div><label id="errorNameID"></label></div>
	</div>

	<div class="signUpSet">
	<input type="button" name="submit" value="Skrá inn" id="signUp" role="submit" />
	</div>
</form>

<script src="public/js/jquery.js"></script>
<script src="lokjQuery.js"></script>
</body>
</html>