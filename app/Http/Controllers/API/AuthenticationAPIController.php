<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationAPIController extends Controller
{
    /**
     * [register description]
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [return description]
     */
    public function register(StoreUserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        unset($input['password_confirmation']);
        try {

            DB::beginTransaction();
            $user = User::create($input);
            DB::commit();

            $result = [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $user->createToken('ApiOaxaca')->plainTextToken,
                'type' => 'Bearer',
            ];

            return $this->sendResponse($result, 'User created susccessfully');
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->sendError($ex->getMessage());
        }
    }

    /**
     * [login description]
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [return description]
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('ApiOaxaca')->plainTextToken;
            $success['type'] = 'Bearer';
            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Login information is invalid.');
        }
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        $user->load('subscription.plan');
        $user->hasActiveSubscription = $user->hasActiveSubscription();
        $user->hasPaidSubscription = $user->hasPaidSubscription();
        return $this->sendResponse($user, 'User retrievied successfully.');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse([], 'The user logged out successfully.');
    }
}
