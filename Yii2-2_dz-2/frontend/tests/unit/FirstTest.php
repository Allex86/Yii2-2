<?php
namespace frontend\tests;

use common\fixtures\Uzver;

class FirstTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $a = 2;
        $this->assertTrue($a == 2); // - сравнении с true
        $this->assertEquals(2, $a); // - равно ожидаемому значению
        $this->assertLessThan(3, $a); // - меньше ожидаемого значения

        $user = new Uzver;
        $this->assertAttributeNotEquals($a, 'id', $user);
        $this->assertAttributeEquals(100500, 'id', $user); // - значение атрибута(свойства) объекта равно ожидаемому значению - создайте экземпляр User, заполните аттрибуты и проверьте, можно так тестировать, например массовую загрузку значений атрибутов.

        $this->assertArrayHasKey('a', ['a' => 1, 'b' => 2, 'c' => 3]); // - в массиве есть указанный ключ
        $this->assertArrayNotHasKey('d', ['a' => 1, 'b' => 2, 'c' => 3]);
    }
}
