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
function parse_email( $template, $fan_email, $password = '' ) {
	require( 'config.inc.php' );

	// retrieve values from database
	$query = 'SELECT * FROM ' . $db_table . ' WHERE email = "' .
		$fan_email . '"';
	$db_link = mysql_connect( $db_server, $db_user, $db_password )
		or die( 'Cannot connect to the database. Try again.' );
	mysql_select_db( $db_database )
		or die( 'Cannot connect to the database. Try again.' );
	$result = mysql_query( $query );
	$row = mysql_fetch_array( $result );

	// search and replace special variables
	$template = str_replace( '$$owner_name$$', $owner_name, $template );
	$template = str_replace( '$$fanlisting_title$$', $fanlisting_title,
		$template );
	$template = str_replace( '$$fanlisting_subject$$',
		$fanlisting_subject, $template );
	$template = str_replace( '$$fanlisting_email$$', $fanlisting_email,
		$template );
	$template = str_replace( '$$fanlisting_url$$', $fanlisting_url,
		$template );
	$template = str_replace( '$$fanlisting_list$$', $list_url,
		$template );
	$template = str_replace( '$$fanlisting_update$$', $update_url,
		$template );
	$template = str_replace( '$$fanlisting_join$$', $join_url,
		$template );
	$template = str_replace( '$$fanlisting_lostpass$$', $lostpass_url,
		$template );
	$template = str_replace( '$$listing_type$$', $listing_type,
		$template );
	$template = str_replace( '$$fan_name$$', $row["name"], $template );
	$template = str_replace( '$$fan_email$$', $row["email"], $template );
	if( !isset( $disable_country ) || !$disable_country )
		$template = str_replace( '$$fan_country$$', $row["country"],
			$template );
	$template = str_replace( '$$fan_url$$', $row["url"], $template );
	$template = str_replace( '$$fan_password$$', $password, $template );
	foreach( $additional_field_names as $field ) {
		$template = str_replace( '$$fan_' . $field . '$$',
			$row["$field"], $template );
		}

	return $template;
	}
?>