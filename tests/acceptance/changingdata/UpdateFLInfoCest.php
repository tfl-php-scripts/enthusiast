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

class UpdateFLInfoCest
{
    private $page = '/samplefl/update.php';
    private $title = 'Update your Information';
    private $clickBtnValue = '.show_update_submit_button';
    private $formElement = '.show_update_form';

    private $email = 'normalEmail@localhost123456.com';

    private $newName = 'New Name';
    private $newEmailPart1 = 'new-email';
    private $newEmailPart2 = 'localhost.com';
    private $newEmail = 'new-email@localhost.com';
    private $newWebsite = 'https://new.website.com';

    /**
     * @param AcceptanceTester $I
     */
    private function fillFieldsToUpdate(AcceptanceTester $I): void
    {
        $I->fillField('enth_email_new', $this->newEmail);
        $I->fillField('enth_name', $this->newName);
        $I->fillField('enth_url', $this->newWebsite);
        $I->selectOption('enth_country', 0);

        $rand = md5(uniqid('', true));
        $time = time();
        $nonce = $rand . ':' . strtotime(date('r', $time - 1000)) . ':' . md5($rand) . substr($rand, 2, 3);
        $I->fillField('enth_nonce', $nonce);
    }

    public function getErrorWhenEnterIncorrectPassword(AcceptanceTester $I): void
    {
        $I->amOnPage($this->page);
        $I->see($this->title);
        $I->amGoingTo('submit user form with wrong password');
        $I->fillField('enth_email', $this->email);
        $I->fillField('enth_old_password', 'password123');
        $this->fillFieldsToUpdate($I);
        $I->click($this->clickBtnValue);
        $I->see('The password you supplied does not match the password entered in the system.');
        $I->seeElement($this->formElement);
    }

    public function beSuccessfullyUpdated(AcceptanceTester $I): void
    {
        $I->amOnPage($this->page);
        $I->see($this->title);
        $I->amGoingTo('submit user form');
        $I->fillField('enth_email', $this->email);
        $I->fillField('enth_old_password', 'password');
        $this->fillFieldsToUpdate($I);
        $I->click($this->clickBtnValue);
        $I->see('Your information has been successfully updated in the member database. Thank you for keeping your information up to date with us!');
        $I->dontSeeElement($this->formElement);

        $I->amOnPage('/samplefl/list.php');
        $I->see('New Name (United States)');
        $I->seeInSource('<p><b>' . $this->newName . '</b> (United States)');
        $I->seeInSource('jsemail = ( \'' . $this->newEmailPart1 . '\' + \'@\' + \'' . $this->newEmailPart2 . '\' );');
        $I->seeInSource('<a href="' . $this->newWebsite . '" target="_top" class="show_members_website">website</a>');
    }
}
