<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate();
        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(),
                [
                    'first_name' => ['required', 'string', 'min:1', 'max:255'],
                    'last_name' => ['required', 'string', 'min:1', 'max:255'],
                    'email' => ['required', 'email', 'unique:users,email'],
                    'password' => ['required', 'string', 'min:8', 'max:255'],
                ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            $inputs = $validator->validated();
            $inputs ['password'] = Hash::make($inputs['password']);
            $user = User::create($inputs);

        } catch (\throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return response()->json([
                'message' => 'something is wrong try again later! ',
            ], 500);
        }

        return response()->json([
            'messages' => 'user created successfully',
            'data' => $user
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(),
                [
                    'first_name' => ['required', 'string', 'min:1', 'max:255'],
                    'last_name' => ['required', 'string', 'min:1', 'max:255'],
                    'email' => ['required', 'email', 'unique:users,email',Rule::unique('users','email')
                        ->ignore($user->id)],
                    'password' => ['nullable', 'string', 'min:8', 'max:255'],
                ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            $inputs = $validator->validated();
            if (isset($inputs['password']))
                $inputs ['password'] = Hash::make($inputs['password']);

            $user->update($inputs);

        } catch (\throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return response()->json([
                'message' => 'something is wrong try again later! ',
            ], 500);
        }

        return response()->json([
            'messages' => 'user updated successfully',
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (\throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return response()->json([
                'message' => 'something is wrong try again later! ',
            ], 500);
        }

        return response()->json([
            'messages' => 'user deleted successfully',
        ], 200);
    }
}
