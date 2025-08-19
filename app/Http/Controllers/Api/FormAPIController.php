<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormSubmissionRequest;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class FormAPIController extends Controller
{
    /**
     * Store form submission data
     *
     * @param StoreFormSubmissionRequest $request
     * @return JsonResponse
     */
    public function store(StoreFormSubmissionRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            // Transform camelCase to snake_case for database storage
            $dbData = [
                'sales_rep_name' => $validatedData['salesRepName'],
                'agent_name' => $validatedData['agentName'],
                'phone_number' => $validatedData['phoneNumber'],
                'location' => $validatedData['location'],
                'gps_coordinates' => $validatedData['gpsCoordinates'] ?? null,
                'location_captured' => $validatedData['locationCaptured'] ?? false,
                'business_name' => $validatedData['businessName'],
                'mno_used' => isset($validatedData['mnoUsed']) && is_array($validatedData['mnoUsed']) ? $validatedData['mnoUsed'] : [],
                'other_mno' => $validatedData['otherMno'] ?? null,
                'vodacom_till' => $validatedData['vodacomTill'] ?? null,
                'airtel_till' => $validatedData['airtelTill'] ?? null,
                'tigo_till' => $validatedData['tigoTill'] ?? null,
                'bank_wallet' => $validatedData['bankWallet'] ?? null,
                'visit_outcome' => $validatedData['visitOutcome'],
                'decline_reason' => $validatedData['declineReason'] ?? null,
                'key_concerns' => $validatedData['keyConcerns'] ?? null,
                'suggestions' => $validatedData['suggestions'] ?? null,
                'daily_challenges' => $validatedData['dailyChallenges'] ?? null,
                'rakoli_suggestions' => $validatedData['rakoliSuggestions'] ?? null,
                'agent_signature' => $validatedData['agentSignature'] ?? null,
            ];

            // Save to database
            $formSubmission = FormSubmission::create($dbData);

            return response()->json([
                'success' => true,
                'message' => 'Form submitted successfully',
                'data' => [
                    'id' => $formSubmission->id,
                    'submitted_at' => $formSubmission->created_at->toISOString(),
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Form submission error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the form',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get all form submissions (optional method for retrieving data)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 20);
            $perPage = min($perPage, 100); // Limit to max 100 items per page

            $submissions = FormSubmission::latest()
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Form submissions retrieved successfully',
                'data' => $submissions
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error fetching form submissions: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching form submissions',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get a specific form submission by ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $submission = FormSubmission::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Form submission retrieved successfully',
                'data' => $submission
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Form submission not found',
                'error' => 'No form submission found with ID: ' . $id
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error fetching form submission: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the form submission',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
}
