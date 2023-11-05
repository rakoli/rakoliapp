<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\VasTask;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\SystemIncomeStatusEnum;
use App\Utils\Enums\TaskTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VasTask>
 */
class VasTaskFactory extends Factory
{
    protected $model = VasTask::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_code' => fake()->randomElement(['TZ', 'KE']),
            'vas_business_code' => Business::where('type',BusinessTypeEnum::VAS->value)->first()->code,
            'code' => Str::random(10),
            'time_start' => now()->subHours(random_int(5,24)),
            'time_end' => fake()->randomElement([now()->addHours(random_int(16,48)), null]),
            'task_type' => fake()->randomElement(TaskTypeEnum::class),
            'description' => fake()->sentence,
        ];
    }
}
