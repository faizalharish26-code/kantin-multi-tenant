<?php

namespace Database\Factories;

use App\Models\Canteen;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'canteen_id' => Canteen::factory(),
            'code' => strtoupper(fake()->unique()->lexify('TN???')),
            'slug' => fake()->unique()->slug(2),
            'display_name' => fake()->company(),
            'status' => 'active',
        ];
    }
}
