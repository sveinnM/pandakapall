var elementPos = $("nav").offset();

$(document).ready(function() {

	$("#contButton").click(function() {
		contactMe();
	});

	$(window).scroll(function() {
		stickyNav();
	});

	$("#register").click(function(e) {
		signUpEffect(e);
	});

	$("#signUp").click(function() {
		signUp();
	})

	$(".signOut").click(function() {
		signOut();
	});

	$("#newgame").click(function() {
		pandaNewGame();
	});

	$("#addCard").click(function() {
		drawCard();
	});

	$("#undo").click(function() {
		undo();
	});

	$("#hint").click(function() {
		hint();
	});

	$("#resetTable").click(function() {
		resetTable();
	});

	$("#newGame").on("click", "img", function() {
		var id = $(this).attr("data-id");
		removeTwoFour(id);
	});

	$(window).on("load", function() {
		refresh();
	});

	$(".scoreBoardForm").submit(function(e) {
		scoreBoard(e);
	});

	$(".close").click(function() {
		window.location.reload();
	});
});

function contactMe() {
	var contact = $(".contactForm");
	var form = $("#contactForm");
	var contactSubject = $("#contSubject").val();
	var contactContent = $("#contContent").val();
	var contactEmail = $("#contEmail").val();
	var serializedData = form.serialize();

	if ((contactSubject && contactContent && contactEmail) !== '') {
		var request = $.ajax({
			type: "POST",
			url: "mailto.php",
			data: serializedData
		});

		request.done(function(data) {
			contact.children().hide();
			var label = $("<label />");
			var succ = $(label).append("Takk fyrir að hafa samband! við svörum eins fljótt og við getum.").fadeIn("slow");
			contact.append(succ);
			console.log("Contact form send success")
		});

		request.fail(function(jqrq, status, err) {
			console.log("Contact form fail: " + "\n Type: " + jqrq + " " + status + "\n Reason: " + err)
		});
	}
	return false;
}

function signUpEffect(e) {
	e.preventDefault();

	$("#overlay").fadeIn(50);
	$("#overlay").fadeTo("slow", 0.8);
	$("#signUpBox").show();

	$("#register").on("scroll touchmove mousewheel", function(e) {
		e.preventDefault();
		e.stopPropagation();
		return false;
	});

	$("#overlay").click(function() {
		$("#overlay, #signUpBox").hide();

		$("#register").off("scroll touchmove mousewheel")
	});
}

function stickyNav() {
	if ($(window).scrollTop() > elementPos.top) {
		$("nav").removeClass("navbar");
		$("nav").addClass("navbarSticky");
	} else {
		$("nav").removeClass("navbarSticky");
		$("nav").addClass("navbar");
	}    
}

function signUp() {
	var name = $("#name").val();
	var nameID = $("#nameID").val();

	if (name !== "" && nameID !== "") {
		$.ajax({
			type: "POST",
			url: "pandakapall/playGame.php",
			data: {nameID: nameID, name: name},
			success: function(data) {
				console.log("User sign up");
				$("#overlay, #signUpBox").hide();
				window.location.reload();
			}
		});
	}

	if (name == "") {
		$("#errorName").html("* Vinsamlegast settu inn nafn");
	} else if (name !== "") {
		$("#errorName").empty();
	}

	if (nameID == "") {
		$("#errorNameID").html("* Vinsamlegast settu inn notendanafn");
	} else if (nameID !== "") {
		$("#errorNameID").empty();
	}
}

function signOut() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {signOut: true},
		success: function(data) {
			console.log("Signing out");
			window.location.replace("index.php");
		}
	});
}

function pandaNewGame() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {newGame: true},
		success: function(data) {
			console.log("Starting new game");
			// $("#inputScoreName").empty();
			$("#newGame").html(data);
			$(".scoreBoardForm").hide();
		}
	});
}

function drawCard() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {drawCard: true},
		success: function(data) {
			console.log("Drawing 1 card");
			$(".scoreBoardForm").hide();
			$("#newGame").html(data);
		}
	});
}

function undo() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {undo: true},
		success: function(data) {
			console.log("Undo last move");
			$(".scoreBoardForm").hide();
			$("#newGame").html(data);
		}
	});
}

function hint() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {hint: true},
		success: function(data) {
			$(".scoreBoardForm").hide();
			$("#newGame").html(data);
			var index = $("#hintCard").text();

			var hintCard = $("#newGame").find("img[data-id="+index+"]");
			
			$(hintCard).addClass("hintCard");
			$(hintCard).fadeTo("slow", 1);
		}
	});
}

function removeTwoFour(id) {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {remove: id},
		success: function(data) {
			$("#newGame").html(data);
			console.log("Removing card with index" + id);

			if ($("p").hasClass("win")) {
				$("#overlay").show();
				$(".scoreBoardForm").show();
			}
		}
	});
}

function moveLast() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {lastfirst: true},
		success: function(data) {
			$("#newGame").html(data);
		}
	})
}

function refresh() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {load: true},
		success: function(data) {
			$("#newGame").html(data);
		}
	});
}

function resetTable() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {resetTable: true},
		success: function(data) {
			console.log("Resetting table");
			window.location.reload();
		}
	});
}

function scoreBoard(e) {
	e.preventDefault();

	var name = $(".scoreBoardName").val();

	if (name !== "") {
		$.ajax({
			type: "POST",
			url: "pandakapall/playGame.php",
			data: {nameScoreBoard: name},
			success: function(data) {
				console.log(name + " moved to personal scoreboard");
				$(".scoreBoardName").val("");
				window.location.reload();
			}
		});
	} else if (name == "") {
		$("#errorScoreBoardName").html("* Vinsamlegast settu inn nafn til að uppfæra stigatöflu");
	}
}