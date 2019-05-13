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

// clean function
function clean( $data ) {
   $data = trim( htmlentities( strip_tags( $data ), ENT_QUOTES ) );

   if( get_magic_quotes_gpc() )
      $data = stripslashes( $data );

   $data = addslashes( $data );

   return $data;
}

if( isset( $_GET["$fl_sort"] ) || $fl_sort == '' ) {

	// set sorting criteria
	$sort_by = clean( $_GET["$fl_sort"] );

	// build query
	if( $fl_sort == '' || $sort_by == 'all' ) {
		$query = 'SELECT * FROM ' . $db_table . ' WHERE pending = 0' .
			' ORDER BY name ASC';
		echo '<h3 style="margin:25px 0 15px 0;">Showing all members...</h3>';
		}
	else {
		$query = 'SELECT * FROM ' . $db_table . ' WHERE ' . $fl_sort .
			' = "' . $sort_by . '" AND pending = 0 ORDER BY ' .
			'name ASC';
		if( $sort_by == 'none' ) {
			$query = 'SELECT * FROM ' . $db_table . ' WHERE ' .
			$fl_sort . ' IS NULL OR ' . $fl_sort .
			' = "" AND pending = 0 ' . 'ORDER BY name ASC';
			}
		echo '<h3 style="margin:25px 0 15px 0;">Showing ' . ucfirst( $fl_sort ) . ': ' .
			ucfirst( $sort_by ) . ' ... </h3>';
		}
	if( isset( $_GET["start"] ) )
		$start = clean( $_GET["start"] );
	else
		$start = 0;

	// connect to database
	$db_link = mysql_connect( $db_server, $db_user, $db_password )
		or die( 'Cannot connect to the database. Try again.' );
	mysql_select_db( $db_database )
		or die( 'Cannot connect to the database. Try again.' );

	// execute query
	$result = mysql_query( $query )
		or die( 'Error executing query: ' . mysql_error() );
	$fan_num = mysql_num_rows( $result );

	$result = mysql_query( $query . ' LIMIT ' . $start . ', ' .
		$fans_per_page )
		or die( 'Error executing query: ' . mysql_error() );

	// include
	@include 'listheader.inc.php';

	$fan_array = array();
	while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) {

		// load results into variables
		$fan_name = $row["name"];
		if( $row["showemail"] == 1 || $row["showemail"] == '1' ) {

			// if email is shown, spam-protect email
			$email_plain = explode( '@', $row["email"] );
			$fan_email = '<script type="text/javascript">' .
				"\r\n<!--\r\n" .
				"jsemail = ( '$email_plain[0]' + " .
				"'@' + '$email_plain[1]' ); \r\n" .
				"document.write( '<a href=\"mailto:' + " .
				"jsemail + '\">email</a>' );\r\n" .
				' -->' . "\r\n" . '</script>';
			$fan_email_plain = ' &#8212; ' . $email_plain[0] . ' {at} ' .
				$email_plain[1];

			}
		else {

			// hide email
			$fan_email = '';
			$fan_email_plain = ' &#8212; <span style="font-style:italic' .
					';">email hidden</span>';

			}
		if( $row["showurl"] == 1 || $row["showurl"] == '1' ) {

			// if website is shown and website is present
			if( $row["url"] ) {
				if( !isset( $link_target ) )
					$link_target = '_top';
				$fan_url = '<a href="' . $row["url"] . '" ' .
					'target="' . $link_target . '">' .
					'website</a>';
				$fan_url_plain = $row["url"];
				}
			else {
				$fan_url = '<span style="font-style:italic' .
					';">no website</span>';
				$fan_url_plain = '';
				}

			}
		else {
			$fan_url = '<span style="font-style:italic' .
				';">no website</span>';
			$fan_url_plain = '';
			}
		if( isset( $disable_country ) && $disable_country )
			$fan_country = '';
		else if( $fl_sort == 'country' && !$show_sort_field &&
			$sort_by != 'all' )
			$fan_country = '';
		else
			$fan_country = $row["country"] . " &#8212; ";

		if( $additional_field ) {
			$field_num = count( $additional_field_names );
			$i = 0;
			while( $i < $field_num ) {
				$$additional_field_names[$i] =
					$row["$additional_field_names[$i]"];
				$i++;
				}
			}

		// show values on page
		if( file_exists( 'list.inc.php' ) ) {

			// if user template is present, get template
			$template = fopen( 'list.inc.php', 'r' );
			$fan_entry = fread( $template, filesize(
				'list.inc.php' ) );
			fclose( $template );

			// load values to template
			$fan_entry = str_replace( '$$fan_name$$', $fan_name,
				$fan_entry );
			$fan_entry = str_replace( '$$fan_email_plain$$',
				$fan_email_plain, $fan_entry );
			$fan_entry = str_replace( '$$fan_country$$',
				$fan_country, $fan_entry );
			$fan_entry = str_replace( '$$fan_email$$', $fan_email,
				$fan_entry );
			$fan_entry = str_replace( '$$fan_url$$', $fan_url,
				$fan_entry );
			$fan_entry = str_replace( '$$fan_url_plain$$',
				$fan_url_plain, $fan_entry );

			if( $additional_field ) {
				$field_num = count( $additional_field_names );
				$i = 0;
				while( $i < $field_num ) {
					$fan_entry = str_replace( '$$fan_' .
						$additional_field_names[$i] .
						'$$',
						$$additional_field_names[$i],
						$fan_entry );
					$i++;
					}
				}
			echo $fan_entry;

			}
		else {
			echo '<p><b>' . $fan_name . '</b><br />';
			if( $fan_country )
				echo $fan_country . '<br />';
			echo 'Email: ' . $fan_email . '<br />';
			echo 'Website: ' . $fan_url . '<br />';

			if( $additional_field ) {
				$field_num = count( $additional_field_names );
				$i = 0;
				while( $i < $field_num ) {
					if( $$additional_field_names[$i] &&
					( ( $additional_field_names[$i] ==
					$fl_sort && $sort_by == 'all' ) ||
					( $additional_field_names[$i] ==
					$fl_sort && $show_sort_field ) ||
					$additional_field_names[$i] !=
					$fl_sort ) )
						echo ucfirst(
						$additional_field_names[$i] ) .
							': ' .
						$$additional_field_names[$i] .
							'<br />';
					$i++;
					}
				}
	                echo '</p>';
			}

		} // end while

	@include 'listfooter.inc.php';

	if( $fan_num > $fans_per_page ) {
		// check for what kind of list URL
		$connector = '?';
		if( substr_count( $list_url, '?' ) > 0 )
			$connector = '&amp;';

		echo '<p>Go to page: ';
		$page = 1;
		$show = 0;
		while( $show < $fan_num ) {
			echo '<a href="' . $list_url . $connector . $fl_sort .
				'=' . $sort_by . '&amp;start=' . $show . '">' .
				$page . '</a> ';
			$show = $show + $fans_per_page;
			$page++;
			}
		echo '</p>';
		} // end if $fan_num < $fans_per_page

	} // end if there is a sort criteria
?>