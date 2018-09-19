<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }
    
    /**
     * @param FunctionalTester $I
     */
    public function loginUser(FunctionalTester $I) // поправил тест под графическое оформление "dmstr/yii2-adminlte-asset": "^2.1"
    {
        $I->amOnPage('/site/login');
        // $I->fillField('Username', 'erau');
        $I->fillField('#loginform-username', 'erau');
        // $I->fillField('Password', 'password_0');
        $I->fillField('#loginform-password', 'password_0');
        $I->click('login-button');

        //$I->see('Logout (erau)', 'form button[type=submit]'); Sign out
        $I->see('Sign out', 'a');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
