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
if( !isset( $_SESSION["login_message"] ) )
	$_SESSION["login_message"] = '';

require_once( 'config.inc.php' );
if( isset( $_COOKIE["login_password"] ) &&
	$_COOKIE['login_password'] == md5( $set_password . 'ENTH2' ) ) {
	header( 'location: admin_home.php');
	die();
}

require_once( 'header.inc.php' );
?>

<p class="title">Welcome to Enthusiast!<br />
<?= $fanlisting_title ?>: the <?= $fanlisting_subject ?> <?= $listing_type
	?></p>

<p><span class="important"><?= htmlentities( $_SESSION["login_message"] ) ?></span></p>

<form action="admin_login.php" method="post">

<p>Please log in:</p>

<p>
<table border="0">

<tr><td>Password</td></tr>

<tr><td><input type="password" name="login_password" /></td></tr>

<tr><td colspan="2">
<input type="submit" value="Log in" /><br />
<input type="checkbox" name="rememberme" value="yes" /> Remember me?
</td></tr>

</table>
</p>

</form>

<?php
require_once( 'footer.inc.php' );
?>