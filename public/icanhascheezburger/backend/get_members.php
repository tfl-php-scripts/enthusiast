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
function get_members( $email, $name, $country, $url, $extra, $pending,
	$date_day, $date_month, $date_year, &$count ) {

	require( 'config.inc.php' );
	// create SQL query
	$sql_query = "SELECT * FROM `$db_table`";
	$criteria = '';

	if( $email ) {
		$email_criteria = " `email` LIKE '%$email%'";
		if( $criteria )
			$criteria .= " AND $email_criteria";
		else
			$criteria = $email_criteria;
		}

	if( $name ) {
		$name_criteria = ' `name` LIKE "%' . $name . '%"';
		if( $criteria )
			$criteria .= ' AND' . $name_criteria;
		else
			$criteria = $name_criteria;
		}

	if( $country ) {
		$country_criteria = ' `country` LIKE "%' . $country . '%"';
		if( $criteria )
			$criteria .= ' AND' . $country_criteria;
		else
			$criteria = $country_criteria;
		}

	if( $url ) {
		$url_criteria = ' `url` LIKE "%' . $url . '%"';
		if( $criteria )
			$criteria .= ' AND' . $url_criteria;
		else
			$criteria = $url_criteria;
		}

	if( $extra ) {
		$extra_criteria = ' `' . $additional_field_name . '` LIKE "%' .
			$extra . '%"';
		if( $criteria )
			$criteria .= ' AND' . $extra_criteria;
		else
			$criteria = $extra_criteria;
		}

	if( $pending == 0 || $pending == 1 ) {
		$pending_criteria = " pending = '$pending'";
		if( $criteria )
			$criteria .= ' AND' . $pending_criteria;
		else
			$criteria = $pending_criteria;
		}

	if( $date_day ) {
		$date_day_criteria = " DAYOFMONTH( date ) = '$date_day'";
		if( $criteria )
			$criteria .= ' AND' . $date_day_criteria;
		else
			$criteria = $date_day_criteria;
		}

	if( $date_month ) {
		$date_month_criteria = " MONTH( date ) = '$date_month'";
		if( $criteria )
			$criteria .= ' AND' . $date_month_criteria;
		else
			$criteria = $date_month_criteria;
		}

	if( $date_year ) {
		$date_year_criteria = " YEAR( date ) = '$date_year'";
		if( $criteria )
			$criteria .= ' AND' . $date_year_criteria;
		else
			$criteria = $date_year_criteria;
		}

	if( $criteria ) {
		$sql_query .= ' WHERE' . $criteria;
		}
	$sql_query .= ' ORDER BY `email` ASC';

	// connect to the database using config file
	$db_link = mysql_connect( $db_server, $db_user, $db_password )
		or die( 'Cannot connect to the MySQL server: ' .
			mysql_error() );
	mysql_select_db( $db_database )
		or die( 'Cannot select database: ' . mysql_error() );

	// get results
	$result_set = mysql_query( $sql_query )
		or die( 'Cannot execute query: ' . mysql_error() );
	$member_array = array();
	while( $row = mysql_fetch_array( $result_set ) )
		$member_array[] = $row;

	$sql_query = str_replace( '*', 'COUNT( email ) AS num', $sql_query );
	$result_num = mysql_query( $sql_query )
		or die( 'Cannot execute query: ' . mysql_error() );
	$row = mysql_fetch_array( $result_num );
	$count = $row["num"];
	
	// free resources
	mysql_free_result( $result_set );
	mysql_free_result( $result_num );
	mysql_close( $db_link );
	
	// return value
	return $member_array;
	}
?>