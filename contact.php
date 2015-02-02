<?php include("header.php"); ?>
    <h2 style="font-family:verdana; font-size:23px;">Contact Us</h2>
<?php
  if ($_GET && $_GET['status']) {
    if ($_GET['status'] == "ok") {
      print("<p><strong>Thank you for filling out the form. We will be in touch shortly.</strong></p>\r\n");
    } elseif ($_GET['status'] == "error") {
      $msg = $_GET['msg'];
      print("<p><strong>Please correct the reported errors - $msg</strong></p>\r\n");
    } elseif ($_GET['status'] == "missing") {
      print("<p><strong>Please supply all required fields.</strong></p>\r\n");
    }
  }
?>
	<form action="formmail.php" method="post">
	    <p>
		    <input type="hidden" name="recipient" value="tonypalfrey@hotmail.co.uk">
		    <input type="hidden" name="required" value="env_report,realname,email,subject,message">
		    <input type="hidden" name="env_report" value="REMOTE_ADDR,HTTP_USER_AGENT">
		    <input type="hidden" name="sort" value="email,realname,subject,message">
		    <input type="hidden" name="redirect" value="contact.php?status=ok">
		    <input type="hidden" name="error_redirect" value="contact.php?status=error">
		    <input type="hidden" name="missing_fields_redirect" value="contact.php?status=missing">
	    </p>
		<table border="0">
			<tr>
			<td>Your Name</td>
			<td><input type="text" size="50" name="realname" value=""></td>
			</tr>
			<tr>
			<td>Your E-Mail Address</td>
			<td><input type="text" size="50" name="email" value=""></td>
			</tr>
			<tr>
			<td>Subject</td>
			<td><input type="text" size="50" name="subject" value=""></td>
			</tr>
			<tr>
			<td>Message</td>
			<td><textarea cols="50" rows="15" name="message"></textarea></td>
			</tr>
			<tr>
			<td colspan="2" align="right"><input type="submit" value="submit"></td>
			</tr>
		</table>
	</form>
<?php include("footer.php"); ?>