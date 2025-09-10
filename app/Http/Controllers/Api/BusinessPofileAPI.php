<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BusinessPofileAPI extends Controller
{
    /**
     * Update the business profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'business_name' => 'sometimes|required|string|max:255',
            'business_email' => 'sometimes|required|email|max:255',
            'business_phone_number' => 'sometimes|required|string|max:20',
            'business_location' => 'sometimes|string|max:500',
            'business_regno' => 'sometimes|string|max:255',
            'tax_id' => 'sometimes|string|max:255',
            'business_reg_date' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get the authenticated user's business
            $user = Auth::user();
            $business = Business::where('code', $user->business_code)->first();

            if (!$business) {
                return response()->json([
                    'success' => false,
                    'message' => 'Business not found'
                ], 404);
            }

            // Update business fields only if they are provided
            if ($request->has('business_name')) {
                $business->business_name = $request->business_name;
            }

            if ($request->has('business_email')) {
                $business->business_email = $request->business_email;
            }

            if ($request->has('business_phone_number')) {
                $business->business_phone_number = $request->business_phone_number;
            }

            if ($request->has('business_location')) {
                $business->business_location = $request->business_location;
            }

            if ($request->has('business_regno')) {
                $business->business_regno = $request->business_regno;
            }

            if ($request->has('tax_id')) {
                $business->tax_id = $request->tax_id;
            }

            if ($request->has('business_reg_date')) {
                $business->business_reg_date = $request->business_reg_date;
            }

            // Update last_seen timestamp
            $business->last_seen = now();

            // Save the changes
            $business->save();

            return response()->json([
                'success' => true,
                'message' => 'Business profile updated successfully',
                'data' => [
                    'id' => $business->id,
                    'code' => $business->code,
                    'business_name' => $business->business_name,
                    'business_email' => $business->business_email,
                    'business_phone_number' => $business->business_phone_number,
                    'business_location' => $business->business_location,
                    'business_regno' => $business->business_regno,
                    'tax_id' => $business->tax_id,
                    'business_reg_date' => $business->business_reg_date,
                    'status' => $business->status,
                    'last_seen' => $business->last_seen,
                    'updated_at' => $business->updated_at
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the business profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the current business profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            // Get the authenticated user's business
            $user = Auth::user();
            $business = Business::where('code', $user->business_code)->first();

            if (!$business) {
                return response()->json([
                    'success' => false,
                    'message' => 'Business not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Business profile retrieved successfully',
                'data' => [
                    'id' => $business->id,
                    'code' => $business->code,
                    'business_name' => $business->business_name,
                    'business_email' => $business->business_email,
                    'business_phone_number' => $business->business_phone_number,
                    'business_location' => $business->business_location,
                    'business_regno' => $business->business_regno,
                    'tax_id' => $business->tax_id,
                    'business_reg_date' => $business->business_reg_date,
                    'type' => $business->type,
                    'status' => $business->status,
                    'is_verified' => $business->is_verified,
                    'balance' => $business->balance,
                    'created_at' => $business->created_at,
                    'updated_at' => $business->updated_at,
                    'last_seen' => $business->last_seen
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the business profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
