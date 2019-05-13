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
function get_affiliates( $affiliate_id ='', $url = '',
	$title = '', $image_path = '', $width = '', $height = '',
	$comparison = 'AND' ) {
	require( 'config.inc.php' );

	// create query
	$query = 'SELECT * FROM ' . $db_table . '_affiliates';
	$query .= ' ORDER BY title ASC';

	if( $affiliate_id ) {
		$query = 'SELECT * FROM ' . $db_table . '_affiliates' .
			' WHERE affiliateid = ' . $affiliate_id;
		}

	$db_link = mysql_connect( $db_server, $db_user, $db_password )
		or die( 'Cannot connect to the database. Try again.' );
	mysql_select_db( $db_database )
		or die( 'Cannot connect to the database. Try again.' );
	$result = mysql_query( $query )
		or die( 'Error executing query: ' . mysql_error() );

	$affiliate_array = array();
	while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) {
		$affiliate_array[] = $row;
		}

	mysql_free_result( $result );
	mysql_close( $db_link );

	return $affiliate_array;
	}
?>