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
for( $start = 1970; $start <= date( 'Y' ); $start++ ) {
	if( $start == date( 'Y' ) )
		echo '<option value="' . $start .
			'" selected="selected">' . $start . '</option>';
	else
		echo '<option value="' . $start . '">' . $start .
			'</option>';
	}
?>