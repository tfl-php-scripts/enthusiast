<?php
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

namespace {
    /*___________________________________________________________________________*/
    function get_setting($setting)
    {
        include 'config.php';

        $query = "SELECT `value` FROM `$db_settings` WHERE `setting` = :setting";

        try {
            $db_link = new PDO('mysql:host=' . $db_server . ';dbname=' . $db_database . ';charset=utf8', $db_user, $db_password);
            $db_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(DATABASE_CONNECT_ERROR . $e->getMessage());
        }
        $result = $db_link->prepare($query);
        $result->bindParam(':setting', $setting, PDO::PARAM_STR);
        $result->execute();
        if (!$result) {
            log_error(__FILE__ . ':' . __LINE__,
                'Error executing query: <i>' . $result->errorInfo()[2] .
                '</i>; Query is: <code>' . $query . '</code>');
            die(STANDARD_ERROR);
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        return $row['value'];

    } // end of get_setting


    /*___________________________________________________________________________*/
    function check_password($password)
    {
        include 'config.php';

        $query = "SELECT * FROM `$db_settings` WHERE `setting` = 'password' AND ";
        $query .= "`value` = :password";

        try {
            $db_link = new PDO('mysql:host=' . $db_server . ';dbname=' . $db_database . ';charset=utf8', $db_user, $db_password);
            $db_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(DATABASE_CONNECT_ERROR . $e->getMessage());
        }
        $result = $db_link->prepare($query);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();
        if (!$result) {
            log_error(__FILE__ . ':' . __LINE__,
                'Error executing query: <i>' . $result->errorInfo()[2] .
                '</i>; Query is: <code>' . $query . '</code>');
            die(STANDARD_ERROR);
        }
        if ($result->rowCount() > 0)
            return true;
        else
            return false;
    }


    /*___________________________________________________________________________*/
    function get_setting_title($setting)
    {
        include 'config.php';

        $query = "SELECT `title` FROM `$db_settings` WHERE `setting` = :setting";
        try {
            $db_link = new PDO('mysql:host=' . $db_server . ';dbname=' . $db_database . ';charset=utf8', $db_user, $db_password);
            $db_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(DATABASE_CONNECT_ERROR . $e->getMessage());
        }
        $result = $db_link->prepare($query);
        $result->bindParam(':setting', $setting, PDO::PARAM_STR);
        $result->execute();
        if (!$result) {
            log_error(__FILE__ . ':' . __LINE__,
                'Error executing query: <i>' . $result->errorInfo()[2] .
                '</i>; Query is: <code>' . $query . '</code>');
            die(STANDARD_ERROR);
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        return $row['title'];

    } // end of get_setting_title


    /*___________________________________________________________________________*/
    function get_setting_desc($setting)
    {
        include 'config.php';

        $query = "SELECT `help` FROM `$db_settings` WHERE `setting` = :setting";
        try {
            $db_link = new PDO('mysql:host=' . $db_server . ';dbname=' . $db_database . ';charset=utf8', $db_user, $db_password);
            $db_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(DATABASE_CONNECT_ERROR . $e->getMessage());
        }
        $result = $db_link->prepare($query);
        $result->bindParam(':setting', $setting, PDO::PARAM_STR);
        $result->execute();
        if (!$result) {
            log_error(__FILE__ . ':' . __LINE__,
                'Error executing query: <i>' . $result->errorInfo()[2] .
                '</i>; Query is: <code>' . $query . '</code>');
            die(STANDARD_ERROR);
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        return $row['help'];

    } // end of get_setting_desc


    /*___________________________________________________________________________*/
    function get_all_settings()
    {
        include 'config.php';

        $query = "SELECT * FROM `$db_settings` WHERE `setting` " .
            "NOT LIKE '%template%'";
        try {
            $db_link = new PDO('mysql:host=' . $db_server . ';dbname=' . $db_database . ';charset=utf8', $db_user, $db_password);
            $db_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(DATABASE_CONNECT_ERROR . $e->getMessage());
        }
        $result = $db_link->prepare($query);
        $result->execute();
        if (!$result) {
            log_error(__FILE__ . ':' . __LINE__,
                'Error executing query: <i>' . $result->errorInfo()[2] .
                '</i>; Query is: <code>' . $query . '</code>');
            die(STANDARD_ERROR);
        }

        $settings = array();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $result->fetch())
            $settings[] = $row;
        return $settings;

    } // end of get_all_settings


    /*___________________________________________________________________________*/
    function get_all_templates()
    {
        include 'config.php';

        $query = "SELECT * FROM `$db_settings` WHERE `setting` LIKE '%template%'";
        try {
            $db_link = new PDO('mysql:host=' . $db_server . ';dbname=' . $db_database . ';charset=utf8', $db_user, $db_password);
            $db_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(DATABASE_CONNECT_ERROR . $e->getMessage());
        }
        $result = $db_link->prepare($query);
        $result->execute();
        if (!$result) {
            log_error(__FILE__ . ':' . __LINE__,
                'Error executing query: <i>' . $result->errorInfo()[2] .
                '</i>; Query is: <code>' . $query . '</code>');
            die(STANDARD_ERROR);
        }
        $templates = array();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $result->fetch())
            $templates[] = $row;
        return $templates;

    } // end of get_all_settings


    /*___________________________________________________________________________*/
    function update_setting($setting, $value)
    {
        include 'config.php';

        try {
            $db_link = new PDO('mysql:host=' . $db_server . ';dbname=' . $db_database . ';charset=utf8', $db_user, $db_password);
            $db_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(DATABASE_CONNECT_ERROR . $e->getMessage());
        }

        if ($setting != 'password') {
            $query = "UPDATE `$db_settings` SET `value` = :value WHERE " .
                "`setting` = :setting";
            $result = $db_link->prepare($query);
            // removing unnecessary slashes
            $value = stripslashes($value);
            $result->bindParam(':value', $value, PDO::PARAM_STR);
            $result->bindParam(':setting', $setting, PDO::PARAM_STR);
            $result->execute();
            if (!$result) {
                log_error(__FILE__ . ':' . __LINE__,
                    'Error executing query: <i>' . $result->errorInfo()[2] .
                    '</i>; Query is: <code>' . $query . '</code>');
                die(STANDARD_ERROR);
            }
        } else {
            $query = "UPDATE `$db_settings` SET `value` = MD5( :value ) " .
                "WHERE `setting` = 'password'";
            $result = $db_link->prepare($query);
            $result->bindParam(':value', $value, PDO::PARAM_STR);
            $result->execute();
            if (!$result) {
                log_error(__FILE__ . ':' . __LINE__,
                    'Error executing query: <i>' . $result->errorInfo()[2] .
                    '</i>; Query is: <code>' . $query . '</code>');
                die(STANDARD_ERROR);
            }
        }

    } // end of update_setting


    /*___________________________________________________________________________*/
    function update_settings($settings)
    {
        include 'config.php';
        try {
            $db_link = new PDO('mysql:host=' . $db_server . ';dbname=' . $db_database . ';charset=utf8', $db_user, $db_password);
            $db_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(DATABASE_CONNECT_ERROR . $e->getMessage());
        }

        foreach ($settings as $field => $value) {
            $query = "UPDATE `$db_settings` SET `value` = :value WHERE " .
                "`setting` = '$field'";
            if ($field == 'password') {
                if ($settings['passwordv'] != '' &&
                    $value == $settings['passwordv']) {
                    $query = "UPDATE `$db_settings` SET `value` = MD5( :value ) " .
                        "WHERE `setting` = 'password'";
                } else
                    $query = '';
            }
            if ($query != '') {
                $result = $db_link->prepare($query);
                $result->bindParam(':value', $value, PDO::PARAM_STR);
                $result->execute();
                if (!$result) {
                    log_error(__FILE__ . ':' . __LINE__,
                        'Error executing query: <i>' . $result->errorInfo()[2] .
                        '</i>; Query is: <code>' . $query . '</code>');
                    die(STANDARD_ERROR);
                }
            }
        }
    }
}

namespace RobotessNet {

