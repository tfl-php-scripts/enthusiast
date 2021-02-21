<?php
declare(strict_types = 1);

/*****************************************************************************
 * Enthusiast: Listing Collective Management System
 * Copyright (c) 2021 by Ekaterina http://scripts.robotess.net
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

use RobotessNet\StringUtils;

require_once 'config.php';

require_once('mod_errorlogs.php');
require_once('mod_owned.php');
require_once('mod_members.php');
require_once('mod_settings.php');

if (!isset($listing)) {
    echo '!! You haven\'t set $listing variable in config.php. Please set it first - the instruction is at the end of the file.<br/>';

    return;
}

// get listing info, start pagination at what index, and member type
$info = get_listing_info($listing);
$start = (isset($_REQUEST['start']) && ctype_digit($_REQUEST['start']))
    ? $_REQUEST['start'] : '0';
$member_type = ($info['listingtype'] == 'fanlisting') ? 'fans' : 'members';
$member_type_singular = ($info['listingtype'] == 'fanlisting') ? 'fan' : 'member';

function robotess_nEnding($number, $singularWord, $multiWord = null): string
{
    if ((int)$number <= 1) {
        return $number . ' ' . $singularWord;
    }

    return $number . ' ' . ($multiWord ?? $singularWord . 's');
}

function robotess_showFansInCountries(int $members, int $countries, String $member)
{
    echo '<p class="stats"><span class="n_members">' . robotess_nEnding($members,
            $member) . '</span> from <span class="n_country">' . robotess_nEnding($countries, 'country',
            'countries') . '</span></p>' . "\r\n";
}

function robotess_showFansInCountry(int $members, String $country, String $member)
{
    echo '<p class="stats"><span class="n_members">' . robotess_nEnding($members,
            $member) . '</span> from <span class="current_country">' . $country . '</span></p>' . "\r\n";
}

function robotess_printFansFromCountries(array $info, string $member_type_singular): array
{
    $countries = getCountries($info);
    $total = $countries['0'];
    unset($countries['0']);

    robotess_showFansInCountries($total, count($countries), $member_type_singular);

    return $countries;
}

if (isset($_GET['list']) && RobotessNet\StringUtils::instance()
                                                   ->clean($_GET['list']) === 'countries') {

    echo '<p class="show_sort_links"><a href="' . $info['listpage'] . '">All ' . $member_type . '</a> <span class="separator">//</span> By Country</p>';

    $countries = robotess_printFansFromCountries($info, $member_type_singular);

    echo '<table>' . "\r\n";
    foreach ($countries as $country => $count) {
        echo '<tr class="show_country_with_count"><td><a href="' . $info['listpage'] . '?country=' . $country . '">' . $country . '</a></td><td>' . robotess_nEnding($count,
                $member_type_singular) . '</td></tr>' . "\r\n";
    }
    echo '</table>' . "\r\n";

    return;
}

function robotess_showAllMembersOrCountriesList($member_type, $link)
{
    echo '<p class="show_sort_links"><a href="' . $link . '">All ' . $member_type . '</a> <span class="separator">//</span> <a href="' . $link . '?list=countries">By Country</a></p>';
}

robotess_showAllMembersOrCountriesList($member_type, $info['listpage']);

// get selected members (selection is from $_GET array)
$members = [];
$total = 0;

// get sorting criteria
$sort = ['country'];
foreach ($sort as $i => $s) {
    $sort[$i] = trim($s);
}
$sortarray = [];
$sortselectednum = 0;

// find out how to sort members
foreach ($sort as $s) {
    if (!$s) {
        continue;
    } // blank, skip this
    if (isset($_GET[$s])) { // if the field is set
        if ($_GET[$s] == 'all') // if "all", use wildcard
        {
            $sortarray[$s] = '%';
        } else {
            $sortarray[$s] = RobotessNet\StringUtils::instance()
                                                    ->clean($_GET[$s]);
        }
        $sortselectednum++;
    } else // use wildcard
    {
        $sortarray[$s] = '%';
    }
}

function robotess_noSortByCountry(): bool
{
    return !isset($_GET['country']) || $_GET['country'] == 'all' || $_GET['country'] == '';
}

$members = get_members($listing, 'approved', $sortarray, $start);
$total = count(get_members($listing, 'approved', $sortarray));

$countCurrentPage = count($members);
// pagination schtuff now
$page_qty = $total / $info['perpage'];

ob_start();
?>
    <table>
        <tr>
            <td>Name</td>
            <?php if (robotess_noSortByCountry()) { ?>
                <td>Country</td><?php } ?>
            <td>Website</td>
        </tr>
        <?php
        // show the actual members list now
        // parse list template
        foreach ($members as $mem) {
            $template = $info['listtemplate'];

            // set name
            $formatted = str_replace('$$fan_name$$', sprintf("<td>%s</td>", $mem['name']), $template);

            // set country
            if (!in_array('country', $sort) || (isset($show_sort_field) &&
                    $show_sort_field)) {
                // if country is not set a sorting field
                // or you wanna show the fields anyway
                $formatted = str_replace('$$fan_country$$', sprintf("<td>%s</td>", $mem['country']),
                    $formatted);
            } elseif (robotess_noSortByCountry()) {
                // or you're showing all countries
                $formatted = str_replace('$$fan_country$$', sprintf("<td>%s</td>", $mem['country']),
                    $formatted);
            } else {
                // hide it
                $formatted = str_replace('$$fan_country$$', '', $formatted);
            } // end setting of country

            // set additional fields
            foreach (explode(',', $info['additional']) as $field) {
                if ($field != '') {
                    if (!in_array($field, $sort) ||
                        (isset($show_sort_field) && $show_sort_field)) {
                        // you're not sorting by this, or you will show it anyway
                        $formatted = @str_replace('$$fan_' . $field . '$$',
                            sprintf("<td>%s</td>", $mem[$field]), $formatted);
                    } elseif ($_GET[$field] == 'all' ||
                        ((!isset($_GET[$field]) || $_GET[$field] == '') &&
                            isset($no_sort))) {
                        $formatted = @str_replace('$$fan_' . $field . '$$',
                            sprintf("<td>%s</td>", $mem[$field]), $formatted);
                    } else {
                        $formatted = @str_replace('$$fan_' . $field . '$$', '',
                            $formatted);
                    }
                }
            }

            if ($mem['showurl'] == 0 || $mem['url'] == '') {
                // there is no url, or owner doesn't want this url shown
                $url_generic = '<span style="text-decoration: ' .
                    'line-through;" class="show_members_no_website">www</span>';
            } else {
                // show the url
                $target = ($info['linktarget'])
                    ? 'target="' . $info['linktarget'] . '" '
                    : '';
                $url_generic = '<a href="' . $mem['url'] . '" ' . $target .
                    'class="show_members_website">www</a>';
            }

            $formatted = str_replace('$$fan_url_generic$$', sprintf("<td>%s</td>", $url_generic), $formatted);

            // echo the formatted template
            echo '<tr>'.$formatted.'</tr>';
        }
        ?>
    </table>
<?php

// create the URL for pagination
$url = substr(strrchr($_SERVER['PHP_SELF'], '/'), 1);
$connector = '?';
foreach ($_GET as $key => $value) {
    if ($key != 'start' && $key != 'PHPSESSID') {
        $url .= $connector . StringUtils::instance()
                                        ->clean($key) . '=' . StringUtils::instance()
                                                                         ->clean($value);
        $connector = '&amp;';
    }
}

// show actual pagination now
if ($page_qty > 1) {
    echo '<p class="show_members_pagination">Go to page: ';
    $i = 1;
    while (($i <= $page_qty + 1) && $page_qty > 1) {
        $start_link = ($i - 1) * $info['perpage'];
        echo '<a href="' . $url . $connector . 'start=' . $start_link . '">' .
            $i . '</a> ';
        $i++;
    }
    echo '</p>';
}

$content = ob_get_clean();

if(robotess_noSortByCountry()) {
    robotess_printFansFromCountries($info, $member_type_singular);
} else {
    robotess_showFansInCountry($total, $sortarray['country'], $member_type_singular);
}

echo $content;