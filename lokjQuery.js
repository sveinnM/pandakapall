var elementPos = $("nav").offset();

$(document).ready(function() {

	$("#contButton").click(function() {
		contactMe();
	});

	$(window).scroll(function() {
		stickyNav();
	});

	$(".register").click(function(e) {
		if ($(window).width() < 750) {
			$(".dropDownMenuBar").hide();
		}

		signUpEffect(e);
	});

	$("#signUpBox, #overlay").on("scroll touchmove mousewheel", function(e) {
		e.preventDefault();
		e.stopPropagation();
		return false;
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

	$("#moveLast").click(function() {
		moveLast();
	})

	$(".scoreBoardForm").submit(function(e) {
		scoreBoard(e);
	});

	$(".close").click(function() {
		window.location.reload();
	});

	//Media query:

	$(".dropDownMenu").click(function()	{
		$(".dropDownMenuBar").toggle();
		// $(".dropDownMenu").css("-webkit-filter", "invert(100%)");
	});

});

/*
* Handles the "Hafðu samband". Sends the form as
* serialized data to mailto.php - which then sends
* mail from email entered by user.
*/
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
			var succ = $(label).append("Takk fyrir að hafa samband ! Svarað verður eins fljótt og auðið er.").fadeIn("slow");
			contact.append(succ);
			console.log("Contact form send success")
		});

		request.fail(function(jqrq, status, err) {
			console.log("Contact form fail: " + "\n Type: " + jqrq + " " + status + "\n Reason: " + err)
		});
	}
	return false;
}

/*
* Handles the effect when a user clicks "Skrá inn".
* That is - it handles the fade-in overlay, popup fixed
* sign in box and also that you cant scroll when signing
* in.
*/
function signUpEffect(e) {
	e.preventDefault();

	$("#overlay").fadeIn(50);
	$("#overlay").fadeTo("slow", 0.8);

	/*
	* function center(className, zIndex).
	* Created a center function (see bottom of document) to handle
	* centering boxes.
	*/
	center("#signUpBox", "999");

	$("#signUpBox").show();

	$("#overlay").click(function() {
		$("#overlay, #signUpBox").hide();

		$("#name, #nameID").val("");

		$(".register").off("scroll touchmove mousewheel")
	});
}

/*
* Handles the sticky navigation bar, so when you scroll down
* it follows you (fixed), but when you reach certain height going
* up it releases.
*/
function stickyNav() {
	if ($(window).width() > 750) {

		if ($(window).scrollTop() > elementPos.top) {
			$("nav").removeClass("navbar");
			$("nav").addClass("navbarSticky");
		} else {
			$("nav").removeClass("navbarSticky");
			$("nav").addClass("navbar");
		}

	}
}

/*
* Sends (via method POST) the values of name and nameID 
* (Nafn og notendanafn) to user_log.php which creates cookies
* from the values of name and nameID. These cookies are what 
* define the personal scoreboard the user gets.
*/
function signUp() {
	var name = $("#name").val();
	var nameID = $("#nameID").val();

	if (name !== "" && nameID !== "") {
		$.ajax({
			type: "POST",
			url: "user_log.php",
			data: {nameID: nameID, name: name},
			success: function(data) {
				console.log("User sign up");
				$("#overlay, #signUpBox").hide();
				window.location.reload();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				console.log("Object: " + XMLHttpRequest);
				console.log("Error: " + textStatus);
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

/*
* Handles sign out. Only things it does is sending via POST
* to user_log.php and lets know that user has signed out.
* (which then offsets the cookies created when signed in)
*/
function signOut() {
	$.ajax({
		type: "POST",
		url: "user_log.php",
		data: {signOut: true},
		success: function(data) {
			console.log("Signing out");
			window.location.replace("index.php");
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("Object: " + XMLHttpRequest);
			console.log("Error: " + textStatus);
		}
	});
}

// Start of functions that handle buttons:

/*
* Creates new game
*/
function pandaNewGame() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {newGame: true},
		success: function(data) {
			console.log("Starting new game");
			$("#newGame").html(data);

			$("#moveLast").hide();
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("Object: " + XMLHttpRequest);
			console.log("Error: " + textStatus);
		}
	});
}

/*
* Draws card. If the deck is empty it detects a label
* that got created, and creates a new button that can
* move last card to the first (see moveLast function 
* below).
*/
function drawCard() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {drawCard: true},
		success: function(data) {
			console.log("Drawing 1 card");
			$("#newGame").html(data);

			if ($("label").hasClass("emptyDeck")) {
				$("#moveLast").show();
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("Object: " + XMLHttpRequest);
			console.log("Error: " + textStatus);
		}
	});
}

/*
* Handles undo button that undo's an action made.
*/
function undo() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {undo: true},
		success: function(data) {
			console.log("Undo last move");
			$("#newGame").html(data);

			$("#moveLast").hide();
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("Object: " + XMLHttpRequest);
			console.log("Error: " + textStatus);
		}
	});
}

/*
* Handles hint button. When hint button is clicked, the
* logic class looks in the hand if any cards can be deleted.
* If so, it takes its index and posts a hidden label with the index
* of that card. The function below then takes the value of that label and
* makes the card that can be clicked fade out and back in.
*/
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
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("Object: " + XMLHttpRequest);
			console.log("Error: " + textStatus);
		}
	});
}

/*
* Handles the click on cards to remove them if possible. If 
* a game win is followed by removing it detects a label that has 
* class "win". and then popups an input box to enter name to be
* put in scoreboard.
*/
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
			// $("#moveLast").hide();
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("Object: " + XMLHttpRequest);
			console.log("Error: " + textStatus);
		}
	});
}

/*
* If the deck is empty. You can move the last card in the hand
* to the first place so the hand shifts by one card.
*/
function moveLast() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {lastfirst: true},
		success: function(data) {
			$("#newGame").html(data);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("Object: " + XMLHttpRequest);
			console.log("Error: " + textStatus);
		}
	})
}

/*
* On window load it refreshes (redraws) the hand the 
* user has.
*/
function refresh() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {load: true},
		success: function(data) {
			$("#newGame").html(data);

			if ($("label").hasClass("emptyDeck")) {
				$("#moveLast").show();
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("Object: " + XMLHttpRequest);
			console.log("Error: " + textStatus);
		}
	});
}

/*
* When someone is signed in they get their own scoreboard with
* their personal scores. This function handles the button user
* can click on to reset (clean) their scoreboard.
*/
function resetTable() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {resetTable: true},
		success: function(data) {
			console.log("Resetting table");
			window.location.reload();
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("Object: " + XMLHttpRequest);
			console.log("Error: " + textStatus);
		}
	});
}

/*
* When a user wins the game, he is asked for his name to 
* put on the scoreboard. This function sends the name via
* POST so it can be inserted into the scoreboard.
*/
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
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				console.log("Object: " + XMLHttpRequest);
				console.log("Error: " + textStatus);
			}
		});

	} else if (name == "") {
		$("#errorScoreBoardName").html("* Vinsamlegast settu inn nafn til að uppfæra stigatöflu");
	}
}

function center(className, zIndex) {
	$(function() {
	    $(className).css({
	        "position" : "fixed",
	        "left" : "50%",
	        "top" : "50%",
	        "margin-left" : -$(className).width()/2,
	        "margin-top" : -$(className).height()/2,
	        "z-index" : zIndex
	    });
	});
}