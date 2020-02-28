<?php
/*****************************************************************************
 * Enthusiast: Listing Collective Management System
 * Copyright (c) 2019 by Ekaterina http://scripts.robotess.net
 *
 * Enthusiast is a tool for (fan)listing collective owners to easily
 * maintain their listing collectives and listings under that collective.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * For more information please view the readme.txt file.
 ******************************************************************************/
if(!isset($currentVersion)) {
    try {
        if (file_exists(ENTH_PATH . 'show_enthversion.php')) {
            ob_start();
            include ENTH_PATH . 'show_enthversion.php';
            $currentVersion = ob_get_clean();
        }
    } finally {
        // nothing.
    }
}
?>
Powered by <a href="https://scripts.robotess.net" target="_blank" title="PHP Scripts: Enthusiast, Siteskin, Codesort - ported to PHP 7">
    Enthusiast <?= $currentVersion ?? 'v. Unknown' ?> for PHP 7</a>
(original author: <a href="http://scripts.indisguise.org" target="_blank">Angela Sabas</a>)
