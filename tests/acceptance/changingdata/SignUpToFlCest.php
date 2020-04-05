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
    private $clickBtn = 'Join the fanlisting';
    private $page = '/samplefl/join.php';
    private $header = 'Join the Fanlisting';
    private $formElement = '.show_join_form';

    /**
     * @param AcceptanceTester $I
     */
    private function fillNonce(AcceptanceTester $I): void
    {
        $rand = md5(uniqid('', true));
        $time = time();
        $nonce = $rand . ':' . strtotime(date('r', $time - 1000)) . ':' . md5($rand) . substr($rand, 2, 3);
        $I->fillField('enth_nonce', $nonce);
    }

    public function getCorrectErrorWhenEmailAlreadyRegistered(AcceptanceTester $I): void
    {
        $I->amOnPage($this->page);
        $I->see($this->header);
        $I->amGoingTo('submit user form with email that is already registered');
        $this->fillNonce($I);
        $I->fillField('enth_name', 'Tester');
        $I->fillField('enth_email', 'with+plus@localhost123456.com');
        $I->selectOption('enth_country', 0);
        $I->click($this->clickBtn);
        $I->see('An error occured while attempting to add you to the pending members queue. This is because you are possibly already a member (approved or unapproved) or someone used your email address to join this fanlisting before.');
        $I->seeElement($this->formElement);
        $I->seeInField('enth_email', 'with+plus@localhost123456.com');
        $I->seeInField('enth_name', 'Tester');
        $I->seeInField('enth_country', 0);
    }

    public function canRegisterWithHttpsWebsite(AcceptanceTester $I): void
    {
        $I->amOnPage($this->page);
        $I->see($this->header);
        $I->amGoingTo('submit user form with https url');
        $this->fillNonce($I);
        $I->fillField('enth_name', 'Tester');
        $I->fillField('enth_email', 'SUPERNEWEMAIL@localhost123456.com');
        $I->fillField('enth_url', 'https://website.localhost.com');
        $I->selectOption('enth_country', 0);
        $I->click($this->clickBtn);
        if($I->cantSeeElement('.show_join_processed_emailsent')) {
            $I->seeElement('.show_join_processed_errormail');
        }
        $I->dontSeeElement($this->formElement);
        $I->amOnPage('/samplefl/index.php');
        $I->see('Pending members: 4');
    }
}
