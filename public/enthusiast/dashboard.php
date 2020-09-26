<?php
/*****************************************************************************
 * Enthusiast: Listing Collective Management System
 * Copyright (c) by Angela Sabas http://scripts.indisguise.org/
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
session_start();

require_once('logincheck.inc.php');
if (!isset($logged_in) || !$logged_in) {
    $_SESSION['message'] = 'You are not logged in. Please log in to continue.';
    $next = '';
    if (isset($_SERVER['REQUEST_URI'])) {
        $next = $_SERVER['REQUEST_URI'];
    } elseif (isset($_SERVER['PATH_INFO'])) {
        $next = $_SERVER['PATH_INFO'];
    }
    $_SESSION['next'] = $next;
    header('location: index.php');
    die('Redirecting you...');
}

require_once('header.php');
require('config.php');
require_once('mod_categories.php');
require_once('mod_joined.php');
require_once('mod_owned.php');
require_once('mod_affiliates.php');
require_once('mod_settings.php');
require_once('mod_errorlogs.php');

?>
    <h1>Enthusiast version and server info</h1>

    <p>You are currently using Enthusiast <?= RobotessNet\App::getVersion() ?>. Please make sure you
        always keep your script up-to-date. Link to the latest version is available on
        <a href="https://scripts.robotess.net/projects/enthusiast" target="_blank"
           title="PHP Script Enthusiast ported to PHP7">project's page</a>.</p>

    <h2>Server info (useful for debugging and reporting issues)</h2>
    <p>When you're asking for help with the script, please share the following information:</p>
    <p class="enth-version">Enthusiast: <?= RobotessNet\App::getVersion() ?></p>
    <p>PHP: <?= PHP_VERSION ?></p>
    <p>Please also attach the whole <a href="errorlog.php">error log</a>.</p>

    <h1>You are managing: <?= get_setting('collective_title') ?></h1>
<?php
$today = date('F j, Y (l)');
if (date('a') === 'am') {
    $greeting = 'Good morning';
} elseif (date('G') <= 18) {
    $greeting = 'Good afternoon';
} else {
    $greeting = 'Good evening';
}
?>
    <p><?= $greeting ?>! Today is <?= $today ?>.</p>

    <h2>Collective statistics:</h2>

<?php
require_once('show_collective_stats.php');
?>
    <table class="stats">

        <tr>
            <td class="right">
                Number of categories:
            </td>
            <td>
                <?= $total_cats ?>
            </td>
        </tr>

        <tr>
            <td class="right">
                Number of joined listings:
            </td>
            <td>
                <?= $joined_approved ?> approved, <?= $joined_pending ?> pending
            </td>
        </tr>

        <tr>
            <td class="right">
                Number of owned listings:
            </td>
            <td>
                <?= $owned_current ?> current, <?= $owned_upcoming ?>
                upcoming, <?= $owned_pending ?> pending
            </td>
        </tr>

        <tr>
            <td class="right">
                Number of collective affiliates:
            </td>
            <td>
                <?= $affiliates_collective ?> affiliates
            </td>
        </tr>

        <tr>
            <td class="right">
                Newest owned listing
            </td>
            <td>
                <?php
                if (count($owned_newest) > 0) {
                    ?>
                    <a href="<?= $owned_newest['url'] ?>"><?= $owned_newest['title']
                        ?>: the <?= $owned_newest['subject'] ?> <?= $owned_newest['listingtype']
                        ?></a>
                    <?php
                } else {
                    echo 'None';
                }
                ?>
            </td>
        </tr>

        <tr>
            <td class="right">
                Newest joined listing
            </td>
            <td>
                <?php
                if (count($joined_newest) > 0) {
                    ?>
                    <a href="<?= $joined_newest['url'] ?>"><?= $joined_newest['subject'] ?></a>
                    <?php
                } else {
                    echo 'None';
                }
                ?>
            </td>
        </tr>

        <tr>
            <td class="right">
                Total members in collective:
            </td>
            <td>
                <?= $collective_total_fans_approved ?> (<?= $collective_total_fans_pending ?> pending)
            </td>
        </tr>

        <tr>
            <td class="right">
                Collective members growth rate:
            </td>
            <td>
                <?= $collective_fans_growth_rate ?> members/day
            </td>
        </tr>

    </table>

<?php
$owned = get_owned('current');
$header = true;
foreach ($owned as $id) {
    $info = get_listing_info($id);
    $stats = get_listing_stats($id);

    // now check $lastupdated -- if more than 8 weeks ago, notify!
    $weeks = 0;
    if ($stats['lastupdated'] && date('Y') != date('Y', strtotime($stats['lastupdated']))) {
        $weeks = (52 - date('W', strtotime($stats['lastupdated']))) + date('W');
    } elseif ($stats['lastupdated']) {
        $weeks = date('W') - date('W', strtotime($stats['lastupdated']));
    }

    if ($stats['lastupdated'] == '' || // no last updated date
        $weeks >= 8) {
        if ($header) {
            ?>
            <h2>Neglected Listings Notification</h2>
            <p>The following listings have gone on two months without a
                newly-approved member or a new/updated affiliate!</p>
            <ul>
            <?php
            $header = false;
        }
        // prepare date format
        $readable = @date(get_setting('date_format'),
            strtotime($stats['lastupdated']));
        echo '<li> ';
        if ($info['title']) {
            echo $info['title'];
        } else {
            echo $info['subject'];
        }
        echo ", last updated $readable;<br />manage ";
        echo '<a href="members.php?id=' . $info['listingid'] .
            '">members</a>';
        if ($info['affiliates'] == 1) // don't show if affiliates aren't enabled
        {
            echo ' or <a href="affiliates.php?listing=' .
                $info['listingid'] . '">affiliates</a>';
        }
        echo '?</li>';
    }
}
echo '</ul>';

echo '<h1>Enthusiast Updates</h1>';

function tryReadingFeedFromCache(string $cacheFileName): string
{
    if (!file_exists($cacheFileName)) {
        return 'Could not load updates from remote server and cache file does not exist';
    }

    return file_get_contents($cacheFileName);
}
/**
 * @param $cacheFileName
 * @param $posts
 */
