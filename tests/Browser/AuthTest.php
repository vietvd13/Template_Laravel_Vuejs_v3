<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testGeneral()
    {
        $this->browse(function ($browser) {
            $this->caseFail($browser);
            $this->caseSuccess($browser);
        });
    }

    public function caseFail($browser)
    {
        $browser->visit('/#/login')
            ->waitForText('back', 5)->releaseMouse()
            ->typeSlowly('username', 'Good morning!')->typeSlowly('password', '123456')->releaseMouse()->press('.btn_submit')
            ->waitForText('Warning', 5)->assertSee("Warning")
            ->waitUntilMissing('.alert', 5)
            ->typeSlowly('username', '<script>alert("this is bad script")</script>')->releaseMouse()->typeSlowly('password', '123456')->press('.btn_submit')
            ->waitForText('Warning', 5)->assertSee("Warning")
            ->waitUntilMissing('.alert', 5)
            ->typeSlowly('username', 'wrong_account@gmail.com')->typeSlowly('password', '123456')->releaseMouse()->press('.btn_submit')
            ->waitForText('Warning', 5)->assertSee("Warning")->pause(2000);
    }

    public function caseSuccess($browser)
    {
        $browser->waitForText('back', 5)
            ->typeSlowly('username', 'test@gmail.com')
            ->typeSlowly('password', '123456')
            ->press('.btn_submit')
            ->waitForText('Dashboard', 5)
            ->assertSee("Dashboard");
    }
}
