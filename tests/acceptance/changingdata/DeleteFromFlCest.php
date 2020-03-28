<?php

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
