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

class Correct200ResponsesCest
{
    /**
     * @example { "url": "/samplefl" }
     * @example { "url": "/samplefl/list.php" }
     * @example { "url": "/samplefl/join.php" }
     * @example { "url": "/samplefl/update.php" }
     * @example { "url": "/samplefl/lostpass.php" }
     * @example { "url": "/samplefl/delete.php" }
     * @example { "url": "/samplefl/affiliates.php" }
     * @example { "url": "/samplecollective" }
     * @example { "url": "/samplecollective/joined.php" }
     * @example { "url": "/samplecollective/current.php" }
     * @example { "url": "/samplecollective/upcoming.php" }
     * @example { "url": "/samplecollective/pending.php" }
     * @example { "url": "/samplecollective/affiliates.php" }
     * @example { "url": "/enthusiast" }
     * @example { "url": "/enthusiast/install.php" }
     */
    public function staticPages(AcceptanceTester $I, \Codeception\Example $example)
    {
        $I->amOnPage($example['url']);
        $I->seeResponseCodeIs(200);
    }
}