    use PDOStatement;
    use function file_exists;
    use function ob_get_clean;
    use function ob_start;
    const DUPLICATE_ENTRY_SQL_ERROR_CODE = 1062;

    /**
     * @param PDOStatement $result
     * @return bool
     */
    function isDuplicateSqlError(PDOStatement $result)
    {
        $errorInfo = $result->errorInfo() ?? [];
        return isset($errorInfo[1]) && $errorInfo[1] === DUPLICATE_ENTRY_SQL_ERROR_CODE;
    }

    /**
     * @param int $numberOfPages
     * @param string $url
     * @param string $connector
     * @return string
     */
    function getPaginatorHTML(int $numberOfPages, string $url, string $connector)
    {
        if ($numberOfPages <= 1) {
            return '';
        }

        $result = '<p class="center">Go to page: ';

        $i = 1;
        while (($i <= $numberOfPages + 1) && $numberOfPages > 1) {
            $start_link = ($i - 1) * get_setting('per_page');
            $result .= '<a href="' . $url . $connector . 'start=' . $start_link . '">' .
                $i . '</a> ';
            $i++;
        }

        $result .= '</p>';

        return $result;
    }

    /**
     * @return string
     */
    function getVersion()
    {
        $result = '[Robotess Fork] v. ';
        if (file_exists(ENTH_PATH . 'show_enthversion.php')) {
            ob_start();
            include ENTH_PATH . 'show_enthversion.php';
            return $result . ob_get_clean();
        }

        return $result . 'Unknown';
    }
}
