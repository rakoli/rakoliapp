<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\User;
use App\Models\VasContract;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\TaskSubmissionStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VasSubmission>
 */
class VasSubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $selectedContract = VasContract::factory()->create();
        $submitter = User::factory()->create(['business_code' => $selectedContract->agent_business_code]);
        $reviewer = User::factory()->create(['business_code' => $selectedContract->vas_business_code]);

        return [
            'vas_contract_code' => $selectedContract->code,
            'submitter_user_code' => $submitter->code,
            'reviewer_user_code' => fake()->randomElement([$reviewer->code,null]),
            'reviewed_at' => fake()->randomElement([now()->subHours(random_int(1,18)), null]),
            'status' => fake()->randomElement(TaskSubmissionStatusEnum::class),
        ];
    }
}
