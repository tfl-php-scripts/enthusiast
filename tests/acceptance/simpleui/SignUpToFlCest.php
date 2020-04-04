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

class SignUpToFlCest
{
    public function getCorrectErrorWhenEmailAlreadyRegistered(AcceptanceTester $I): void
    {
        $rand = md5(uniqid('', true));
        $time = time();
        $nonce = $rand . ':' . strtotime(date('r', $time - 1000)) . ':' . md5($rand) . substr($rand, 2, 3);

        $I->amOnPage('/samplefl/join.php');
        $I->see('Join the Fanlisting');
        $I->amGoingTo('submit user form with email that is already registered');
        $I->fillField('enth_name', 'Tester');
        $I->fillField('enth_email', 'with+plus@localhost123456.com');
        $I->fillField('enth_nonce', $nonce);
        $I->selectOption('enth_country', 'United States');
        $I->click('Join the fanlisting');
        $I->see('An error occured while attempting to add you to the pending members queue. This is because you are possibly already a member (approved or unapproved) or someone used your email address to join this fanlisting before.');
        $I->seeElement('.show_join_form');
        $I->seeInField('enth_email', 'with+plus@localhost123456.com');
        $I->seeInField('enth_name', 'Tester');
    }
}
