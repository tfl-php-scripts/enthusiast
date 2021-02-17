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

use PDO;
use PDOException;
use RobotessNet\StringUtils;
use function array_merge;

final class Handler
{
    private static int $DUPLICATE_ENTRY_SQL_ERROR_CODE = 1062;

    private array $fieldsDefaults;

    private bool $showForm = false;
    
    private string $email = '';
    private string $name = '';
    private string $url = '';
    private string $country = '';
    private string $comments = '';
    private ?int $countryId = null;

    private array $messages = [];

    private function __construct(array $fieldsDefaults = [])
    {
        $this->fieldsDefaults = $fieldsDefaults;
    }

    public static function create(array $fieldsDefaults = []): self
    {
        return new self($fieldsDefaults);
    }

    public function process(
        array $sentData,
        string $errorstyle,
        array $countriesValues,
        array $listingInfo,
        array $extraFields,
        array $extraFieldsValues,
        int $listing
    ): bool {

        $newData = array_merge($sentData, $this->fieldsDefaults);

        // do some spam/bot checking first
        $goahead = false;
        // 1. check that user is submitting from browser
        // 2. check the POST was indeed used
        if (isset($_SERVER['HTTP_USER_AGENT']) &&
            $_SERVER['REQUEST_METHOD'] === 'POST') {
            $goahead = true;
        }

        if (!$goahead) {
            echo "<p$errorstyle>ERROR: Attempted circumventing of the form detected.</p>";

            return false;
        }

        // check nonce field
        $nonce = explode(':', StringUtils::instance()
                                         ->clean($newData['enth_nonce']));
        if ($nonce === false) {
            echo "<p$errorstyle>ERROR: Attempted circumventing of the form detected.</p>";

            return false;
        }

        $mdfived = substr($nonce[2], 0, (strlen($nonce[2]) - 3));
        $appended = substr($nonce[2], -3);
        // check the timestamp; must be more than three seconds after
        if (abs($nonce[1] - strtotime(date('r'))) < 3) {
            // probably a bot, or multiple-clicking... do this again
            echo "<p$errorstyle>ERROR: Please try again.</p>";

            return false;
        }
        // check the timestamp; must not be over 12 hours before, either :p
        if (abs($nonce[1] - strtotime(date('r'))) > (60 * 60 * 12)) {
            // join window expired, try again
            echo "<p$errorstyle>ERROR: Please try again.</p>";

            return false;
        }
        // check if the rand and the md5 hash is correct... last three digits first
        if ($appended != substr($nonce[0], 2, 3)) {
            // appended portion of random chars doesn't match actual random chars
            echo "<p$errorstyle>ERROR: Please try again.</p>";

            return false;
        }
        // now check the hash
        if (md5($nonce[0]) != $mdfived) {
            // hash of random chars and the submitted one isn't the same!
            echo "<p$errorstyle>ERROR: Please try again.</p>";

            return false;
        }

        // go on
        if ($newData['enth_name']) {
            $this->name = ucwords(StringUtils::instance()
                                       ->clean($newData['enth_name']));
        } else {
            $this->messages['name'] = 'You must enter your name.';
            $this->showForm = true;
        }

        $this->email = StringUtils::instance()
                            ->cleanNormalize($newData['enth_email']);
        if (!StringUtils::instance()
                        ->isEmailValid($newData['enth_email'])) {
            $this->messages['email'] = 'You must enter a valid email address.';
            $this->showForm = true;
        }

        if (isset($newData['enth_country']) && $newData['enth_country'] !== '') {
            $this->countryId = (int)(StringUtils::instance()
                                          ->cleanNormalize($newData['enth_country']));
            if (isset($countriesValues[$this->countryId])) {
                $this->country = $countriesValues[$this->countryId];
            } else {
                $this->messages['country'] = 'You must choose a country from the list.';
                $this->showForm = true;
            }
        } elseif ($listingInfo['country'] == 1) {
            $this->messages['country'] = 'You must specify your country.';
            $this->showForm = true;
        }

        if ($newData['enth_password'] && $newData['enth_vpassword'] &&
            $newData['enth_vpassword'] == $newData['enth_password']) {
            // has password and validates
            $password = StringUtils::instance()
                                   ->clean($newData['enth_password']);
        } elseif ($newData['enth_password'] == '' && $newData['enth_vpassword'] == '') {
            // no password, must generate
            $password = '';
            $k = 0;
            while ($k <= 10) {
                $password .= chr(rand(97, 122));
                $k++;
            }
        } else {
            $this->messages['password'] = 'The password you entered does not validate ' .
                '(does not match each other).';
            $this->showForm = true;
        }

        if (isset($newData['enth_url'])) {
            $this->url = StringUtils::instance()->clean($newData['enth_url']);
            if (preg_match('@^https?://@', $this->url) === false) {
                $this->url = 'http://' . $this->url;
            }
        }

        foreach ($extraFields as $field) {
            $extraFieldsValues[$field] = isset($newData["enth_$field"]) ? StringUtils::instance()
                                                                                     ->clean($newData["enth_$field"]) : StringUtils::instance()
                                                                                                                                   ->clean($newData[$field]);
        }

        if (isset($newData['enth_comments'])) {
            $this->comments = StringUtils::instance()->clean($newData['enth_comments']);
        }

        if (count($this->messages) === 0) {
            $this->showForm = false;
            $show_email = StringUtils::instance()->clean((string)$newData['enth_show_email']);
            $send_account_info = (isset($newData['enth_send_account_info']) &&
                $newData['enth_send_account_info'] === 'yes');
            $table = $listingInfo['dbtable'];

            // more spamform checking
            // thanks to Jem of jemjabella.co.uk
            $find = '/(content-type|bcc:|cc:|onload|onclick|javascript)/i';
            if (preg_match($find, $this->name) || preg_match($find, $this->email) ||
                preg_match($find, $this->url) || preg_match($find, $this->comments) ||
                preg_match($find, $this->country) || preg_match($find, $show_email)) {
                echo "<p$errorstyle>No naughty injecting, please.</p>";
                exit;
            }

            $query = "INSERT INTO `$table` VALUES( :email, :name, ";
            if ($listingInfo['country'] == 1) {
                $query .= "'$this->country', ";
            }
            $query .= ':url, ';
            foreach ($extraFields as $field) {
                $query .= '\'' . $extraFieldsValues[$field] . '\', ';
            }
            $query .= '1, MD5( :password ), :show_email, 1, NULL )';

            try {
                $db_link = new PDO('mysql:host=' . $listingInfo['dbserver'] . ';dbname=' . $listingInfo['dbdatabase'] . ';charset=utf8',
                    $listingInfo['dbuser'], $listingInfo['dbpassword']);
                $db_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die(DATABASE_CONNECT_ERROR . $e->getMessage());
            }

            // we will retrieve info ourselves, that's why mode = silent
            $db_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

            $pdoStatement = $db_link->prepare($query);
            $pdoStatement->bindParam(':email', $this->email);
            $pdoStatement->bindParam(':name', $this->name);
            $pdoStatement->bindParam(':url', $this->url);
            $pdoStatement->bindParam(':password', $password);
            $pdoStatement->bindParam(':show_email', $show_email);

            $result = $pdoStatement->execute();

            // if addition is successful
            if ($result === true) {
                // check if notify owner
                if ($listingInfo['notifynew'] == 1) {
                    $subject = $listingInfo['subject'];
                    $listingtype = $listingInfo['listingtype'];
                    $listingurl = $listingInfo['url'];
                    $notify_subject = "$subject - New member!";
                    $notify_message = "Someone has joined your $subject $listingtype" .
                        " ($listingurl). Relevant information is below:\r\n\r\n" .
                        "Name: $this->name\r\n" .
                        "Email: $this->email\r\n" .
                        "Country: $this->country\r\n" .
                        "URL: $this->url\r\n";
                    foreach ($extraFields as $field) {
                        $notify_message .= ucwords(str_replace('_', ' ', $field)) .
                            ': ' . $extraFieldsValues[$field] . "\r\n";
                    }
                    $notify_message .= "Comments: $this->comments\r\n\r\nTo add this " .
                        'member, go to ' . str_replace(get_setting(
                            'root_path_absolute'), get_setting('root_path_web'),
                            get_setting('installation_path')) .
                        "members.php\r\n";
                    $notify_message = stripslashes($notify_message);
                    $notify_from = 'Enthusiast <' . get_setting('owner_email') . '>';

                    // use send_email function
                    $mail_sent = send_email($listingInfo['email'], $notify_from,
                        $notify_subject, $notify_message);
                } // end notify owner

                // email new member, or just show success message
                if (!$send_account_info) {
                    ?>
                    <p class="show_join_processed_noemail">The application form
                        for the <?= $listingInfo['subject'] ?> <?= $listingInfo['listingtype'] ?> has
                        been sent. You will be notified when you have been added into
                        the actual members list. If two weeks have passed and you have
                        received no email, please <a
                                href="mailto:<?= str_replace('@', '&#' . ord('@') . ';', $listingInfo['email'])
                                ?>">email me</a> if you wish to check up on your form.</p>
                    <?php
                } else { // email!
                    $to = $this->email;
                    $subject = $listingInfo['title'] . ' ' . ucfirst($listingInfo['listingtype']) .
                        ' Information';

                    $from = '"' . html_entity_decode($listingInfo['title'], ENT_QUOTES) .
                        '" <' . $listingInfo['email'] . '>';
                    $message = parse_email('signup', $listing, $this->email, $password);
                    $message = stripslashes($message);

                    // use send_email function
                    $success_mail = send_email($to, $from, $subject, $message);
                    if ($success_mail !== true) {
                        ?>
                        <p class="show_join_processed_errormail">Your form has been
                            processed correctly, but unfortunately there was an error
                            sending your application information to you. If you
                            wish to receive information about your application, please feel
                            free to <a href="mailto:<?= str_replace('@', '&#' . ord('@') . ';', $listingInfo['email'])
                            ?>">email me</a> and I will personally
                            look into it. Please note I cannot send your password to you.</p>

                        <p class="show_join_processed_errormail">If two weeks have
                            passed and you have not yet been added,
                            please feel free to check up on your application.</p>
                        <?php
                    } else {
                        ?>
                        <p class="show_join_processed_emailsent">The application form
                            for the <?= $listingInfo['subject'] ?> <?= $listingInfo['listingtype'] ?> has
                            been sent. You will be notified when you have been added into
                            the actual members list. If two weeks have passed and you have
                            received no email, please <a
                                    href="mailto:<?= str_replace('@', '&#' . ord('@') . ';', $listingInfo['email'])
                                    ?>">email me</a> if you wish to check up on your form.</p>

                        <p class="show_join_processed_emailsent">An email has also
                            been sent to you with your information
                            as you requested. Please do not lose this information.</p>
                        <?php
                    }
                }

                return true;
            }

            $errorInfo = $pdoStatement->errorInfo() ?? [];
            if (isset($errorInfo[1]) && $errorInfo[1] === self::$DUPLICATE_ENTRY_SQL_ERROR_CODE) {
                $this->messages['form'] = 'An error occured while attempting to add ' .
                    'you to the pending members queue. This is because you are ' .
                    'possibly already a member (approved or unapproved) or ' .
                    'someone used your email address to join this ' .
                    $listingInfo['listingtype'] . ' before. If you wish to update ' .
                    'your information, please go <a href="' . $listingInfo['updatepage'] .
                    '">here</a>.';
                $this->showForm = true;
            } else {
                log_error(__FILE__ . ':' . __LINE__,
                    'Error executing query: <i>' . $pdoStatement->errorInfo()[2] .
                    '</i>; Query is: <code>' . $query . '</code>');
                ?>
                <p<?= $errorstyle ?>>An error occured while attempting to add you to the pending
                    members queue. Unfortunately, this was caused by a database error
                    on this <?= $listingInfo['listingtype'] ?>. The error has been logged, but
                    feel free to <a href="mailto:<?= str_replace('@', '&#' . ord('@') . ';', $listingInfo['email'])
                    ?>">contact me</a>
                    about it and I will try to fix the problem as soon as possible.</p>
                <?php
            }
        }

        return false;
    }

    public function isShowForm(): bool
    {
        return $this->showForm;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function getCountryId(): ?int
    {
        return $this->countryId;
    }

}
