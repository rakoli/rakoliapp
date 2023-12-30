<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\VasContract;
use App\Models\VasTask;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\TaskTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VasContract>
 */
class VasContractFactory extends Factory
{
    protected $model = VasContract::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tasks = VasTask::get('code')->toarray();
        if ($tasks == null){
            $tasks = VasTask::factory()->count(2)->create()->toArray();
        }
        return [
            'code' => Str::random(10),
            'country_code' => fake()->randomElement(['TZ', 'KE']),
            'vas_business_code' => Business::where('type',BusinessTypeEnum::VAS->value)->first()->code,
            'agent_business_code' => Business::where('type',BusinessTypeEnum::AGENCY->value)->first()->code,
            'vas_task_code' => fake()->randomElement($tasks)['code'],
            'title' => fake()->sentence,
            'time_start' => now()->subHours(random_int(5,24)),
            'time_end' => fake()->randomElement([now()->addHours(random_int(16,48)), null]),
        ];
    }
}
