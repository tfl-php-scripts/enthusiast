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

// create query
$query = 'SELECT DISTINCT( ' . $fl_sort . ' ) FROM ' . $db_table .
	' WHERE pending = 0 ORDER BY ' . $fl_sort . ' ASC';

// connect to database
$db_link = mysql_connect( $db_server, $db_user, $db_password )
	or die( 'Cannot connect to the database. Try again.' );
mysql_select_db( $db_database )
	or die( 'Cannot connect to the database. Try again.' );

// execute query
$result = mysql_query( $query )
	or die( 'Error executing query: ' . mysql_error() );

$sort_array = array();
while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
	$sort_array[] = $row["$fl_sort"];
$sort_num = count( $sort_array );

// check for what kind of list URL
$connector = '?';
if( substr_count( $list_url, '?' ) > 0 )
	$connector = '&';

$member_type = 'fans';
if( substr_count( $listing_type, 'fan' ) == 0 )
	$member_type = 'members';

if( isset( $sort_dropdown ) && $sort_dropdown ) {
	// show sort links in a drop-down menu

	echo '<script language="javascript" type="text/javascript">' . "\n";
	echo '<!-- Begin' . "\n";
	echo 'function change(form) { ' . "\n";
	echo 'var myindex=form.' . $fl_sort . '.selectedIndex ' . "\n";
	echo 'if (form.' . $fl_sort . '.options[myindex].value != "0") ' .
		"\n";
	echo '{ ' . "\n";
	echo 'window.open("' . $list_url . $connector . $fl_sort . '="+' .
		'form.' . $fl_sort . '.options[myindex].value, ' .
		'target="_self"); ' . "\n";
	echo '} ' . "\n";
	echo '} ' . "\n";
	echo '// end --> ' . "\n";
	echo '</script>' . "\n";

	$i = 0;
	echo '<form method="get" action="' . $list_url . '">';
	echo '<select name="' . $fl_sort . '" onchange="change(this.form)">';
	echo '<option value="0"> Select sort option</option>';
	echo '<option value="all"> All ' . $member_type . '</option>';
	while( $i < $sort_num ) {
		if( $sort_array[$i] == '' ) {
			echo '<option value="none"> No ' . $fl_sort .
				' given </option>';
			}
		else {
			echo '<option value="' . $sort_array[$i] . '"> ' .
				$sort_array[$i] . '</option>';
			}
		$i++;
		}
	echo '</select></form>';

	}
else { // show it as links
	$i = 0;
	echo '<ul><li> <a href="' . $list_url . $connector . $fl_sort .
		'=all">All ' . $member_type . '</a> </li>';
	while( $i < $sort_num ) {
		if( $sort_array[$i] == '' ) {
			echo '<li> <a href="' . $list_url . $connector .
				$fl_sort . '=none">No ' . $fl_sort .
				' given</a> </li>';
			}
		else {
			echo '<li> <a href="' . $list_url . $connector .
				$fl_sort . '=' . $sort_array[$i] . '">' .
				$sort_array[$i] . '</a> </li>';
			}
		$i++;
		}
	echo '</ul>';
	}

mysql_close( $db_link );
?>