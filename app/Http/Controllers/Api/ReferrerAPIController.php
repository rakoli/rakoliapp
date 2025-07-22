<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Business;
use App\Models\Shift;
use App\Models\ReferrerPayment;

class ReferrerAPIController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['singleSignOn']);
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if (!$user || !in_array($user->type, ['admin'])) {
                return response()->json(['error' => 'Unauthorized. Insufficient permissions.'], 403);
            }
            return $next($request);
        })->except(['singleSignOn']);
    }

    public function singleSignOn(Request $request){
         $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (\Auth::attempt($credentials)) {
            $user = \Auth::user();

           /*  if (!$user->canAccessMobileApp()) {
                return responder()->error('unauthorized');
            } */

            $token = $user->createToken('auth_token')->plainTextToken;

            return responder()->success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => getApiSessionData($user)
            ]);

        } else {
            return responder()->error('unauthorized');
        }
    }
    public function getReferrals()
    {
        $users = User::where('type', 'sales')->get();
        if ($users->isEmpty()) {
            return response()->json(['error' => 'No sales users found'], 404);
        }

        $result = $users->map(function ($user) {
            $referredBusinessesCount = Business::where('referral_business_code', $user->business_code)->count();
            $reg_earnings = 1000 * $referredBusinessesCount;
            return [
                'user' => $user,
                'referred_businesses_count' => $referredBusinessesCount,
                'registration_earnings' => $reg_earnings
            ];
        });

        return response()->json($result);
    }

    public function getReferralUser(Request $request)
    {
        $sales_user = User::where('code', $request->code)->get();
        if ($sales_user->isEmpty()) {
            return response()->json(['error' => 'No sales users found'], 404);
        }
        return response()->json($sales_user);
    }

    public function getReferredBusinesses()
    {
        $users = User::where('type', 'sales')->get();
        if ($users->isEmpty()) {
            return response()->json(['error' => 'No sales users found'], 404);
        }

        $businesses = Business::whereIn('referral_business_code', $users->pluck('business_code'))->get();

        return response()->json($businesses);
    }


    public function referredBusinessShiftActivities(Request $request)

    {
        $users = User::where('type', 'sales')->get();
        if ($users->isEmpty()) {
            return response()->json(['error' => 'No sales users found'], 404);
        }

        $result = $users->map(function ($user) use ($request) {
            $referredBusinessesCount = Business::where('referral_business_code', $user->business_code)->count();
            $referredBusinessShiftsCount = Shift::whereIn('business_code', Business::where('referral_business_code', $user->business_code)->pluck('code'))->count();

            // Get referred businesses with their registration dates
            $referredBusinesses = Business::where('referral_business_code', $user->business_code)->get();

            $firstWeekShiftsCount = 0;
            $secondWeekShiftsCount = 0;

            foreach ($referredBusinesses as $business) {
                $registrationDate = $business->created_at;
                $firstWeekEnd = $registrationDate->copy()->addDays(7);
                $secondWeekStart = $firstWeekEnd->copy();
                $secondWeekEnd = $secondWeekStart->copy()->addDays(7);

                // First week shifts (day 0-7 since registration)
                $firstWeekShiftsCount += Shift::where('business_code', $business->code)
                    ->whereBetween('created_at', [$registrationDate, $firstWeekEnd])
                    ->count();

                // Second week shifts (day 8-14 since registration)
                $secondWeekShiftsCount += Shift::where('business_code', $business->code)
                    ->whereBetween('created_at', [$secondWeekStart, $secondWeekEnd])
                    ->count();
            }

            $reg_earnings = 1000 * $referredBusinessesCount;
            $firstWeekEarnings = 0;
            $secondWeekEarnings = 0;
            /* if ($referredBusinessesCount > 10) {
                $reg_earnings += 1000; // Bonus for more than 10 referrals
            } */
            if ($firstWeekShiftsCount >= 7) {
                $firstWeekEarnings += 500; // Bonus for more than 7 shifts in the first week
            }
            if($secondWeekShiftsCount >= 7) {
                $secondWeekEarnings += 500; // Bonus for more than 7 shifts in the second week
            }

            $totalEarnings = $reg_earnings + $firstWeekEarnings + $secondWeekEarnings;
            return [
                'user' => $user,
                'referred_businesses_count' => $referredBusinessesCount,
                'registration_earnings' => $reg_earnings,
                'referred_business_shifts_count' => $referredBusinessShiftsCount,
                'first_week_shifts_count' => $firstWeekShiftsCount,
                'first_week_earnings' => $firstWeekEarnings,
                'second_week_shifts_count' => $secondWeekShiftsCount,
                'second_week_earnings' => $secondWeekEarnings,
                'total_earnings' => $totalEarnings,
            ];
        });

        return response()->json($result);

    }    public function referrerPayments(Request $request){
        //This manages the referrer payments
        $users = User::where('type', 'sales')->get();

        if ($users->isEmpty()) {
            return response()->json(['error' => 'No sales users found'], 404);
        }

        $period = $request->get('period', date('Y-m'));
        $action = $request->get('action', 'calculate');

        $paymentsData = [];

        if ($period === 'all') {
            foreach ($users as $user) {
                // Get all referred businesses for this user
                $referredBusinesses = Business::where('referral_business_code', $user->business_code)->get();

                $registrationEarnings = count($referredBusinesses) * 1000;
                $firstWeekEarnings = 0;
                $secondWeekEarnings = 0;

                foreach ($referredBusinesses as $business) {
                    $registrationDate = $business->created_at;
                    $firstWeekEnd = $registrationDate->copy()->addDays(7);
                    $secondWeekEnd = $registrationDate->copy()->addDays(14);

                    // First week shifts
                    $firstWeekShifts = Shift::where('business_code', $business->code)
                        ->whereBetween('created_at', [$registrationDate, $firstWeekEnd])
                        ->count();
                    if ($firstWeekShifts >= 7) {
                        $firstWeekEarnings += 500;
                    }

                    // Second week shifts
                    $secondWeekShifts = Shift::where('business_code', $business->code)
                        ->whereBetween('created_at', [$firstWeekEnd, $secondWeekEnd])
                        ->count();
                    if ($secondWeekShifts >= 7) {
                        $secondWeekEarnings += 500;
                    }
                }

                $totalEarnings = $registrationEarnings + $firstWeekEarnings + $secondWeekEarnings;

                $paymentsData[] = [
                    'user' => $user,
                    'registration_earnings' => $registrationEarnings,
                    'first_week_earnings' => $firstWeekEarnings,
                    'second_week_earnings' => $secondWeekEarnings,
                    'total_earnings' => $totalEarnings
                ];
            }
            return response()->json([
                'payments' => $paymentsData,
                'action' => $action,
                'period' => $period
            ]);
        } else {
            $periods = [$period];
            foreach ($users as $user) {
                foreach ($periods as $per) {
                    // Get referred businesses registered in this period
                    $referredBusinesses = Business::where('referral_business_code', $user->business_code)
                        ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$per])
                        ->get();

                    $registrationEarnings = count($referredBusinesses) * 1000;

                    // First week bonuses
                    $firstWeekEarnings = 0;
                    $secondWeekEarnings = 0;

                    foreach ($referredBusinesses as $business) {
                        $registrationDate = $business->created_at;
                        $firstWeekEnd = $registrationDate->copy()->addDays(7);
                        $secondWeekEnd = $registrationDate->copy()->addDays(14);

                        // First week shifts
                        $firstWeekShifts = Shift::where('business_code', $business->code)
                            ->whereBetween('created_at', [$registrationDate, $firstWeekEnd])
                            ->count();

                        if ($firstWeekShifts >= 7) {
                            $firstWeekEarnings += 500;
                        }

                        // Second week shifts
                        $secondWeekShifts = Shift::where('business_code', $business->code)
                            ->whereBetween('created_at', [$firstWeekEnd, $secondWeekEnd])
                            ->count();

                        if ($secondWeekShifts >= 7) {
                            $secondWeekEarnings += 500;
                        }
                    }

                    $totalEarnings = $registrationEarnings + $firstWeekEarnings + $secondWeekEarnings;

                    // If action is 'process', create payment records
                    if ($action === 'process') {
                        if ($registrationEarnings > 0) {
                            ReferrerPayment::create([
                                'user_code' => $user->code,
                                'amount' => $registrationEarnings,
                                'payment_type' => 'registration',
                                'period' => $per,
                                'status' => 'pending'
                            ]);
                        }

                        if ($firstWeekEarnings > 0) {
                            ReferrerPayment::create([
                                'user_code' => $user->code,
                                'amount' => $firstWeekEarnings,
                                'payment_type' => 'first_week',
                                'period' => $per,
                                'status' => 'pending'
                            ]);
                        }

                        if ($secondWeekEarnings > 0) {
                            ReferrerPayment::create([
                                'user_code' => $user->code,
                                'amount' => $secondWeekEarnings,
                                'payment_type' => 'second_week',
                                'period' => $per,
                                'status' => 'pending'
                            ]);
                        }
                    }

                    $paymentsData[] = [
                        'user' => $user,
                        'registration_earnings' => $registrationEarnings,
                        'first_week_earnings' => $firstWeekEarnings,
                        'second_week_earnings' => $secondWeekEarnings,
                        'total_earnings' => $totalEarnings,
                        'period' => $per
                    ];
                }
            }
            return response()->json([
                'payments' => $paymentsData,
                'action' => $action,
                'period' => $period
            ]);
        }
    }

    // Get payment history for all or specific user
    public function getPaymentHistory(Request $request) {
        $userCode = $request->get('user_code');
        $period = $request->get('period');
        $status = $request->get('status');

        $query = ReferrerPayment::query();

        if ($userCode) {
            $query->where('user_code', $userCode);
        }

        if ($period) {
            $query->where('period', $period);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $payments = $query->with('user')->orderBy('created_at', 'desc')->get();

        return response()->json($payments);
    }

    // Mark payments as paid
    public function markPaymentsAsPaid(Request $request) {
        $referrerId = $request->get('referrer_id');
        $period = $request->get('period');
        $notes = $request->get('notes');

        // Validate required parameters
        if (!$referrerId || !$period) {
            return response()->json(['error' => 'referrer_id and period are required'], 400);
        }

        // Get the referrer user
        $referrer = User::find($referrerId);
        if (!$referrer || $referrer->type !== 'sales') {
            return response()->json(['error' => 'Referrer not found or not a sales user'], 404);
        }

        // Find all pending payments for this referrer and period
        $existingPayments = ReferrerPayment::where('user_code', $referrer->code)
            ->where('period', $period)
            ->where('status', 'pending')
            ->get();

        if ($existingPayments->isEmpty()) {
            return response()->json([
                'error' => 'No pending payment records found for this referrer and period'
            ], 404);
        }

        // Update all matching payments to paid
        $updatedCount = ReferrerPayment::where('user_code', $referrer->code)
            ->where('period', $period)
            ->where('status', 'pending')
            ->update([
                'status' => 'paid',
                'notes' => $notes,
                'paid_at' => now()
            ]);

        return response()->json([
            'message' => 'Payments marked as paid successfully',
            'updated_count' => $updatedCount,
            'payments_updated' => $existingPayments->map(function($payment) {
                return [
                    'id' => $payment->id,
                    'amount' => $payment->amount,
                    'payment_type' => $payment->payment_type,
                    'period' => $payment->period
                ];
            })
        ]);
    }

    // Create referrer payment record manually
    public function createReferrerPayment(Request $request) {
        $request->validate([
            'referrer_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:registration,first_week,second_week',
            'period' => 'required|string', // Format: YYYY-MM
            'notes' => 'nullable|string'
        ]);

        // Get the referrer user
        $referrer = User::find($request->referrer_id);
        if (!$referrer || $referrer->type !== 'sales') {
            return response()->json(['error' => 'Referrer not found or not a sales user'], 404);
        }

        $payment = ReferrerPayment::create([
            'user_code' => $referrer->code,
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
            'period' => $request->period,
            'status' => 'pending',
            'notes' => $request->notes
        ]);

        return response()->json([
            'message' => 'Payment record created successfully',
            'payment' => $payment->load('user')
        ], 201);
    }

    // Get all referrer payment records
    public function getAllReferrerPayments(Request $request) {
        $query = ReferrerPayment::with('user');

        // Optional filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('period')) {
            $query->where('period', $request->period);
        }

        if ($request->has('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        if ($request->has('referrer_id')) {
            $referrer = User::find($request->referrer_id);
            if ($referrer) {
                $query->where('user_code', $referrer->code);
            }
        }

        $payments = $query->orderBy('created_at', 'desc')->get();

        return response()->json($payments);
    }
}
