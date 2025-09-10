<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Area;
use App\Models\Region;
use App\Models\Towns;
use App\Models\PackageAvailableFeatures;
use App\Models\PackageFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BranchAPIController extends Controller
{
    /**
     * Display a listing of branches for the authenticated business.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $business = auth()->user()->business;

            $query = Location::with(['region', 'town', 'area'])
                ->where('business_code', $business->code);

            // Filter by region if provided
            if ($request->filled('region_code')) {
                $query->where('region_code', $request->region_code);
            }

            // Filter by town if provided
            if ($request->filled('town_code')) {
                $query->where('town_code', $request->town_code);
            }

            // Search by name if provided
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $perPage = $request->get('per_page', 15);
            $branches = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'branches' => $branches->items(),
                    'pagination' => [
                        'current_page' => $branches->currentPage(),
                        'total_pages' => $branches->lastPage(),
                        'total_items' => $branches->total(),
                        'per_page' => $branches->perPage(),
                    ]
                ],
                'message' => 'Branches retrieved successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('BranchAPIController::index - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve branches',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created branch.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Check subscription limit
            if (!validateSubscription("branches", Location::where('business_code', auth()->user()->business_code)->count())) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have exceeded your branch limit. Please upgrade your plan.'
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'capital' => 'required|numeric|min:0',
                'balance' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:255',
                'region_code' => 'nullable|exists:regions,code',
                'town_code' => 'nullable|exists:towns,code',
                'area_code' => 'nullable|exists:areas,code',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = auth()->user();
            $currency = session('currency') ?? $user->business->country->currency;

            $branchData = [
                'business_code' => $user->business_code,
                'name' => $request->name,
                'capital' => $request->capital,
                'balance' => $request->balance,
                'balance_currency' => $currency,
                'description' => $request->description,
                'code' => generateCode($request->name, $user->business_code),
            ];

            // Add location details if provided
            if ($request->filled('region_code')) {
                $branchData['region_code'] = $request->region_code;
            }
            if ($request->filled('town_code')) {
                $branchData['town_code'] = $request->town_code;
            }
            if ($request->filled('area_code')) {
                $branchData['area_code'] = $request->area_code;
            }

            $branch = Location::create($branchData);

            return response()->json([
                'success' => true,
                'data' => $branch->load(['region', 'town', 'area']),
                'message' => 'Branch created successfully'
            ], 201);

        } catch (\Exception $e) {
            Log::error('BranchAPIController::store - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create branch',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified branch.
     */
    public function show($id): JsonResponse
    {
        try {
            $business = auth()->user()->business;
            $branch = Location::with(['region', 'town', 'area', 'networks'])
                ->where('business_code', $business->code)
                ->where('id', $id)
                ->first();

            if (!$branch) {
                return response()->json([
                    'success' => false,
                    'message' => 'Branch not found'
                ], 404);
            }

            // Check authorization
            if (!$branch->isUserAllowed(auth()->user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not authorized to access this branch'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => $branch,
                'message' => 'Branch retrieved successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('BranchAPIController::show - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve branch',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified branch.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $business = auth()->user()->business;
            $branch = Location::where('business_code', $business->code)
                ->where('id', $id)
                ->first();

            if (!$branch) {
                return response()->json([
                    'success' => false,
                    'message' => 'Branch not found'
                ], 404);
            }

            // Check authorization
            if (!$branch->isUserAllowed(auth()->user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not authorized to update this branch'
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|max:255',
                'capital' => 'sometimes|required|numeric|min:0',
                'balance' => 'sometimes|required|numeric|min:0',
                'description' => 'nullable|string|max:255',
                'region_code' => 'nullable|exists:regions,code',
                'town_code' => 'nullable|exists:towns,code',
                'area_code' => 'nullable|exists:areas,code',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $updateData = $request->only(['name', 'capital', 'balance', 'description']);

            // Add location details if provided
            if ($request->has('region_code')) {
                $updateData['region_code'] = $request->region_code;
            }
            if ($request->has('town_code')) {
                $updateData['town_code'] = $request->town_code;
            }
            if ($request->has('area_code')) {
                $updateData['area_code'] = $request->area_code;
            }

            $branch->update($updateData);

            return response()->json([
                'success' => true,
                'data' => $branch->fresh()->load(['region', 'town', 'area']),
                'message' => 'Branch updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('BranchAPIController::update - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update branch',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $business = auth()->user()->business;
            $branch = Location::where('business_code', $business->code)
                ->where('id', $id)
                ->first();

            if (!$branch) {
                return response()->json([
                    'success' => false,
                    'message' => 'Branch not found'
                ], 404);
            }

            // Check authorization
            if (!$branch->isUserAllowed(auth()->user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not authorized to delete this branch'
                ], 403);
            }

            // Soft delete the branch
            $branch->delete();

            return response()->json([
                'success' => true,
                'message' => 'Branch deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('BranchAPIController::destroy - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete branch',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get regions for branch creation/editing.
     */
    public function regions(): JsonResponse
    {
        try {
            $countryCode = session('country_code') ?? auth()->user()->country_code;
            $regions = Region::where('country_code', $countryCode)
                ->select('code', 'name')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $regions,
                'message' => 'Regions retrieved successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('BranchAPIController::regions - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve regions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get towns for a specific region.
     */
    public function towns(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'region_code' => 'required|exists:regions,code',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $towns = Towns::where('region_code', $request->region_code)
                ->select('code', 'name')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $towns,
                'message' => 'Towns retrieved successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('BranchAPIController::towns - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve towns',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get areas for a specific town.
     */
    public function areas(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'town_code' => 'required|exists:towns,code',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $areas = Area::where('town_code', $request->town_code)
                ->select('code', 'name')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $areas,
                'message' => 'Areas retrieved successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('BranchAPIController::areas - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve areas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
