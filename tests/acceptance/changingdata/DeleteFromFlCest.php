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

class DeleteFromFlCest
{
    public function getErrorWhenEmailNotSpecified(AcceptanceTester $I): void
    {
        $I->amOnPage('/samplefl/delete.php');
        $I->see('Delete Yourself');
        $I->amGoingTo('submit user form without email');
        $I->fillField('enth_password', 'anything');
        $I->click('Delete yourself');
        $I->see('Please fill out both email and password');
        $I->seeElement('.show_delete_form');
        $I->seeInField('enth_email', '');
        $I->seeInField('enth_password', '');
    }

    public function getErrorWhenPasswordNotSpecified(AcceptanceTester $I): void
    {
        $I->amOnPage('/samplefl/delete.php');
        $I->see('Delete Yourself');
        $I->amGoingTo('submit user form without password');
        $I->fillField('enth_email', 'anYthing@email.com');
        $I->click('Delete yourself');
        $I->see('Please fill out both email and password');
        $I->seeElement('.show_delete_form');
        $I->seeInField('enth_email', 'anything@email.com');
        $I->seeInField('enth_password', '');
    }

    public function getErrorWhenEmailNotFound(AcceptanceTester $I): void
    {
        $I->amOnPage('/samplefl/delete.php');
        $I->see('Delete Yourself');
        $I->amGoingTo('submit user form where user does not exist');
        $I->fillField('enth_email', '  uhidhdfTTTTdhjdg@Oidgfdjfigjdf.com');
        $I->fillField('enth_password', 'anything');
        $I->click('Delete yourself');
        $I->see('User with the given email address was not found in the system');
        $I->seeElement('.show_delete_form');
        $I->seeInField('enth_email', 'uhidhdfttttdhjdg@oidgfdjfigjdf.com');
        $I->seeInField('enth_password', '');
    }

    public function getErrorWhenEnterIncorrectPassword(AcceptanceTester $I): void
    {
        $I->amOnPage('/samplefl/delete.php');
        $I->see('Delete Yourself');
        $I->amGoingTo('submit user form with wrong password');
        $I->fillField('enth_email', 'user1@user.com ');
        $I->fillField('enth_password', 'password123');
        $I->click('Delete yourself');
        $I->see('The password you supplied does not match the password entered in the system');
        $I->seeElement('.show_delete_form');
        $I->seeInField('enth_email', 'user1@user.com');
        $I->seeInField('enth_password', '');
    }

    public function getErrorWhenUserIsPending(AcceptanceTester $I): void
    {
        $I->amOnPage('/samplefl/delete.php');
        $I->see('Delete Yourself');
        $I->amGoingTo('submit user form where user is pending');
        $I->fillField('enth_email', ' pendinGuser@localhost123456.com ');
        $I->fillField('enth_password', 'password');
        $I->click('Delete yourself');
        $I->see('Looks like this user is pending approval. Please get approved first. Sorry for inconvenience');
        $I->seeElement('.show_delete_form');
        $I->seeInField('enth_email', 'pendinguser@localhost123456.com');
        $I->seeInField('enth_password', '');
    }

    public function beSuccessfullyDeleted(AcceptanceTester $I): void
    {
        $I->amOnPage('/samplefl/delete.php');
        $I->see('Delete Yourself');
        $I->amGoingTo('submit user form');
        $I->fillField('enth_email', 'user1@usEr.com ');
        $I->fillField('enth_password', 'password');
        $I->click('Delete yourself');
        $I->see('Your information has been successfully removed from the member database.');
        $I->dontSeeElement('.show_delete_form');
    }
}
