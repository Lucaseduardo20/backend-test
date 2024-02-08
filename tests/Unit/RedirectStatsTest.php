<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class RedirectStatsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function test_that_true_is_true()
    // {
    //     $this->assertTrue(true);
    // }

    public function test_unique_accesses_count_for_same_ip_redirects()
    {
        $redirect = Redirect::factory()->create();
        $ip = '192.168.0.1';

        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'ip' => $ip]);
        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'ip' => $ip]);
        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'ip' => $ip]);

        $this->assertEquals(1, $redirect->uniqueAccesses());
    }

    public function test_referer_headers_count()
    {
        $redirect = Redirect::factory()->create();

        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'referer' => 'referer1']);
        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'referer' => 'referer2']);
        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'referer' => 'referer2']);

        $this->assertEquals(2, $redirect->uniqueReferers());
    }

    public function test_accesses_in_last_10_days()
    {
        $redirect = Redirect::factory()->create();

        $today = now();
        for ($i = 0; $i < 10; $i++) {
            RedirectLog::factory()->create([
                'redirect_id' => $redirect->id,
                'created_at' => $today->subDays($i),
            ]);
        }

        $this->assertEquals(10, $redirect->accessesInLast10Days());
    }

    public function test_accesses_in_last_10_days_when_no_accesses()
    {
        $redirect = Redirect::factory()->create();

        $this->assertEquals(0, $redirect->accessesInLast10Days());
    }

    public function test_accesses_only_in_last_10_days()
    {
        $redirect = Redirect::factory()->create();

        $today = now();
        for ($i = 0; $i < 15; $i++) {
            RedirectLog::factory()->create([
                'redirect_id' => $redirect->id,
                'created_at' => $today->subDays($i),
            ]);
        }

        $this->assertEquals(10, $redirect->accessesInLast10Days());
    }

}
