<?php

namespace Tests\Unit;

use App\Models\Redirect;
use App\Models\RedirectLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QueryParamsTest extends TestCase
{
    public function test_merge_query_params()
    {
        $redirect = Redirect::factory()->create(['query_params' => ['utm_source' => 'facebook']]);
        $log = RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'query_params' => ['utm_campaign' => 'ads']]);

        $expectedParams = ['utm_source' => 'facebook', 'utm_campaign' => 'ads'];
        $this->assertEquals($expectedParams, $log->parsedQueryParams);

        $redirect = Redirect::factory()->create(['query_params' => ['utm_source' => 'facebook']]);
        $log = RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'query_params' => ['utm_source' => 'instagram', 'utm_campaign' => 'ads']]);

        $expectedParams = ['utm_source' => 'instagram', 'utm_campaign' => 'ads'];
        $this->assertEquals($expectedParams, $log->parsedQueryParams);

        $redirect = Redirect::factory()->create(['query_params' => ['utm_source' => 'facebook']]);
        $log = RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'query_params' => ['utm_source' => '', 'utm_campaign' => 'test']]);

        $expectedParams = ['utm_source' => 'facebook', 'utm_campaign' => 'test'];
        $this->assertEquals($expectedParams, $log->parsedQueryParams);
    }
}