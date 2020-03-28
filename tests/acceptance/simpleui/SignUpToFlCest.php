<?php

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
