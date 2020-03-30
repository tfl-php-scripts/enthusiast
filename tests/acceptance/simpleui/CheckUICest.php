<?php

class CheckUICest
{
    public function seeCorrectVersionInDashboard(AcceptanceTester $I): void
    {
        $I->amOnPage('/enthusiast');
        $I->see('Password');
        $I->amGoingTo('login into dashboard');
        $I->fillField('login_password', 'password');
        $I->click('Log in');
        $I->amOnPage('/enthusiast/dashboard.php');
        //$I->see('Enthusiast: [Robotess Fork] v. 1.0', "//html/body/div[2]/div/p[3]");
        $I->dontSee('Enthusiast: [Robotess Fork] v. Unknown', "//html/body/div[2]/div/p[3]");
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