function tryWritingToCache($cacheFileName, $posts)
{
    if (!file_exists($cacheFileName)) {
        return;
    }

    $cacheFile = fopen($cacheFileName, 'wb');
    if ($cacheFile === false) {
        return;
    }
    fwrite($cacheFile, $posts);
    fclose($cacheFile);
}

function printUpdates()
{
    $updatesFeedUrl = 'https://scripts.robotess.net/projects/enthusiast/atom.xml';
    $cachefilename = 'cache/updates';
    $posts = '';

    $doc = new DOMDocument();
    $success = $doc->load($updatesFeedUrl, LIBXML_ERR_ERROR);
    if (!$success) {
        echo tryReadingFeedFromCache($cachefilename);

        return;
    }

    $domChannel = $doc->getElementsByTagName('channel');
    if (count($domChannel) !== 1) {
        // nothing here..
        return;
    }

    /** @var DOMElement $node */
    $current = 1;
    $maxItems = 3;
    foreach ($domChannel->item(0)
                        ->getElementsByTagName('item') as $node) {
        $title = $node->getElementsByTagName('title')
                      ->item(0)->nodeValue;
        $link = $node->getElementsByTagName('link')
                     ->item(0)->nodeValue;
        $pubdate = $node->getElementsByTagName('pubDate')
                        ->item(0)->nodeValue;
        $description = $node->getElementsByTagName('description')
                            ->item(0)->nodeValue;

        $timestamp = strtotime($pubdate);
        $daylong = date('l', $timestamp);
        $monlong = date('F', $timestamp);
        $yyyy = date('Y', $timestamp);
        $dth = date('jS', $timestamp);
        $min = date('i', $timestamp);
        $_24hh = date('H', $timestamp);

        $posts .= <<<MARKUP
                <h2>{$title}<br />
                <small>{$daylong}, {$dth} {$monlong} {$yyyy}, {$_24hh}:{$min} &bull; <a href="{$link}" target="_blank">permalink</a></small></h2>
                <blockquote>{$description}</blockquote>
MARKUP;

        if ($current++ >= $maxItems) {
            break;
        }
    }

    // try caching this now
    tryWritingToCache($cachefilename, $posts);

    echo $posts;
}

printUpdates();

require_once('footer.php');
