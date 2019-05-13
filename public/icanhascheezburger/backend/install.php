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
require_once( 'header.inc.php' );
require_once( 'config.inc.php' );
?>

<p class="location">Enthusiast > Create database table</p>

<?php

if( isset( $_GET["done"] ) ) {
	$query = 'CREATE TABLE `' . $db_table . '` (' .
		'`email` varchar(64) NOT NULL default \'\', ' .
		'`name` varchar(128) NOT NULL default \'\', ';
	if( !isset( $disable_country ) || !$disable_country )
		$query .= '`country` varchar(128) NOT NULL default \'\', ';
	$query .= '`url` varchar(254) default NULL, ';
	if( $additional_field ) {
		foreach( $additional_field_names as $field ) {
			$query .= '`' . $field . '` varchar(255) ' .
				'default NULL, ';
			}
		}
	$query .= '`pending` tinyint(1) NOT NULL default \'0\', ' .
		'`password` varchar(128) NOT NULL default \'\', ' .
		'`showemail` tinyint(1) NOT NULL default \'1\', ' .
		'`showurl` tinyint(1) NOT NULL default \'1\', ' .
		'`added` date default NULL, ' .
		'PRIMARY KEY  (`email`) ' .
		') TYPE=MyISAM;';

	$db_link = mysql_connect( $db_server, $db_user, $db_password )
		or die( 'Cannot connect to the MySQL server: ' .
			mysql_error() );
	mysql_select_db( $db_database )
		or die( 'Cannot select database: ' . mysql_error() );
	$result = mysql_query( $query )
		or die( 'Cannot execute query: ' . mysql_error() );

	if( $result ) {
		echo '<p><b>Database table created successfully.</b></p>';
		}
	else {
		echo '<p><b>There was an error creating the table.' .
			' Please try again.</b></p>';
		}

	// check if affiliates are enabled
	if( isset( $enable_affiliates ) && $enable_affiliates ) {

		// create affiliates table
		$query = 'CREATE TABLE `' . $db_table . '_affiliates` (' .
			'`affiliateid` int(5) NOT NULL auto_increment, ' .
			'`url` varchar(254) NOT NULL default \'\', ' .
			'`title` varchar(254) NOT NULL default \'\', ' .
			'`imagepath` varchar(254) default NULL, ' .
			'`width` int(3) default NULL, ' .
			'`height` int(3) default NULL, ' .
			'PRIMARY KEY  (`affiliateid`) ' .
			') TYPE=MyISAM AUTO_INCREMENT=1 ;';

		$result = mysql_query( $query )
			or die( 'Cannot execute query: ' . mysql_error() );

		if( $result ) {
		echo '<p><b>Affiliates database table created ' .
			'successfully.</b></p>';
			}
		else {
			echo '<p><b>There was an error creating the ' .
			'affiliates table. Please try again.</b></p>';
			}
		}

	echo '<p>Delete the install.php file after creating the tables ' .
		'to ensure your security.</p>';

	}
else {
?>

	<p>
	You can automatically create your database table via this page.<br />
	<b>Please make sure that you have edited your config.inc.php file
	before<br />
	doing this. Refer to the table below.</b>
	</p>

	<p><table>

	<tr><td>
	$db_server
	</td><td>
	Usually "localhost", please refer to your host if otherwise.
	</td></tr>

	<tr><td>
	$db_user
	</td><td>
	Username to connect to the database
	</td></tr>

	<tr><td>
	$db_password
	</td><td>
	Password to connect to the database
	</td></tr>

	<tr><td>
	$db_database
	</td><td>
	Database name the FL table will be created in;<br />
	MUST ALREADY EXIST before this script is continued<br />
	(refer to your host on how to create a database)
	</td></tr>

	<tr><td>
	$db_table
	</td><td>
	The table name for your database;<br />
	e.g., if your <?= $listing_type ?> is for computers,<br />
	it would be "computers".
	</td></tr>

	<tr><td>
	$additional_field
	</td><td>
	If you want an extra, customized field for your FL,<br />
	you should set this to "true".
	</td></tr>

	<tr><td>
	$additional_field_names[]
	</td><td>
	Create a new line with each additional field name (no spaces), i.e.:
	<br /><i>$additional_field_names[] = 'character';<br />
	$additional_field_names[] = 'scene';</i>
	</td></tr>

	</table></p>

	<br />

	<p><b>If you're done editing your config.inc.php file, click the
	button below.</b></p>

	<form action="<?= $_SERVER["PHP_SELF"] ?>" method="get">
	<input type="hidden" name="done" />
	<input type="submit" value="Create my FL Table" />
	</form>

<?php
	}
require_once( 'footer.inc.php' );
?>