<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Country;
use App\Models\VasContract;
use App\Models\VasTask;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\TaskTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VasContract>
 */
class VasContractFactory extends Factory
{
    protected $model = VasContract::class;

    public function definition(): array
    {
        $countries = Country::get('code')->toArray();
        $countryCode = null;
        if(isEmpty($countries)){
            $countryCode = Country::factory()->create()->code;
        }else{
            $countryCode = fake()->randomElement($countries)['code'];
        }

        $vasBusinesses = Business::where('type',\App\Utils\Enums\BusinessTypeEnum::VAS->value)->get('code')->toArray();
        $vasBusinessCode = null;
        if(isEmpty($vasBusinesses)){
            $vasBusinessCode = Business::factory(['type'=>\App\Utils\Enums\BusinessTypeEnum::VAS->value])->create()->code;
        }else{
            $vasBusinessCode = fake()->randomElement($vasBusinesses)['code'];
        }

        $agentBusinessArray = Business::where('code','!=',$vasBusinessCode)->where('type',\App\Utils\Enums\BusinessTypeEnum::AGENCY->value)->get(['code']);
        $agentBusinessCode = null;
        if(isEmpty($agentBusinessArray)){
            $agentBusinessCode = Business::factory(['type'=>\App\Utils\Enums\BusinessTypeEnum::AGENCY->value])->create()->code;
        }else{
            $agentBusinessCode = fake()->randomElement($agentBusinessArray->toArray())['code'];
        }

        $vasTaskCode = VasTask::factory()->create(['vas_business_code'=>$vasBusinessCode])->code;


        return [
            'code' => Str::random(10),
            'country_code' => $countryCode,
            'vas_business_code' => $vasBusinessCode,
            'agent_business_code' => $agentBusinessCode,
            'vas_task_code' => $vasTaskCode,
            'title' => fake()->sentence,
            'time_start' => now()->subHours(random_int(5,24)),
            'time_end' => fake()->randomElement([now()->addHours(random_int(16,48)), null]),
        ];
    }
}
