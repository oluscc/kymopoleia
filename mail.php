<?php
	require 'phpmailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	//$mail->isSMTP();
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
	$mail->body='<h1 align=center>Account Verification</h1><br><h4 align=center>Click verify</h4>';
	if (!$mail->send()) {
		echo "Message could not be sent!";
	}else{
		echo "Message has been sent!";
	}
?>