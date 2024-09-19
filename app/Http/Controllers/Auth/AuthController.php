<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\ResetPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use App\Notifications\PasswordResetNotification;
use Venturecraft\Revisionable\RevisionableTrait;
class AuthController extends Controller
{
    use RevisionableTrait;
    protected $revisionEnabled = true;
    public function register (Request $request) {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = User::create($fields);
        $token = $user->createToken($request->name);
        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function login (Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        $history = $user->revisionHistory;
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ["message" => "The provided credentials are incorrect."];
        }
        $token = $user->createToken($user->name);
        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }


    public function logout (Request $request) {
        $request->user()->tokens()->delete();
        return ["message" => "You have been successfully logged out!"];
    }

    public function forgot (ForgotPasswordRequest $request): JsonResponse
    {
        $user = User::where('email',$request->email)->first();
        if(!$user || !$user->email){
            return response()->json([
                'message' => 'Incorrect email addres.'
            ], 404);
        }
        $resetPasswordToken = str_pad(random_int(1,9999),4,'0',STR_PAD_LEFT);
        if(!$userPssReset = ResetPassword::where('email', $user->email)->first()){
            ResetPassword::create([
                'email' => $user->email,
                'token'=>$resetPasswordToken
            ]);
        } else {
            $userPssReset->update([
                'email' => $user->email,
                'token' => $resetPasswordToken
            ]);
        }
        $user->notify(new PasswordResetNotification($user,$resetPasswordToken));
        return new JsonResponse(["message" => "A code has been sent in you adress"]);
    }

    public function reset (ResetPasswordRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $user = User::where('email',$request->email)->first();if(!$user || !$user->email)
        if(!$user){
            return response()->json([
                'message' => 'Incorrect email addres.'
            ], 404);
        }
        $resetRequest = ResetPassword::where('email', $user->email)->first();
        if(!$resetRequest || $resetRequest->token != $request->token){
            return response()->json([
                'message' => 'Token mismatch. Try again.'
            ], 404);
        }
        $user->fill([
            'password' => Hash::make($attributes['password'])
        ]);
        $user->save();
        $user->tokens()->delete();
        $resetRequest->delete();
        $token = $user->createToken($user->name)->plainTextToken;


        return response()->json([
        'message' => 'Password reset successfully.',
        ], 201);
    }
}
