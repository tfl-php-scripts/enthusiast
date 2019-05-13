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
require_once( 'config.inc.php' );
$query = 'SELECT MAX( added ) AS latest FROM `' . $db_table .
	'` WHERE pending = 0';

$db_link = mysql_connect( $db_server, $db_user, $db_password )
	or die( 'Cannot connect to the database. Try again.' );
mysql_select_db( $db_database )
	or die( 'Cannot connect to the database. Try again.' );

$result = mysql_query( $query );
$rows = mysql_fetch_array( $result );
$latest = $rows["latest"];

$query = 'SELECT * FROM ' . $db_table . ' WHERE added = "' . $latest . '"';

$result = mysql_query( $query );
while( $row = mysql_fetch_array( $result ) ) {
	if( $row["url"] && $row["showurl"] == 1 )
		echo '<a href="' . $row["url"] . '" target="_top">';
	echo $row["name"];
	if( $row["url"] && $row["showurl"] == 1 )
		echo '</a>';
        echo ' ';
	}

mysql_close( $db_link );
?>