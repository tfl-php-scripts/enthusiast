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

use function str_replace;
use const DIRECTORY_SEPARATOR;

spl_autoload_register([new Autoloader(), 'autoload']);

if (!class_exists(App::class))
{
	trigger_error('Robotess Autoloader not registered properly', E_USER_ERROR);
}

/**
 * Class Autoloader
 * @package Robotess
 */
final class Autoloader
{
    /**
     * @var string
     */
    private $path;

    /**
	 * Constructor
	 */
	public function __construct()
	{
		$this->path = __DIR__ . DIRECTORY_SEPARATOR;
	}

	/**
	 * @param string $class
	 */
	public function autoload(string $class): void
    {
		if (strpos($class, 'RobotessNet\\') !== 0)
		{
			return;
		}

        $classNameWithoutRobotessNS = str_replace( 'RobotessNet\\', '', $class );

        $filename = $this->path . DIRECTORY_SEPARATOR . str_replace( '\\', DIRECTORY_SEPARATOR, $classNameWithoutRobotessNS ) . '.php';
		include $filename;
	}
}
