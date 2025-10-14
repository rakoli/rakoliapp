<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Area;
use App\Models\Region;
use App\Models\Towns;
use App\Models\PackageAvailableFeatures;
use App\Models\PackageFeature;
use App\Utils\ErrorCode;
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

            return responder()->success([
                'branches' => $branches->items(),
                'pagination' => [
                    'current_page' => $branches->currentPage(),
                    'total_pages' => $branches->lastPage(),
                    'total_items' => $branches->total(),
                    'per_page' => $branches->perPage(),
                ]
            ])->respond();

        } catch (\Exception $e) {
            Log::error('BranchAPIController::index - Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::RETRIEVE_FAILED, 'Failed to retrieve branches', null, 500)->respond();
        }
    }

    /**
     * Store a newly created branch.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Check subscription limit
       /*      if (!validateSubscription("branches", Location::where('business_code', auth()->user()->business_code)->count())) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have exceeded your branch limit. Please upgrade your plan.'
                ], 403);
            } */

                                    $validator = Validator::make($request->all(), [
                'town_id' => 'required|exists:towns,id',
            ]);

            if ($validator->fails()) {
                $firstError = collect($validator->errors()->messages())->flatten()->first();
                return responder()->error(ErrorCode::VALIDATION_FAILED, $firstError, $validator->errors(), 422)->respond();
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

            return responder()->success($branch->load(['region', 'town', 'area']), 201)->respond();

        } catch (\Exception $e) {
            Log::error('BranchAPIController::store - Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::CREATE_FAILED, 'Failed to create branch', null, 500)->respond();
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
                return responder()->error(ErrorCode::NOT_FOUND, 'Branch not found', null, 404)->respond();
            }

            // Check authorization
            if (!$branch->isUserAllowed(auth()->user())) {
                return responder()->error(ErrorCode::ACCESS_DENIED, 'Not authorized to access this branch', null, 403)->respond();
            }

            return responder()->success($branch)->respond();

        } catch (\Exception $e) {
            Log::error('BranchAPIController::show - Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::RETRIEVE_FAILED, 'Failed to retrieve branch', null, 500)->respond();
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
                return responder()->error(ErrorCode::NOT_FOUND, 'Branch not found', null, 404)->respond();
            }

            // Check authorization
            if (!$branch->isUserAllowed(auth()->user())) {
                return responder()->error(ErrorCode::ACCESS_DENIED, 'Not authorized to update this branch', null, 403)->respond();
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
                $firstError = collect($validator->errors())->flatten()->first();
                return responder()->error(ErrorCode::VALIDATION_FAILED, $firstError ?? 'Validation failed', [
                    'errors' => $validator->errors()
                ], 422)->respond();
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

            return responder()->success($branch->fresh()->load(['region', 'town', 'area']))->respond();

        } catch (\Exception $e) {
            Log::error('BranchAPIController::update - Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::UPDATE_FAILED, 'Failed to update branch', null, 500)->respond();
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
                return responder()->error(ErrorCode::NOT_FOUND, 'Branch not found', null, 404)->respond();
            }

            // Check authorization
            if (!$branch->isUserAllowed(auth()->user())) {
                return responder()->error(ErrorCode::ACCESS_DENIED, 'Not authorized to delete this branch', null, 403)->respond();
            }

            // Soft delete the branch
            $branch->delete();

            return responder()->success(['message' => 'Branch deleted successfully'])->respond();

        } catch (\Exception $e) {
            Log::error('BranchAPIController::destroy - Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::DELETE_FAILED, 'Failed to delete branch', null, 500)->respond();
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

            return responder()->success($regions)->respond();

        } catch (\Exception $e) {
            Log::error('BranchAPIController::regions - Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::RETRIEVE_FAILED, 'Failed to retrieve regions', null, 500)->respond();
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
                $firstError = collect($validator->errors())->flatten()->first();
                return responder()->error(422, $firstError ?? 'Validation failed', [
                    'errors' => $validator->errors()
                ], 422)->respond();
            }

            $towns = Towns::where('region_code', $request->region_code)
                ->select('code', 'name')
                ->orderBy('name')
                ->get();

            return responder()->success($towns)->respond();

        } catch (\Exception $e) {
            Log::error('BranchAPIController::towns - Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::RETRIEVE_FAILED, 'Failed to retrieve towns', null, 500)->respond();
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
                $firstError = collect($validator->errors())->flatten()->first();
                return responder()->error(422, $firstError ?? 'Validation failed', [
                    'errors' => $validator->errors()
                ], 422)->respond();
            }

            $areas = Area::where('town_code', $request->town_code)
                ->select('code', 'name')
                ->orderBy('name')
                ->get();

            return responder()->success($areas)->respond();

        } catch (\Exception $e) {
            Log::error('BranchAPIController::areas - Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::RETRIEVE_FAILED, 'Failed to retrieve areas', null, 500)->respond();
        }
    }
}
