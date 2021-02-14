<?php
declare(strict_types = 1);

/*****************************************************************************
 * Enthusiast: Listing Collective Management System
 * Copyright (c) by Angela Sabas http://scripts.indisguise.org/
 * Copyright (c) 2018 by Lysianthus (contributor) <she@lysianth.us>
 * Copyright (c) 2019 by Ekaterina (contributor) http://scripts.robotess.net
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

use RobotessNet\JoinFl\Form;
use RobotessNet\JoinFl\Handler;
use RobotessNet\StringUtils;

require 'config.php';

require_once('mod_errorlogs.php');
require_once('mod_owned.php');
require_once('mod_members.php');
require_once('mod_settings.php');
require_once('mod_emails.php');

$install_path = get_setting('installation_path');
require_once($install_path . 'Mail.php');

// get listing information

if (!isset($listing)) {
    echo '!! You haven\'t set $listing variable in config.php. Please set it first - the instruction is at the end of the file.<br/>';

    return;
}

$info = get_listing_info($listing);

// initialize variables
$show_form = true;
$errorstyle = ' style="font-weight: bold; display: block;" ' .
    'class="show_join_error"';
//todo info about
$countriesValues = include 'countries.inc.php';
$additional = $info['additional'];
$fields = explode(',', $additional);
if ($fields[0] == '') {
    array_pop($fields);
}
$values = [];
if (count($fields) > 0) {
    foreach ($fields as $field) {
        $values[$field] = '';
        if (isset($_POST["enth_$field"])) {
            $values[$field] = StringUtils::instance()
                                         ->clean($_POST["enth_$field"]);
        } elseif (isset($_POST[$field])) {
            $values[$field] = StringUtils::instance()
                                         ->clean($_POST[$field]);
        }
    }
}

$formClass = $formClass ?? RobotessNet\JoinFl\Form::class;

if (isset($_POST['enth_join']) && $_POST['enth_join'] == 'yes') {
    $handler = new Handler();
    $success = $handler->process($_POST, $errorstyle, $countriesValues, $info, $fields, $values, $listing);
    if (!$success && $handler->isShowForm()) {
        $form = new $formClass();
        $form->print($info, $errorstyle, $countriesValues, $fields, $values, $handler->getMessages(), $handler->getEmail(), $handler->getName(), $handler->getUrl(), $handler->getCountry(), $handler->getComments(), $handler->getCountryId());

        return;
    }

    return;
}

foreach ($fields as $ind => $val) {
    $fields[$ind] = stripslashes($val);
}
$form = new $formClass();
$form->print($info, $errorstyle, $countriesValues, $fields, $values);