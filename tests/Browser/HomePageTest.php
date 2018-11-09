<?php

namespace Tests\Browser;


use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\RefreshDatabase;



class HomePageTest extends DuskTestCase
{

    use RefreshDatabase;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {


        $this->browse(function (Browser $browser) {


            //dd($browser->visit('/')->);


        });
    }
}
