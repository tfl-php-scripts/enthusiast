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
?>

<p class="location">Enthusiast > Home</p>

<?php
$today = date( 'F j, Y (l)' );
if( date( 'a' ) == 'am' )
	$greeting = 'Good morning';
else {
	if( date( 'G' ) <= 18 )
		$greeting = 'Good afternoon';
	else
		$greeting = 'Good evening';
	}
?>
<p><?= $greeting ?>! Today is <?= $today ?>.</p>

<p>
You are managing:<br />
<?= $fanlisting_title ?>: the <?= $fanlisting_subject ?> <?= $listing_type ?>.
</p>


<?php
require_once( 'footer.inc.php' );
?>