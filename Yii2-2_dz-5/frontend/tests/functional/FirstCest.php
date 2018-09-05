<?php
namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class FirstCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
    * @dataProvider pageProvider
    */
    public function tryToTest(FunctionalTester $I, \Codeception\Example $example)
    {
        $I->amOnPage($example['url']);
        $I->see($example['title'], 'h1');
    }

    /**
     * @return array
     */
    protected function pageProvider()
    {
        return [
            ['url'=>"site/index", 'title'=>"Congratulations!"],
            ['url'=>"site/about", 'title'=>"About"],
            ['url'=>"site/contact", 'title'=>"Contact"],
            ['url'=>"site/signup", 'title'=>"Signup"],
            ['url'=>"site/login", 'title'=>"Login"]
        ];
    }
}
