<?php

class CheckUICest
{
    public function seeCorrectLinkToLostpassPage(AcceptanceTester $I): void
    {
        $I->amOnPage('/samplefl/delete.php');
        $I->see('Delete Yourself');
        $I->amGoingTo('check if lostpass link is correct');
        $I->click(['link' => 'Lost it?']);
        $I->seeResponseCodeIs(200);
    }
}
