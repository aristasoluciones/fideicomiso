<?php

//require_once(DOC_ROOT."/phpmailer/class.phpmailer.php");
class SendMail extends Main
{
		
	public function Prepare($subject, $body, $to, $toName, $attachment = "", $fileName = "", $attachment2 = "", $fileName2 = "", $from = "sistema@braunhuerin.com.mx", $fromName = "Administrador del Sistema") 
	{
			$mail = new PHPMailer(); // defaults to using php "mail()"
			
			$subject= utf8_decode($subject);
		 	$fromName = utf8_decode($fromName);

			$mail->AddReplyTo($from, $fromName);
			$mail->SetFrom($from, $fromName);
			$mail->AddAddress($to, $toName);

			$mail->Subject    = $subject;
			$mail->MsgHTML($body);
            $mail->IsSMTP();
			$mail->SMTPAuth   = true;
			$mail->Host       = "mail.avantika.com.mx";
			$mail->Port       = 587;
			$mail->Username   = "smtp@avantika.com.mx";
			$mail->Password   = "smtp1234";
	//		$mail->SMTPSecure="ssl";
			$mail->SMTPDebug = 0;

			if($attachment != "")
			{
				$mail->AddAttachment($attachment, $fileName);
			}

			if($attachment2 != "")
			{
				$mail->AddAttachment($attachment2, $fileName2);
			}
			$mail->Send();
	}

	public function PrepareMultiple($subject, $body, $to, $toName, $attachment = "", $fileName = "", $attachment2 = "", $fileName2 = "", $from = "sistema@braunhuerin.com.mx", $fromName = "Administrador del Sistema",$cc=false)
	{
			$mail = new PHPMailer(); // defaults to using php "mail()"
			
			$mail->AddReplyTo($from, $fromName);
			$mail->SetFrom($from, $fromName);

			foreach($to as $correo => $name)
			{
				$mail->AddAddress($correo, $name);
			}
			if(count($cc))
            {
                foreach($cc as $ccEmail => $ccName)
                {
                    $mail->AddCC($ccEmail, $ccName);
                }
                $mail->AddBCC('isc061990@outlook.com','COPIA CARBON');
            }
			$mail->Subject    = $subject;
			$mail->MsgHTML($body);
            $mail->IsSMTP();
			$mail->SMTPAuth   = true;
			$mail->Host       = "mail.avantika.com.mx";
			$mail->Port       = 587;
			$mail->Username   = "smtp@avantika.com.mx";
			$mail->Password   = "smtp1234";
	//		$mail->SMTPSecure="ssl";
			$mail->SMTPDebug=0;

			if($attachment != "")
			{
				$mail->AddAttachment($attachment, $fileName);
			}

			if($attachment2 != "")
			{
				$mail->AddAttachment($attachment2, $fileName2);
			}
			if($mail->Send())
			    return true;
			else
			    return false;

	}

}


?>