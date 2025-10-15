<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Business;
use App\Models\Location;
use App\Models\BusinessRole;
use App\Models\LocationUser;
use App\Models\UserRole;
use App\Utils\ErrorCode;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class UsersAPIController extends Controller
{
    /**
     * Get all users for the authenticated business
     */
    public function index()
    {
        try {
            $businessCode = Auth::user()->business_code;

            $users = User::where('business_code', $businessCode)
                ->whereNull('deleted_at')
                ->select('id', 'fname', 'lname', 'email', 'phone', 'code', 'type', 'registration_step', 'created_at')
                ->get();

            return responder()->success(['users' => $users]);
        } catch (\Exception $e) {
            Log::error('Users API Index Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::RETRIEVE_FAILED, 'Failed to retrieve users', null, 500);
        }
    }

    /**
     * Get a specific user by ID
     */
    public function show($id)
    {
        try {
            $businessCode = Auth::user()->business_code;

            $user = User::where('id', $id)
                ->where('business_code', $businessCode)
                ->whereNull('deleted_at')
                ->first();

            if (!$user) {
                return responder()->error(ErrorCode::NOT_FOUND, 'User not found', null, 404);
            }

            return responder()->success(['user' => $user]);
        } catch (\Exception $e) {
            Log::error('Users API Show Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::RETRIEVE_FAILED, 'Failed to retrieve user', null, 500);
        }
    }

    /**
     * Create a new user
     */
    public function store(Request $request)
    {
        try {
            $authUser = Auth::user();

            $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string',
                'pin' => 'required|string|min:4|max:6',
                'branches' => [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) use ($authUser) {
                        foreach ($value as $locationId) {
                            $locationExists = Location::where('id', $locationId)
                                ->where('business_code', $authUser->business_code)
                                ->whereNull('deleted_at')
                                ->exists();

                            if (!$locationExists) {
                                $fail('One or more selected branches are invalid for your business.');
                                break;
                            }
                        }
                    },
                ],
                'roles' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) use ($authUser) {
                        $roleExists = BusinessRole::where('code', $value)
                            ->where('business_code', $authUser->business_code)
                            ->whereNull('deleted_at')
                            ->exists();

                        if (!$roleExists) {
                            $fail('The selected role is invalid for your business.');
                        }
                    },
                ],
            ]);

            $userData = [
                'country_code' => $authUser->country_code,
                'fname' => $request->fname,
                'lname' => $request->lname,
                'email' => $request->email,
                'phone' => $request->phone,
                'type' => UserTypeEnum::AGENT->value,
                'password' => Hash::make(uniqid('pwd_', true)),
                'pin' => Hash::make($request->pin),
                'business_code' => $authUser->business_code,
                'code' => generateCode($request->fname, $authUser->business_code),
                'registration_step' => 0,
                'phone_verified_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
                'id_verified_at' => Carbon::now(),
            ];

            $newUser = User::create($userData);

            // Assign locations
            foreach ($request->branches as $locationId) {
                $location = Location::where('id', $locationId)
                    ->where('business_code', $authUser->business_code)
                    ->whereNull('deleted_at')
                    ->first();

                if ($location) {
                    LocationUser::create([
                        'user_code' => $newUser->code,
                        'business_code' => $newUser->business_code,
                        'location_code' => $location->code,
                    ]);
                }
            }

            // Assign role
            UserRole::create([
                'user_code' => $newUser->code,
                'business_code' => $newUser->business_code,
                'user_role' => $request->roles,
            ]);

            return responder()->success([
                'message' => 'User created successfully',
                'user' => $newUser
            ]);

        } catch (ValidationException $e) {
            $firstError = collect($e->errors())->flatten()->first();
            return responder()->error(ErrorCode::VALIDATION_FAILED, $firstError, $e->errors(), 422);
        } catch (\Exception $e) {
            Log::error('Users API Store Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::CREATE_FAILED, 'Failed to create user', null, 500);
        }
    }

    /**
     * Update an existing user
     */
    public function update(Request $request, $id)
    {
        try {
            $businessCode = Auth::user()->business_code;

            $user = User::where('id', $id)
                ->where('business_code', $businessCode)
                ->whereNull('deleted_at')
                ->first();

            if (!$user) {
                return responder()->error(ErrorCode::NOT_FOUND, 'User not found', null, 404);
            }

            $request->validate([
                'fname' => 'sometimes|string|max:255',
                'lname' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $id,
                'phone' => 'sometimes|string',
                'password' => 'sometimes|string|min:8',
            ]);

            if ($request->has('fname')) $user->fname = $request->fname;
            if ($request->has('lname')) $user->lname = $request->lname;
            if ($request->has('email')) $user->email = $request->email;
            if ($request->has('phone')) $user->phone = $request->phone;
            if ($request->has('password')) $user->password = Hash::make($request->password);

            $user->save();

            return responder()->success([
                'message' => 'User updated successfully',
                'user' => $user
            ]);

        } catch (ValidationException $e) {
            $firstError = collect($e->errors())->flatten()->first();
            return responder()->error(ErrorCode::VALIDATION_FAILED, $firstError, $e->errors(), 422);
        } catch (\Exception $e) {
            Log::error('Users API Update Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::UPDATE_FAILED, 'Failed to update user', null, 500);
        }
    }

    /**
     * Delete a user (soft delete)
     */
    public function destroy($id)
    {
        try {
            $businessCode = Auth::user()->business_code;

            $user = User::where('id', $id)
                ->where('business_code', $businessCode)
                ->whereNull('deleted_at')
                ->first();

            if (!$user) {
                return responder()->error(ErrorCode::NOT_FOUND, 'User not found', null, 404);
            }

            $user->delete();

            return responder()->success(['message' => 'User deleted successfully']);

        } catch (\Exception $e) {
            Log::error('Users API Delete Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::DELETE_FAILED, 'Failed to delete user', null, 500);
        }
    }

    /**
     * Get available branches and roles for user creation
     */
    public function getFormData()
    {
        try {
            $businessCode = Auth::user()->business_code;

            $branches = Location::where('business_code', $businessCode)
                ->whereNull('deleted_at')
                ->get();

            $roles = BusinessRole::where('business_code', $businessCode)
                ->whereNull('deleted_at')
                ->get();

            return responder()->success([
                'branches' => $branches,
                'roles' => $roles
            ]);

        } catch (\Exception $e) {
            Log::error('Users API Form Data Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::RETRIEVE_FAILED, 'Failed to retrieve form data', null, 500);
        }
    }

    /**
     * Get all roles for the authenticated business
     */
    public function getRoles()
    {
        try {
            $authUser = Auth::user();

            if (!$authUser) {
                return responder()->error(ErrorCode::NOT_FOUND, 'User not authenticated', null, 401);
            }

            $businessCode = $authUser->business_code;

            $roles = BusinessRole::where('business_code', $businessCode)
                ->whereNull('deleted_at')
                ->select('id', 'business_code', 'code', 'name', 'description', 'created_at')
                ->get();

            return responder()->success(['roles' => $roles]);
        } catch (\Exception $e) {
            Log::error('Users API Get Roles Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::RETRIEVE_FAILED, 'Failed to retrieve roles', null, 500);
        }
    }
}
