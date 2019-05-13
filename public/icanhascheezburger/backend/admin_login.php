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
$_SESSION["login_message"] = '';
require_once( 'config.inc.php' );

if( isset( $_POST["login_password"] ) && $_POST["login_password"] != '' )
	$login_password = trim( htmlentities( $_POST["login_password"] ) );
else {
	$_SESSION["login_message"] = 'You must enter your password below ' .
		'to log into the system.';
	header( 'location: index.php' );
	die( 'Redirecting you...' );
	}

if( $login_password != $set_password ) {
	$_SESSION["login_message"] = 'Your password does not match ' .
		'the previously set administrator password. Please try again.';
	header( 'location: index.php' );
	die( 'Redirecting you...' );
	}
else {
	session_regenerate_id();
	if( isset( $_POST["rememberme"] ) &&
		$_POST["rememberme"] == 'yes' ) {
		$cookie_set = setcookie( "login_password", md5( $login_password . 'ENTH2' ),
			time()+60*60*24*30 );
		}
	else
		$cookie_set = setcookie( "login_password", md5( $login_password . 'ENTH2' ) );

	if( $cookie_set ) {
		header( 'location: admin_home.php' );
		die( 'Redirecting you...' );
		}
	else
		echo '<p>Login successful. <a href="admin_home.php"' .
			'>Continue...</a></p>';
	}
?>