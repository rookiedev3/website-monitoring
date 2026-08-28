<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Website>
 */
class WebsiteFactory extends Factory
{
    protected $model = Website::class;

    public function definition(): array
    {
        return [
            'customer_name' => fake()->company(),
            'website_name' => fake()->domainWord(),
            'domain' => fake()->domainName(),
            'url' => fake()->url(),
            'category' => fake()->randomElement(['company', 'ecommerce', 'internal']),
            'monitoring_status' => 'active',
            'check_interval' => 5,
            'timeout_seconds' => 10,
        ];
    }
}