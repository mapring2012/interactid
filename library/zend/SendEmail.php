<?php
class SendEmail 
	{
		
		function SendMail($name, $email, $base, $header, $subjects, $BodyHeader, $BodyMessage)
		{
			$subject = $subjects . " " . $name;
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From:' . $header . "\r\n";
			// begin of HTML messages
			$message = '<html>
					<header>
					<title>' . $BodyHeader . '</title>
					</header>
					<body><div class="ii gt adP adO" id=":oz">
						<div id=":p0">
							<div
								style="border-radius: 5px; border: solid 1px #dfdfdf; font-family: Arial; word-wrap: break-word; width: 670px">
								<div class="adM"></div>
								<table cellspacing="0" cellpadding="0"
									style="background-color: #ededed; border-radius: 5px 5px 0 0; width: 670px">
									<tbody>
										<tr>
											<td>
												<div style="padding: 30px 30px 0; font-size: 20px">
													' . $BodyHeader . '
													<div
														style="margin-top: 20px; width: 0; min-height: 0; border-bottom: 10px solid #fff; border-left: 10px solid transparent; border-right: 10px solid transparent">
													</div>
												</div>
											</td>
											<td
												style="vertical-align: middle; text-align: right; padding-right: 30px">
												<img src="' . $base . '/images/logo1.png"/>
											</td>
										</tr>
									</tbody>
								</table>
								<div style="line-height: 18px; font-size: 14px">
									<div style="padding: 30px 30px 40px">
										' . $BodyMessage . '
									</div>
								</div>
								<div
									style="line-height: 18px; border-radius: 0 0 5px 5px; font-size: 14px; padding: 30px; border-top: solid 1px #dfdfdf">
									<p>
										<strong>Interactid</strong><br>
										<br> 110 avenue Marceau 92 400 COURBEVOIE FRANCE.<br> Email:&nbsp;<a
											target="_blank" href="mailto:contact@interactid.com">contact@interactid.com</a><br>
										Tel : 01.46.43.11.08
									</p>
								</div>
							</div>
							<div class="yj6qo"></div>
							<div class="adL"></div>
						</div>
					</div>
					</body>
					</html>';
			$sendemail = mail ( $email, $subject, $message, $headers );
			return $sendemail;
			// end to confirm email
		}
	}
?>