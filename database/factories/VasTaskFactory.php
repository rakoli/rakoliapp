<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Country;
use App\Models\VasTask;
use App\Utils\Enums\TaskTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VasTask>
 */
class VasTaskFactory extends Factory
{
    protected $model = VasTask::class;

    public function definition(): array
    {
        $countries = Country::get('code')->toArray();
        $countryCode = null;
        if (empty($countries)) {
            $countryCode = Country::factory()->create()->code;
        } else {
            $countryCode = fake()->randomElement($countries)['code'];
        }

        $businesses = Business::get('code')->toArray();
        $businessCode = null;
        if (empty($businesses)) {
            $businessCode = Business::factory()->create()->code;
        } else {
            $businessCode = fake()->randomElement($businesses)['code'];
        }

        return [
            'country_code' => $countryCode,
            'vas_business_code' => $businessCode,
            'code' => Str::random(10),
            'time_start' => now()->subHours(random_int(5, 24)),
            'time_end' => fake()->randomElement([now()->addHours(random_int(16, 48)), null]),
            'task_type' => fake()->randomElement(TaskTypeEnum::class),
            'description' => fake()->sentence,
            'no_of_agents' => random_int(1,10),
            'is_public' => fake()->randomElement([0,1]),
        ];
    }
}
