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
require_once( $backend_dir . 'get_affiliates.php' );

$affiliate_array = get_affiliates();

foreach( $affiliate_array as $aff ) {

	// show text if there is no images
	if( !isset( $aff["imagepath"] ) || $aff["imagepath"] == '' )  {

		if( !isset( $spacer ) )
			$spacer = '<br />';

		if( !isset( $link_target ) )
			$link_target = '_top';

		echo '<a href="' . $aff["url"] . '" target="' .
			$link_target . '">' . $aff["title"] .
			'</a>' . $spacer;
		}

	else {

		if( !isset( $spacer ) )
			$spacer = ' ';

		if( !isset( $link_target ) )
			$link_target = '_top';

		echo '<a href="' . $aff["url"] . '" target="' .
			$link_target . '">' .
			'<img src="' . $aff["imagepath"] .
			'" width="' . $aff["width"] .
			'" height="' . $aff["height"] .
			'" border="0" alt=" ' . $aff["title"] . '" /></a>' .
			$spacer;
		}
	}
?>