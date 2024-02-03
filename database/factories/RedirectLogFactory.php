<?php

// database/factories/RedirectLogFactory.php

namespace Database\Factories;

use App\Models\RedirectLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedirectLogFactory extends Factory
{
    protected $model = RedirectLog::class;

    public function definition()
    {
        return [
            'redirect_id' => Redirect::factory(),
            'ip' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
            'referer' => $this->faker->url,
            'query_params' => json_encode(['utm_source' => 'facebook', 'utm_campaign' => 'ads']),
            'access_time' => now(),
        ];
    }
}
