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

namespace RobotessNet;

use function htmlentities;
use function preg_match;
use function strip_tags;
use function trim;
use const ENT_QUOTES;

/**
 * Class StringUtils
 * @package Robotess
 */
final class StringUtils
{
    /**
     * @var self
     */
    private static $instance;

    private function __construct()
    { /***/
    }

    public static function instance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string|null $data
     * @param bool $leaveHtml
     * @return string
     */
    public function clean(?string $data, bool $leaveHtml = false): string
    {
        if ($data === null) {
            return '';
        }

        if ($leaveHtml) {
            $data = trim($data);
        } else {
            $data = trim(htmlentities(strip_tags($data), ENT_QUOTES));
        }

        if (get_magic_quotes_gpc()) {
            $data = stripslashes($data);
        }

        $data = addslashes($data);

        return $data;
    }

    /**
     * @param string|null $data
     * @return string
     */
    public function cleanNormalize(?string $data): string
    {
        return strtolower($this->clean($data));
    }

    /**
     * @param string $email
     * @return bool
     */
    public function isEmailValid(string $email): bool
    {
        return (bool)preg_match("/^([A-Za-z0-9-_.+]+)@(([A-Za-z0-9-_]+\.)+)([a-zA-Z]{2,})$/i", $email);
    }
}
