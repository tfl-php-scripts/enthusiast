<?php
/*****************************************************************************
 Enthusiast: Fanlisting Management System
 Copyright (c) by Angela Sabas
 http://scripts.indisguise.org

 This script is made available for free download, use, and modification as
 long as this note remains intact and a link back to
 http://scripts.indisguise.org/ is given. It is hoped that the script
 will be useful, but does not guarantee that it will solve any problem or is
 free from errors of any kind. Users of this script are forbidden to sell or
 distribute the script in whole or in part without written and explicit
 permission from me, and users agree to hold me blameless from any
 liability directly or indirectly arising from the use of this script.

 For more information please view the readme.txt file.
******************************************************************************/
session_start();
require_once( 'config.inc.php' );
if( !isset( $_COOKIE["login_password"] ) ||
	$_COOKIE['login_password'] != md5( $set_password . 'ENTH2' ) ) {
	$_SESSION["login_message"] = 'Please log in first before viewing ' .
		'anything.';
	header( 'location: index.php' );
	die( 'Redirecting you...' );
	}
require_once( 'header.inc.php' );

$show_default = true;
?>

<p class="location">Enthusiast > Send Email</p>

<p>
You can send an email to the approved member/s of your <?= $listing_type ?> 
via the form below.<br />
Write the body of the email on the form below and click "Send Email" to send
the email.<br />
(The loading of the page may take time -- this is normal.)
</p>

<p>
Also, you can optionally select a template to use instead, and use the special
email variables defined<br /> in your emailvars.txt file included in your
installation zip file.
</p>

<?php
$to = '';
if( isset( $_REQUEST["type"] ) && $_REQUEST["type"] == 'single' ) {
	$to = $_REQUEST["email"];
	}
else {
	$to = 'All members';
	}

if( isset( $_REQUEST["done"] ) ) {

	if( isset( $_REQUEST["template"] ) && $_REQUEST["template"] != '' ) {
		$template_file = 'emails/' . $_REQUEST["template"];
		$template_email = fopen( $template_file, 'r' );
		$message = fread( $template_email, filesize(
			$template_file ) );
		fclose( $template_email );
		}
	else
		$message = stripslashes( $_REQUEST["message"] );

	$to = $_REQUEST["to"];
	$subject = $fanlisting_title . ': ' . $_REQUEST["subject"];
	$headers = 'FROM: ' . $fanlisting_title . ' <' .
		$fanlisting_email . '>';

	if( $to == 'All members' ) {

		// REQUEST emails
		$query = 'SELECT email, name FROM ' . $db_table . ' WHERE ' .
			'pending = 0';
		$db_link = mysql_connect( $db_server, $db_user, $db_password )
			or die( 'Cannot connect to the MySQL server: ' .
				mysql_error() );
		mysql_select_db( $db_database )
			or die( 'Cannot select database: ' . mysql_error() );
		$result_set = mysql_query( $query )
			or die( 'Cannot execute query: ' . mysql_error() );

		$email_num = 0;
		$not_sent = array();
		require_once( 'parse_email.php' );
		while( $row = mysql_fetch_array( $result_set, MYSQL_ASSOC ) ) {
			$to_name = $row["name"];
			$to_email = $row["email"];
			$to_actual = $to_name . ' <' . $to_email . '>';
			$to_subject = $subject;
			$to_message = parse_email( $message, $to_email );
			$to_headers = $headers;

			$sent = mail( $to_actual, $to_subject, $to_message,
				$to_headers );
			if( $sent )
				$email_num++;
			else
				$not_sent[] = $to_email;
			}
		mysql_free_result( $result_set );
		unset( $message );

		echo '<p><i>' . $email_num . ' emails sent!</i></p>';
		if( count( $not_sent ) > 0 ) {
			echo '<p>Emails not sent to ';
			foreach( $not_sent as $e )
				echo '<i>' . $e . '</i>, ';
			echo ' (does not include bounced emails).</p>';
			}

		mysql_close( $db_link );

		}
	else {

		require_once( 'parse_email.php' );
		$message = parse_email( $message, $to );
		$success = mail( $to, $subject, $message, $headers );
		if( $success ) {
			echo '<p><i>Email sent to ' . $to . '.</i></p>';
			}
		}
	}
?>

<form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" />
<input type="hidden" name="done" />
<input type="hidden" name="to" value="<?= $to ?>" />

<p><table>

<tr><td>
Email
</td><td>
<?= $to ?>
</td></tr>

<tr><td>
Subject
</td><td>
<?= $fanlisting_title ?>: <input type="text" name="subject" />
</td></tr>

<tr><td>
Message body
</td><td>
<textarea name="message" rows="5" cols="40"></textarea>
</td></tr>

<tr><td>
Use template?
</td></td>
<td><select name="template">
<option value="">Use textarea/no template</option>
<?php
$templates = opendir( 'emails/' );
while( false !== ( $file = readdir( $templates ) ) ) { 
	if( $file != '.' && $file != '..' )
	        echo '<option value="' . $file .
			'">' . $file . '</option>';
    }

?>

<tr><td colspan="2">
<input type="submit" value="Send Email" />
<input type="reset" value="Reset Email" />
</td></tr>

</table></p>

</form>

<?php
require_once( 'footer.inc.php' );
?>