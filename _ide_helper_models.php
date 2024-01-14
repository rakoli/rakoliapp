<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\AdsExchangeChat
 *
 * @property int $id
 * @property string $exchange_ads_code
 * @property string $sender_code
 * @property string $message
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ExchangeAds $exchange_ad
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|AdsExchangeChat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdsExchangeChat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdsExchangeChat query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdsExchangeChat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsExchangeChat whereExchangeAdsCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsExchangeChat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsExchangeChat whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsExchangeChat whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsExchangeChat whereSenderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsExchangeChat whereUpdatedAt($value)
 */
	class AdsExchangeChat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Area
 *
 * @property int $id
 * @property string $country_code
 * @property string $region_code
 * @property string $town_code
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeAds> $exchange_ads
 * @property-read int|null $exchange_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location> $locations
 * @property-read int|null $locations_count
 * @property-read \App\Models\Region $region
 * @property-read \App\Models\Towns $town
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasTask> $vas_tasks
 * @property-read int|null $vas_tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder|Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area query()
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereRegionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereTownCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereUpdatedAt($value)
 */
	class Area extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Business
 *
 * @property int $id
 * @property string $country_code
 * @property string $code
 * @property string|null $referral_business_code
 * @property string $type
 * @property int $is_verified
 * @property string $business_name
 * @property string|null $tax_id
 * @property string|null $business_regno
 * @property string|null $business_reg_date
 * @property string|null $business_phone_number
 * @property string|null $business_email
 * @property string|null $package_code
 * @property string|null $package_expiry_at
 * @property string|null $business_location
 * @property string $status
 * @property string $balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasSubmission> $agentsSubmissions
 * @property-read int|null $agents_submissions_count
 * @property-read \App\Models\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeAds> $exchange_ads
 * @property-read int|null $exchange_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeTransaction> $exchange_transactions_owned
 * @property-read int|null $exchange_transactions_owned_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeTransaction> $exchange_transactions_requested
 * @property-read int|null $exchange_transactions_requested_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Loan> $loans
 * @property-read int|null $loans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LocationUser> $location_users
 * @property-read int|null $location_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location> $locations
 * @property-read int|null $locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Network> $networks
 * @property-read int|null $networks_count
 * @property-read \App\Models\Package|null $package
 * @property-read Business|null $parent_referral
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Business> $referrals
 * @property-read int|null $referrals_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShiftNetwork> $shift_networks
 * @property-read int|null $shift_networks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShiftTransaction> $shift_transactions
 * @property-read int|null $shift_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shift> $shifts
 * @property-read int|null $shifts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Short> $shorts
 * @property-read int|null $shorts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasSubmission> $taskSubmissions
 * @property-read int|null $task_submissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\User|null $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasPayment> $vasPaymentsDone
 * @property-read int|null $vas_payments_done_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasContract> $vas_contracts
 * @property-read int|null $vas_contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasContract> $vas_contracts_owned
 * @property-read int|null $vas_contracts_owned_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasFeedback> $vas_feedbacks_agent
 * @property-read int|null $vas_feedbacks_agent_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasFeedback> $vas_feedbacks_vas
 * @property-read int|null $vas_feedbacks_vas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasTaskAvailability> $vas_task_availabilities
 * @property-read int|null $vas_task_availabilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasTask> $vas_tasks
 * @property-read int|null $vas_tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessVerificationUpload> $verificationUploads
 * @property-read int|null $verification_uploads_count
 * @method static \Database\Factories\BusinessFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Business newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Business newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Business query()
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereBusinessEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereBusinessLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereBusinessPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereBusinessRegDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereBusinessRegno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business wherePackageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business wherePackageExpiryAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereReferralBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereUpdatedAt($value)
 */
	class Business extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BusinessVerificationUpload
 *
 * @property int $id
 * @property string $business_code
 * @property string|null $approved_by
 * @property \App\Utils\Enums\BusinessUploadDocumentTypeEnums|null $document_type
 * @property string|null $uploader_name
 * @property string|null $document_name
 * @property string|null $document_path
 * @property int $is_approved
 * @property string|null $approved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business $business
 * @method static \Database\Factories\BusinessVerificationUploadFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload whereDocumentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload whereDocumentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessVerificationUpload whereUploaderName($value)
 */
	class BusinessVerificationUpload extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $currency
 * @property string $dialing_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Area> $areas
 * @property-read int|null $areas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Business> $businesses
 * @property-read int|null $businesses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeAds> $exchange_ads
 * @property-read int|null $exchange_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FinancialServiceProvider> $financial_service_providers
 * @property-read int|null $financial_service_providers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Package> $packages
 * @property-read int|null $packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Region> $regions
 * @property-read int|null $regions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SystemIncome> $system_incomes
 * @property-read int|null $system_incomes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Towns> $towns
 * @property-read int|null $towns_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasContract> $vas_contracts
 * @property-read int|null $vas_contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasFeedback> $vas_feedbacks
 * @property-read int|null $vas_feedbacks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasTask> $vas_tasks
 * @property-read int|null $vas_tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereDialingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExchangeAds
 *
 * @property int $id
 * @property string $country_code
 * @property string $business_code
 * @property string $location_code
 * @property string $code
 * @property string|null $region_code
 * @property string|null $town_code
 * @property string|null $area_code
 * @property string $min_amount
 * @property string $max_amount
 * @property string $currency
 * @property string $status
 * @property string|null $description
 * @property string|null $open_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdsExchangeChat> $ads_exchange_chats
 * @property-read int|null $ads_exchange_chats_count
 * @property-read \App\Models\Area|null $area
 * @property-read \App\Models\Business $business
 * @property-read \App\Models\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeTransaction> $exchange_transactions
 * @property-read int|null $exchange_transactions_count
 * @property-read \App\Models\Location $location
 * @property-read \App\Models\Region|null $region
 * @property-read \App\Models\Towns|null $town
 * @method static \Database\Factories\ExchangeAdsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereAreaCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereLocationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereMaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereMinAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereOpenNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereRegionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereTownCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeAds whereUpdatedAt($value)
 */
	class ExchangeAds extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExchangeTransaction
 *
 * @property int $id
 * @property string $exchange_ads_code
 * @property string $owner_business_code
 * @property string $trader_business_code
 * @property string $type
 * @property string $fsp_code
 * @property string $amount
 * @property string $amount_currency
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business $business
 * @property-read \App\Models\ExchangeAds $exchange_ad
 * @property-read \App\Models\FinancialServiceProvider $financial_service_provider
 * @method static \Database\Factories\ExchangeTransactionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction whereAmountCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction whereExchangeAdsCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction whereFspCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction whereOwnerBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction whereTraderBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExchangeTransaction whereUpdatedAt($value)
 */
	class ExchangeTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FinancialServiceProvider
 *
 * @property int $id
 * @property string $country_code
 * @property string $code
 * @property string $name
 * @property string|null $desc
 * @property string|null $pic
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeTransaction> $exchange_transactions
 * @property-read int|null $exchange_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Network> $networks
 * @property-read int|null $networks_count
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialServiceProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialServiceProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialServiceProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialServiceProvider whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialServiceProvider whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialServiceProvider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialServiceProvider whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialServiceProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialServiceProvider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialServiceProvider wherePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialServiceProvider whereUpdatedAt($value)
 */
	class FinancialServiceProvider extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InitiatedPayment
 *
 * @property int $id
 * @property string $country_code
 * @property string $business_code
 * @property string $code
 * @property string $channel
 * @property string $income_category
 * @property string $description
 * @property string $amount
 * @property string $amount_currency
 * @property string $expiry_time
 * @property string|null $pay_code
 * @property string|null $pay_url
 * @property string $status
 * @property string $channel_ref_name
 * @property string $channel_ref
 * @property string|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business $business
 * @property-read \App\Models\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereAmountCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereChannelRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereChannelRefName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereExpiryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereIncomeCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment wherePayCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment wherePayUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitiatedPayment whereUpdatedAt($value)
 */
	class InitiatedPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Loan
 *
 * @property int $id
 * @property string $business_code
 * @property string $location_code
 * @property int $shift_id
 * @property string $network_code
 * @property string $user_code
 * @property string $code
 * @property \App\Utils\Enums\LoanTypeEnum $type
 * @property \App\Utils\Enums\LoanPaymentStatusEnum $status
 * @property string $amount
 * @property string|null $description
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float $balance
 * @property-read \App\Models\Business $business
 * @property-read \App\Models\Location $location
 * @property-read \App\Models\Network $network
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LoanPayment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Shift $shift
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Loan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereLocationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereNetworkCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereUserCode($value)
 */
	class Loan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LoanPayment
 *
 * @property int $id
 * @property string $loan_code
 * @property string $user_code
 * @property string $amount
 * @property string|null $description
 * @property string|null $notes
 * @property string|null $payment_method
 * @property \Illuminate\Support\Carbon|null $deposited_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Loan $loan
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment whereDepositedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment whereLoanCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPayment whereUserCode($value)
 */
	class LoanPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $business_code
 * @property string $code
 * @property string $name
 * @property string $balance
 * @property string $balance_currency
 * @property string|null $region_code
 * @property string|null $town_code
 * @property string|null $area_code
 * @property string|null $pic
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Area|null $area
 * @property-read \App\Models\Business|null $business
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeAds> $exchange_ads
 * @property-read int|null $exchange_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Loan> $loans
 * @property-read int|null $loans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Network> $networks
 * @property-read int|null $networks_count
 * @property-read \App\Models\Region|null $region
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShiftNetwork> $shift_networks
 * @property-read int|null $shift_networks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShiftTransaction> $shift_transactions
 * @property-read int|null $shift_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shift> $shifts
 * @property-read int|null $shifts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Short> $shorts
 * @property-read int|null $shorts_count
 * @property-read \App\Models\Towns|null $town
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereAreaCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereBalanceCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location wherePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereRegionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereTownCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereUpdatedAt($value)
 */
	class Location extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LocationUser
 *
 * @property int $id
 * @property string $business_code
 * @property string $user_code
 * @property string $location_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business $business
 * @property-read \App\Models\Location $location
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|LocationUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationUser whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationUser whereLocationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationUser whereUserCode($value)
 */
	class LocationUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Network
 *
 * @property int $id
 * @property string $business_code
 * @property string $location_code
 * @property string $fsp_code
 * @property string $code
 * @property string $agent_no
 * @property string $name
 * @property float $balance
 * @property string $balance_currency
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FinancialServiceProvider $agency
 * @property-read \App\Models\Business $business
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Loan> $loans
 * @property-read int|null $loans_count
 * @property-read \App\Models\Location $location
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShiftTransaction> $shift_transactions
 * @property-read int|null $shift_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shift> $shifts
 * @property-read int|null $shifts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Short> $shorts
 * @property-read int|null $shorts_count
 * @method static \Database\Factories\NetworkFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Network newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Network newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Network query()
 * @method static \Illuminate\Database\Eloquent\Builder|Network whereAgentNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Network whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Network whereBalanceCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Network whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Network whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Network whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Network whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Network whereFspCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Network whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Network whereLocationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Network whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Network whereUpdatedAt($value)
 */
	class Network extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Package
 *
 * @property int $id
 * @property string $country_code
 * @property string $name
 * @property string $code
 * @property string $price
 * @property string $price_currency
 * @property int $trial_period_hours
 * @property int $package_interval_days
 * @property int $grace_period_hours
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Business> $businesses
 * @property-read int|null $businesses_count
 * @property-read \App\Models\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PackageFeature> $features
 * @property-read int|null $features_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereGracePeriodHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePackageIntervalDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePriceCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTrialPeriodHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereUpdatedAt($value)
 */
	class Package extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PackageAvailableFeatures
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PackageAvailableFeatures newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageAvailableFeatures newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageAvailableFeatures query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageAvailableFeatures whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageAvailableFeatures whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageAvailableFeatures whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageAvailableFeatures whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageAvailableFeatures whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageAvailableFeatures whereUpdatedAt($value)
 */
	class PackageAvailableFeatures extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PackageFeature
 *
 * @property int $id
 * @property string $package_code
 * @property string $feature_code
 * @property string|null $access
 * @property string|null $feature_value
 * @property int $available
 * @property string|null $description
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PackageAvailableFeatures $feature
 * @property-read \App\Models\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature whereAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature whereFeatureCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature whereFeatureValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature wherePackageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageFeature whereUpdatedAt($value)
 */
	class PackageFeature extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PackageName
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PackageName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageName query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageName whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageName whereUpdatedAt($value)
 */
	class PackageName extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Region
 *
 * @property int $id
 * @property string $country_code
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Area> $areas
 * @property-read int|null $areas_count
 * @property-read \App\Models\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeAds> $exchange_ads
 * @property-read int|null $exchange_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location> $locations
 * @property-read int|null $locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Towns> $towns
 * @property-read int|null $towns_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasTask> $vas_tasks
 * @property-read int|null $vas_tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereUpdatedAt($value)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SentMessage
 *
 * @property int $id
 * @property string $phone
 * @property string $message
 * @property string $sms_provider
 * @property int $sent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SentMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SentMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SentMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|SentMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentMessage wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentMessage whereSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentMessage whereSmsProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentMessage whereUpdatedAt($value)
 */
	class SentMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Shift
 *
 * @property int $id
 * @property string $business_code
 * @property string $location_code
 * @property string $user_code
 * @property int $no
 * @property string $cash_start
 * @property string|null $cash_end
 * @property string $currency
 * @property \App\Utils\Enums\ShiftStatusEnum $status
 * @property string|null $description
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business $business
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Loan> $loans
 * @property-read int|null $loans_count
 * @property-read \App\Models\Location $location
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Network> $networks
 * @property-read int|null $networks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShiftNetwork> $shiftNetworks
 * @property-read int|null $shift_networks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShiftTransaction> $shift_transactions
 * @property-read int|null $shift_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Short> $shorts
 * @property-read int|null $shorts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ShiftFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Shift newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shift newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shift query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereCashEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereCashStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereLocationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift whereUserCode($value)
 */
	class Shift extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShiftNetwork
 *
 * @property int $id
 * @property string $business_code
 * @property string $location_code
 * @property int $shift_id
 * @property string $network_code
 * @property string $balance_old
 * @property string $balance_new
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business $business
 * @property-read \App\Models\Location $location
 * @property-read \App\Models\Network $network
 * @property-read \App\Models\Shift $shift
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftNetwork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftNetwork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftNetwork query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftNetwork whereBalanceNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftNetwork whereBalanceOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftNetwork whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftNetwork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftNetwork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftNetwork whereLocationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftNetwork whereNetworkCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftNetwork whereShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftNetwork whereUpdatedAt($value)
 */
	class ShiftNetwork extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShiftTransaction
 *
 * @property int $id
 * @property string $business_code
 * @property string $location_code
 * @property int $shift_id
 * @property string $network_code
 * @property string $user_code
 * @property string $code
 * @property string $type
 * @property string $amount
 * @property string $amount_currency
 * @property string $balance_old
 * @property string $balance_new
 * @property string $description
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business $business
 * @property-read \App\Models\Location $location
 * @property-read \App\Models\Network $network
 * @property-read \App\Models\Shift $shift
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereAmountCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereBalanceNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereBalanceOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereLocationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereNetworkCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftTransaction whereUserCode($value)
 */
	class ShiftTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Short
 *
 * @property int $id
 * @property string $business_code
 * @property string $location_code
 * @property int $shift_id
 * @property string $type
 * @property string|null $network_code
 * @property string $user_code
 * @property string $code
 * @property string|null $recovery_status
 * @property string|null $recovery_period
 * @property string|null $instalment_amount
 * @property string $amount
 * @property string|null $description
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business $business
 * @property-read \App\Models\Location $location
 * @property-read \App\Models\Network|null $network
 * @property-read \App\Models\Shift $shift
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShortPayment> $short_payments
 * @property-read int|null $short_payments_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Short newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Short newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Short query()
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereInstalmentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereLocationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereNetworkCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereRecoveryPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereRecoveryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Short whereUserCode($value)
 */
	class Short extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShortPayment
 *
 * @property int $id
 * @property string $short_code
 * @property string $user_code
 * @property string $amount
 * @property string|null $description
 * @property string|null $notes
 * @property string|null $payment_method
 * @property string|null $deposited_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Short $shorts
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment whereDepositedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment whereShortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortPayment whereUserCode($value)
 */
	class ShortPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SystemIncome
 *
 * @property int $id
 * @property string $country_code
 * @property string $category
 * @property string $amount
 * @property string $amount_currency
 * @property string $channel
 * @property string $channel_reference
 * @property string|null $channel_timestamp
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country $country
 * @method static \Database\Factories\SystemIncomeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome whereAmountCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome whereChannelReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome whereChannelTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemIncome whereUpdatedAt($value)
 */
	class SystemIncome extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Towns
 *
 * @property int $id
 * @property string $country_code
 * @property string $region_code
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Area> $areas
 * @property-read int|null $areas_count
 * @property-read \App\Models\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeAds> $exchange_ads
 * @property-read int|null $exchange_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location> $locations
 * @property-read int|null $locations_count
 * @property-read \App\Models\Region $region
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasTask> $vas_tasks
 * @property-read int|null $vas_tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder|Towns newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Towns newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Towns query()
 * @method static \Illuminate\Database\Eloquent\Builder|Towns whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Towns whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Towns whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Towns whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Towns whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Towns whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Towns whereRegionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Towns whereUpdatedAt($value)
 */
	class Towns extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $business_code
 * @property string $location_code
 * @property string $user_code
 * @property \App\Utils\Enums\TransactionTypeEnum $type
 * @property \App\Utils\Enums\TransactionCategoryEnum $category
 * @property string $amount
 * @property string|null $amount_currency
 * @property string $balance_old
 * @property string $balance_new
 * @property string $description
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business $business
 * @property-read \App\Models\Location $location
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\TransactionsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmountCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBalanceNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBalanceOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereLocationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUserCode($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $country_code
 * @property string|null $business_code
 * @property string $type
 * @property string|null $code
 * @property string $fname
 * @property string $lname
 * @property string $phone
 * @property string|null $email
 * @property int $is_super_agent
 * @property int $status
 * @property int $registration_step
 * @property string|null $last_login
 * @property string|null $phone_verified_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property int $should_change_password
 * @property string|null $phone_otp
 * @property string|null $phone_otp_time
 * @property int|null $phone_otp_count
 * @property string|null $email_otp
 * @property string|null $email_otp_time
 * @property int|null $email_otp_count
 * @property string|null $iddoc_type
 * @property string|null $iddoc_id
 * @property string|null $iddoc_path
 * @property int $iddoc_verified
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdsExchangeChat> $ads_exchange_chats
 * @property-read int|null $ads_exchange_chats_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog> $authentications
 * @property-read int|null $authentications_count
 * @property-read \App\Models\Business|null $business
 * @property-read \App\Models\Country $country
 * @property-read string $full_name
 * @property-read \Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog|null $latestAuthentication
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LoanPayment> $loan_payments
 * @property-read int|null $loan_payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Loan> $loans
 * @property-read int|null $loans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location> $locations
 * @property-read int|null $locations_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShiftTransaction> $shift_transactions
 * @property-read int|null $shift_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shift> $shifts
 * @property-read int|null $shifts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShortPayment> $short_payments
 * @property-read int|null $short_payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Short> $shorts
 * @property-read int|null $shorts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasChat> $vas_chats
 * @property-read int|null $vas_chats_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasSubmission> $vas_reviewer_submissions
 * @property-read int|null $vas_reviewer_submissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasSubmission> $vas_submitter_submissions
 * @property-read int|null $vas_submitter_submissions_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailOtpCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailOtpTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIddocId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIddocPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIddocType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIddocVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsSuperAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneOtpCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneOtpTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRegistrationStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereShouldChangePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VasChat
 *
 * @property int $id
 * @property string $vas_contract_code
 * @property string $sender_code
 * @property string $message
 * @property string|null $notes
 * @property mixed|null $attachments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\VasContract $vas_contract
 * @method static \Illuminate\Database\Eloquent\Builder|VasChat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasChat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasChat query()
 * @method static \Illuminate\Database\Eloquent\Builder|VasChat whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasChat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasChat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasChat whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasChat whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasChat whereSenderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasChat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasChat whereVasContractCode($value)
 */
	class VasChat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VasContract
 *
 * @property int $id
 * @property string $code
 * @property string $country_code
 * @property string $vas_business_code
 * @property string $agent_business_code
 * @property string $vas_task_code
 * @property string $time_start
 * @property string|null $time_end
 * @property string $title
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business $business
 * @property-read \App\Models\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasChat> $vas_chats
 * @property-read int|null $vas_chats_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasContractResource> $vas_contract_resources
 * @property-read int|null $vas_contract_resources_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasFeedback> $vas_feedbacks
 * @property-read int|null $vas_feedbacks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasPayment> $vas_payments
 * @property-read int|null $vas_payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasSubmission> $vas_submissions
 * @property-read int|null $vas_submissions_count
 * @property-read \App\Models\VasTask $vas_task
 * @method static \Database\Factories\VasContractFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract query()
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract whereAgentBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract whereTimeEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract whereTimeStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract whereVasBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContract whereVasTaskCode($value)
 */
	class VasContract extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VasContractResource
 *
 * @property int $id
 * @property string|null $vas_contract_code
 * @property string|null $notes
 * @property mixed|null $attachments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\VasContract|null $vas_contract
 * @method static \Illuminate\Database\Eloquent\Builder|VasContractResource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasContractResource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasContractResource query()
 * @method static \Illuminate\Database\Eloquent\Builder|VasContractResource whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContractResource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContractResource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContractResource whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContractResource whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasContractResource whereVasContractCode($value)
 */
	class VasContractResource extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VasFeedback
 *
 * @property-read \App\Models\Business $agent_business
 * @property-read \App\Models\Country $country
 * @property-read \App\Models\Business|null $vas_business
 * @property-read \App\Models\VasContract $vas_contract
 * @property-read \App\Models\VasTask $vas_task
 * @method static \Illuminate\Database\Eloquent\Builder|VasFeedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasFeedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasFeedback query()
 */
	class VasFeedback extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VasPayment
 *
 * @property int $id
 * @property string $business_code
 * @property string|null $vas_contract_code
 * @property string|null $initiator_user_code
 * @property string|null $payee_business_code
 * @property string $code
 * @property string $amount_currency
 * @property string $amount
 * @property string $payment_method
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\VasContract|null $contract
 * @property-read \App\Models\Business|null $payee
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\VasPaymentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment whereAmountCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment whereInitiatorUserCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment wherePayeeBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasPayment whereVasContractCode($value)
 */
	class VasPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VasSubmission
 *
 * @property int $id
 * @property string $vas_contract_code
 * @property string $submitter_user_code
 * @property string|null $reviewer_user_code
 * @property string|null $reviewed_at
 * @property string $status
 * @property mixed|null $attachments
 * @property string|null $description
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\VasContract $vas_contract
 * @method static \Database\Factories\VasSubmissionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission query()
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission whereReviewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission whereReviewerUserCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission whereSubmitterUserCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasSubmission whereVasContractCode($value)
 */
	class VasSubmission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VasTask
 *
 * @property int $id
 * @property string $country_code
 * @property string|null $vas_business_code
 * @property string $code
 * @property string $time_start
 * @property string|null $time_end
 * @property string $description
 * @property string|null $note
 * @property string $task_type
 * @property string|null $region_code
 * @property string|null $town_code
 * @property string|null $area_code
 * @property int $is_public
 * @property int|null $no_of_agents
 * @property mixed|null $attachments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Area|null $area
 * @property-read \App\Models\Business|null $business
 * @property-read \App\Models\Country $country
 * @property-read \App\Models\Region|null $region
 * @property-read \App\Models\Towns|null $town
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasContract> $vas_contracts
 * @property-read int|null $vas_contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasFeedback> $vas_feedbacks
 * @property-read int|null $vas_feedbacks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasTaskAvailability> $vas_task_availabilities
 * @property-read int|null $vas_task_availabilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VasTaskInstruction> $vas_task_instructions
 * @property-read int|null $vas_task_instructions_count
 * @method static \Database\Factories\VasTaskFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask query()
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereAreaCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereNoOfAgents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereRegionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereTaskType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereTimeEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereTimeStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereTownCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTask whereVasBusinessCode($value)
 */
	class VasTask extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VasTaskAvailability
 *
 * @property int $id
 * @property string $vas_task_code
 * @property string $agent_business_code
 * @property string|null $time_start
 * @property string|null $time_end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business|null $business
 * @property-read \App\Models\VasTask $vas_task
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskAvailability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskAvailability newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskAvailability query()
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskAvailability whereAgentBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskAvailability whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskAvailability whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskAvailability whereTimeEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskAvailability whereTimeStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskAvailability whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskAvailability whereVasTaskCode($value)
 */
	class VasTaskAvailability extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VasTaskInstruction
 *
 * @property int $id
 * @property string|null $vas_task_code
 * @property string|null $notes
 * @property mixed|null $attachments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\VasTask|null $vas_task
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskInstruction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskInstruction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskInstruction query()
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskInstruction whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskInstruction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskInstruction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskInstruction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskInstruction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VasTaskInstruction whereVasTaskCode($value)
 */
	class VasTaskInstruction extends \Eloquent {}
}

