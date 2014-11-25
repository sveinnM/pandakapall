<?php
	// require('../PHPMailer-master/PHPMailerAutoload.php');
	echo "Email: " . $_POST['email'] . "\n";
	echo "Subject: " . $_POST['subject'] . "\n";
	echo "Content: " . $_POST['content'];

	$addressTo = "sveinmar@msn.com";
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$content = $_POST['content'];

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers .= 'From: John Smith <john@mail.com>' . "\r\n";

	$mail = mail($addressTo, $subject, $content, $headers);

	if ($mail == 1) echo "Mail was sent";
	else echo "Mail was NOT sent";

	// $mailer = new PHPMailer();

	// $mailer->isSendmail();
	// $mailer->setFrom($email, "First Last");
	// $mailer->addAddress($addressTo, "Sveinn Már");
	// $mailer->Subject = $subject;

	// $mailer->send();
	// var_dump($_POST['subject']);
	// echo $_POST['subject'];
	// echo "<script type='text/javascript'>alert('Im here');</script>";
	// mail("sveinmar@msn.com", $subject, $content);