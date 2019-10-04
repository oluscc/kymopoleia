<?php
	require 'phpmailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host='smtp.gmail.com';
	$mail->port=587;
	$mail->SMTPAuth=true;
	$mail->SMTPSecure='tls';

	$mail->Username='alisataylorm.m@gmail.com';
	$mail->Password='alisa1074';

	$mail->setFrom('alisataylorm.m@gmail.com','Alisa Kymobudget');
	$mail->addAddress('joshua.moshood@gmail.com');
	$mail->addReplyTo('alisataylorm.m@gmail.com');
	$mail->isHTML(true);
	$mail->Subject='KYMOBUDGET Account Verification';
	$mail->Body    = "<center><h4>KYMOBUDGET</h4></center><p>Dear Johu verify your account by clicking here<a href='heroku.com'></a></p>";
	if (!$mail->send()) {
		echo "Message could not be sent!";
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}else{
		echo "Message has been sent!";
	}
?>
