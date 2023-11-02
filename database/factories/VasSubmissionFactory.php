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
        $businessCode = Business::where('type',BusinessTypeEnum::VAS->value)->first()->code;
        $contracts = VasContract::where('vas_provider_code',$businessCode)->get('code')->toArray();
        $selectedContractCode = fake()->randomElement($contracts)['code'];
        $selectedContract = VasContract::where('code',$selectedContractCode)->first();
        $submitter = User::where('business_code',$selectedContract->agent_code)->first();
        $reviewer = User::where('business_code',$selectedContract->vas_provider_code)->first();
        return [
            'vas_contract_code' => $selectedContractCode,
            'submitter_code' => $submitter->code,
            'reviewer_code' => fake()->randomElement([$reviewer->code,null]),
            'reviewed_at' => fake()->randomElement([now()->subHours(random_int(1,18)), null]),
            'status' => fake()->randomElement(TaskSubmissionStatusEnum::class),
        ];
    }
}
