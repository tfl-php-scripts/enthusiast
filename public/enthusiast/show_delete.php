<?php
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

namespace RobotessNet\DeleteYourself {

    use function RobotessNet\cleanNormalize;
    use function RobotessNet\clean;

    require 'config.php';

    require_once('mod_errorlogs.php');
    require_once('mod_owned.php');
    require_once('mod_members.php');
    require_once('mod_settings.php');

    $info = get_listing_info($listing);
    $errorstyle = ' style="font-weight: bold; display: block;" ' .
        'class="show_update_error"';

    class Handler
    {
        /**
         * @var bool
         */
        private $showForm = false;

        /**
         * @var string
         */
        private $responseMessage = '';

        /**
         * @var string
         */
        private $cleanEmail = '';

        /**
         * @param int $listing
         * @param array $postData
         * @param array $listingInfo
         * @param string $errorstyle
         * @return bool successful
         */
        public function handle(int $listing, array $postData, array $listingInfo, string $errorstyle): bool
        {
            // do some spam/bot checking first
            $goahead = false;
            $badStrings = array('Content-Type:',
                'MIME-Version:',
                'Content-Transfer-Encoding:',
                'bcc:',
                'cc:',
                'content-type',
                'onload',
                'onclick',
                'javascript');
            // 1. check that user is submitting from browser
            // 2. check the POST was indeed used
            // 3. no bad strings in any of the form fields
            if (isset($_SERVER['HTTP_USER_AGENT']) &&
                $_SERVER['REQUEST_METHOD'] === 'POST') {
                foreach ($postData as $k => $v) {
                    foreach ($badStrings as $v2) {
                        if (strpos($v, $v2) !== false) {
                            echo "<p$errorstyle>Bad strings found in form.</p>";
                            return false;
                        }
                    }
                }
                $goahead = true;
            }

            if (!$goahead) {
                echo "<p$errorstyle>ERROR: Attempted circumventing of the form detected.</p>";
                return false;
            }

            // check nonce field
            $nonce = explode(':', clean($postData['enth_nonce']));
            $mdfived = substr($nonce[2], 0, (strlen($nonce[2]) - 3));
            $appended = substr($nonce[2], -3);

            // check the timestamp; must not be over 12 hours before, either :p
            if (abs($nonce[1] - strtotime(date('r'))) > (60 * 60 * 12)) {
                // join window expired, try again
                echo "<p$errorstyle>ERROR: Please try again.</p>";
                return false;
            }

            // check if the rand and the md5 hash is correct... last three digits first
            if ($appended !== substr($nonce[0], 2, 3)) {
                // appended portion of random chars doesn't match actual random chars
                echo "<p$errorstyle>ERROR: Please try again.</p>";
                return false;
            }

            // now check the hash
            if (md5($nonce[0]) !== $mdfived) {
                // hash of random chars and the submitted one isn't the same!
                echo "<p$errorstyle>ERROR: Please try again.</p>";
                return false;
            }

            $this->cleanEmail = cleanNormalize($postData['enth_email']);
            $password = clean($postData['enth_password']);

            if ($this->cleanEmail === '' || $password === '') {
                $this->showForm = true;
                $this->responseMessage = 'Please fill out both email and password';
                return false;
            }

            $member = get_member_info($listing, $this->cleanEmail);
            if (!$member) {
                $this->showForm = true;
                $this->responseMessage = 'User with the given email address was not found in the system';
                return false;
            }

            // check password
            if (!(check_member_password($listing, $this->cleanEmail, $password))) {
                $this->showForm = true;
                $this->responseMessage = 'The password you supplied does not match ' .
                    'the password entered in the system. If you have lost your ' .
                    'password, <a href="' . $listingInfo['lostpasspage'] .
                    '">click here</a>.';
                return false;
            }

            if ((int)$member['pending'] === 1) {
                $this->showForm = true;
                $this->responseMessage = 'Looks like this user is pending approval. Please get approved first. Sorry for inconvenience';
                return false;
            }

            $success = delete_member($listing, $this->cleanEmail);
            if (!$success) {
                $this->responseMessage = 'Something went wrong during trying to remove you from fanlisting.' .
                    ' Please <a href="mailto:' . (str_replace('@', '&#' . ord('@') . ';', $listingInfo['email'])) .
                    '">email me</a> so that I can manually remove your data. Sorry for inconvenience.';
                return false;
            }

            $this->responseMessage = <<<HTML
                    <p class="show_delete_process">Your information has been
                        successfully removed from the member database.</p>
HTML;
            return true;
        }

        /**
         * @return bool
         */
        public function isShowForm(): bool
        {
            return $this->showForm;
        }

        /**
         * @return string
         */
        public function getResponseMessage(): string
        {
            return $this->responseMessage;
        }

        /**
         * @return string
         */
        public function getCleanEmail(): string
        {
            return $this->cleanEmail;
        }
    }

    class Form
    {
        /**
         * @param array $listingInfo
         * @param string $errorStyle
         * @param string $email
         * @param string $errorMessage
         * @return void
         */
        public function print(array $listingInfo = [], string $errorStyle = '', string $email = '', string $errorMessage = ''): void
        {
            $rand = md5(uniqid('', true));
            ?>
            <form method="post" class="show_delete_form">
                <p class="show_delete_intro">If you're a member of the
                    fanlisting and you want to remove your data from the fanlisting, please fill out the form
                    below. </p>

                <?= (isset($errorMessage)) ? "<p$errorStyle>{$errorMessage}</p>" : '' ?>

                <!-- Enthusiast <?= \RobotessNet\getVersion() ?> Delete Form -->
                <p class="show_delete_email">
                    <input type="hidden" name="enth_delettte" value="yes">
                    <input type="hidden" name="enth_nonce"
                           value="<?php echo $rand ?>:<?php echo strtotime(date('r')) ?>:<?php echo md5($rand) . substr($rand, 2, 3) ?>"/>
                    <span style="display: block;" class="show_delete_email_label">
   Email address:</span>
                    <input type="email" autocomplete="off" name="enth_email" class="show_delete_email_field" required
                           value="<?= $email ?>">
                </p>

                <p class="show_delete_password">
   <span style="display: block;" class="show_delete_password_label">
   Password: (<a href="<?php echo $listingInfo['lostpasspage'] ?>">Lost it?</a>)
   </span>
                    <input type="password" autocomplete="off" name="enth_password" class="show_delete_password_field" required>
                </p>

                <p class="show_delete_submit">
                    <input type="submit" value="Delete yourself" class="show_delete_submit_button">
                </p>

            </form>
            <?php
        }
    }

    if (isset($_POST['enth_delettte'])) {
        $handler = new Handler();
        $success = $handler->handle($listing, $_POST, $info, $errorstyle);
        if (!$success && $handler->isShowForm()) {
            $form = new Form();
            $form->print($info, $errorstyle, $handler->getCleanEmail(), $handler->getResponseMessage());
            return;
        }
        echo $handler->getResponseMessage();
        return;
    }

    $form = new Form();
    $form->print($info, $errorstyle);
}
