<?php
namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class FirstCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(['site/index']);
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->grabTextFrom('h1');
        $I->seeLink('About');
        $I->click('About');
        $I->grabTextFrom('h1');
        $I->seeLink('Contact');
        $I->click('Contact');
        $I->grabTextFrom('h1');
        $I->seeLink('Signup');
        $I->click('Signup');
        $I->grabTextFrom('h1');
        $I->seeLink('Login');
        $I->click('Login');
        $I->grabTextFrom('h1');
    }
}
