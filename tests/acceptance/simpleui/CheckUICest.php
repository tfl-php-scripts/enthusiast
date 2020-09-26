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

class CheckUICest
{
    public function seeCorrectVersionInDashboard(AcceptanceTester $I): void
    {
        $I->amOnPage('/enthusiast/dashboard.php');
        $I->amOnPage('/enthusiast/index.php');
        $I->see('Welcome to the Enthusiast [Robotess Fork] v. 1.0.5 admin panel for My Collective!', 'h1');
    }

    public function seeCorrectDatesInStatsWidget(AcceptanceTester $I): void
    {
        $I->amOnPage('/samplefl');
        $I->see('Opened: 17th February 2010');
        $I->see('Last updated: 24th June 2019');
    }

    public function seeCorrectLinkToLostpassPage(AcceptanceTester $I): void
    {
        $I->amOnPage('/samplefl/delete.php');
        $I->see('Delete Yourself');
        $I->amGoingTo('check if lostpass link is correct');
        $I->click(['link' => 'Lost it?']);
        $I->seeResponseCodeIs(200);
    }
}
