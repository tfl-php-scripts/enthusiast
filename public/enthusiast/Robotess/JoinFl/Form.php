<?php
declare(strict_types = 1);
/*****************************************************************************
 * Enthusiast: Listing Collective Management System
 * Copyright (c) by Ekaterina http://scripts.robotess.net
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

namespace RobotessNet\JoinFl;

use RobotessNet;
use function explode;
use function md5;
use function uniqid;

final class Form
{
    public function print(
        array $info,
        string $errorstyle,
        array $countriesValues,
        array $fields,
        array $values,
        array $messages = [],
        ?string $email = null,
        ?string $name = null,
        ?string $url = null,
        ?string $country = null,
        ?string $comments = null,
        ?int $countryId = null
    ): void {

        $cutup = explode('@', $info['email']);
        if ($cutup === false) {
            $email_js = $info['email'];
        } else {
            $email_js = '<script type="text/javascript">' . "\r\n<!--\r\n" .
                "jsemail = ( '$cutup[0]' + '@' + '$cutup[1]' ); \r\n" .
                "document.write( '<a href=\"mailto:' + jsemail + '\">email me</' + " .
                "'a>' );\r\n" . ' -->' . "\r\n" . '</script>';
        }

        // extra spam checking variable
        $rand = md5(uniqid('', true));

        ob_start();
        ?>
        <!-- Enthusiast <?= RobotessNet\App::getVersion() ?> Join Form -->
        <p class="show_join_intro">Please use the form below for joining the
            <?= $info['listingtype'] ?>. <b>Please hit the submit button only once.</b>
            Your entry is fed instantly into the database, and your email address is
            checked for duplicates. Passwords are encrypted into the database and will
            not be seen by anyone else other than you. If left blank, a password will
            be generated for you.</p>

        <p class="show_join_intro_problems">If you encounter problems, please
            feel free to <?= $email_js ?>.</p>

        <p class="show_join_intro_required">The fields with asterisks (*) are
            required fields.</p>

        <?php
        if (isset($messages['form'])) {
            echo "<p$errorstyle>{$messages['form']}</p>";
        }
        ?>
        <form method="post" action="<?= $info['joinpage'] ?>"
              class="show_join_form">

            <p class="show_join_name">
                <input type="hidden" name="enth_join" value="yes"/>
                <input type="hidden" name="enth_nonce"
                       value="<?= $rand ?>:<?= strtotime(date('r')) ?>:<?= md5($rand) . substr($rand, 2, 3) ?>"/>
                <span style="display: block;" class="show_join_name_label">* Name: </span>
                <?php
                if (isset($messages['name'])) {
                    echo "<span$errorstyle>{$messages['name']}</span>";
                }
                ?>
                <input type="text" name="enth_name" value="<?= $name ?>" required
                       class="show_join_name_field"/>
            </p>

            <p class="show_join_email">
   <span style="display: block;" class="show_join_email_label">* Email
   address: </span>
                <?php
                if (isset($messages['email'])) {
                    echo "<span$errorstyle>{$messages['email']}</span>";
                }
                ?>
                <input type="email" name="enth_email" value="<?= $email ?>" required
                       class="show_join_email_field"/>
            </p>

            <p class="show_join_email_settings">
   <span style="display: block;" class="show_join_email_settings_label">Show
   email address on the list? </span>
                <span style="display: block" class="show_join_email_settings_yes">
   <input type="radio" name="enth_show_email" value="1"
          class="show_join_email_settings_field" checked="checked"/>
      <span class="show_join_email_settings_field_label">
      Yes (SPAM-protected on the site)</span>
   </span><span style="display: block" class="show_join_email_settings_no">
   <input type="radio" name="enth_show_email" value="0"
          class="show_join_email_settings_field"/>
      <span class="show_join_email_settings_field_label">No</span>
   </span>
            </p>

            <?php
            if ($info['country'] == 1) {
                ?>
                <p class="show_join_country">
      <span style="display: block;" class="show_join_country_label">*
      Country</span>
                    <?php
                    if (isset($messages['country'])) {
                        echo "<span$errorstyle>{$messages['country']}</span>";
                    }
                    ?>
                    <select name="enth_country" class="show_join_country_field" required>
                        <?php
                        foreach ($countriesValues as $key => $countryVal) {
                            $selected = '';
                            if ($country !== '' && $countryId === $key) {
                                $selected = ' selected="selected"';
                            }
                            echo '<option value="' . $key . '"' . $selected . '>' . $countryVal . '</option>';
                        }
                        ?>
                    </select>
                </p>
                <?php
            }
            ?>
            <p class="show_join_password">
   <span style="display: block;" class="show_join_password_label">Password
   (to change your details; type twice):</span>
                <?php
                if (isset($messages['password'])) {
                    echo "<span$errorstyle>{$messages['password']}</span>";
                }
                ?>
                <input type="password" name="enth_password" class="show_join_password_field"/>
                <input type="password" name="enth_vpassword" class="show_join_password_field2"/>
            </p>

            <p class="show_join_url">
   <span style="display: block;" class="show_join_url_label">Website
   URL:</span>
                <input type="url" name="enth_url" value="<?= $url ?>"
                       class="show_join_url_field"/>
            </p>
            <?php
            if (count($fields) > 0 && !(file_exists('addform.inc.php'))) {
                foreach ($fields as $field) {
                    ?>
                    <p class="show_join_<?= $field ?>">
         <span style="display: block;" class="show_join_<?= $field ?>_label">
         <?= ucwords(str_replace('_', ' ', $field)) ?>:</span>
                        <input type="text" name="enth_<?= $field ?>" value="<?= $values[$field]
                        ?>" class="show_join_<?= $field ?>_field"/>
                    </p>
                    <?php
                }
            } elseif (count($fields) > 0 && file_exists('addform.inc.php')) {
                require('addform.inc.php');
            }
            ?>
            <p class="show_join_comments">
   <span style="display: block;" class="show_join_comments_label">
   Comments: </span>
                <textarea name="enth_comments" rows="3" cols="40"
                          class="show_join_comments_field"><?= $comments ?></textarea>
            </p>

            <p class="show_join_submit">
   <span style="display: block;" class="show_join_send_account_info">
   <input type="checkbox" name="enth_send_account_info" value="yes"
          checked="checked" class="enth_show_join_send_account_info_field"/>
   <span class="show_join_send_account_info_label">
   Yes, send me my account information!</span>
   </span>
                <input type="submit" value="Join the <?= $info['listingtype'] ?>"
                       class="show_join_submit_button"/>
                <input type="reset" value="Clear form" class="show_join_reset_button"/>
            </p>

        </form>

        <!--// do not remove the credit link please-->
        <p style="text-align: center;" class="show_join_credits">
            <?php include ENTH_PATH . 'show_credits.php' ?>
        </p>
        <?php
        echo ob_get_clean();
    }
}
