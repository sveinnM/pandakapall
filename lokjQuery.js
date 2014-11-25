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

	$("#newGame").on("click", "img", function() {
		var id = $(this).attr("data-id");
		removeTwoFour(id);
	});

	// $("#moveLastButton").on("click", "button", function () {
	// 	// console.log("movelast");
	// 	moveLast();
	// });

	$(window).on("load", function() {
		refresh();
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
			var succ = $(label).append("Takk fyrir að hafa samband ! ég svara eins fljótt og ég get.").fadeIn("slow");
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
		// $("#overlay, #signUpBox");	
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
	// var str = "Velkomin/n ";
	// str.substring(0,1).toUpperCase();

	if (name !== "" && nameID !== "") {
		$.ajax({
			type: "POST",
			url: "pandakapall/playGame.php",
			data: {nameID: nameID, name: name},
			success: function(data) {
				console.log("User sign up");
				$("#overlay, #signUpBox").hide();
				// console.log(data);
				window.location.reload();
				// console.log(data);
				// $("#newGame").append(data);
				// $("#signUpDiv").empty();
				// $("#signUpDiv").append("<strong><h3 id='welcome'>Velkomin/n " + name + "!</h3></strong>");
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
			// $("#newGame").empty();
			$("#newGame").html(data);
			// $("#addCard").show();
			// $("#undo").show();
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
			// $(".cards").hide();
			// $("#newGame").empty();
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
			// $("#newGame").empty();
			$("#newGame").html(data);
		}
	})
}

function removeTwoFour(id) {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {remove: id},
		success: function(data) {
			// console.log(data);
			// $("#newGame").empty();
			$("#newGame").html(data);
			console.log("Removing");
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