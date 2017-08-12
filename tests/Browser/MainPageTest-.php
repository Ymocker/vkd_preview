<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testMainPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Реклама на первой полосе');
        });
    }

    public function testFirstPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/page/1#bottomMenu')
                    ->assertSee('Реклама на первой полосе');
        });
    }

    public function testInnerPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/page/2#bottomMenu')
                    ->assertSee('Реклама на внутренних полосах');
        });
    }

    public function testTextPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/page/5#bottomMenu')
                    ->assertSee('Текстовая реклама');
        });
    }

    public function testSitePage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/page/5#bottomMenu')
                    ->assertSee('Реклама на сайте');
        });
    }

    public function testSearchPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/page/search#bottomMenu')
                    ->assertSee('Поиск рекламы');
        });
    }

    public function testAboutPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/about/about')
                    ->assertSee('Выходит еженедельно');
        });
    }

    public function testContactPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/about/contact')
                    ->assertSee('Наш адрес:');
        });
    }

    public function testTariffPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/about/tariff')
                    ->assertSee('Тарифы на размещение рекламы');
        });
    }

//    public function testArchivePage()
//    {
//        $this->browse(function (Browser $browser) {
//            $browser->visit('/number/42')
//                    ->assertSee('1071');
//        });
//    }
}
