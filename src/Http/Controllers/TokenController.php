<?php

namespace Mdhesari\LaravelAuth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Mdhesari\LaravelAuth\Actions\CreateUser;
use Mdhesari\LaravelAuth\Actions\SetupToken;
use Mdhesari\LaravelAuth\Http\Requests\LoginRequest;
use Mdhesari\LaravelAuth\Models\User;

class TokenController extends Controller
{
    /**
     * Get login token for user
     *
     * @param  LoginRequest  $request
     * @param  SetupToken  $setupToken
     * @return JsonResponse
     *
     * @throws ValidationException
     * @group User
     */
    public function store(LoginRequest $request, SetupToken $setupToken): JsonResponse
    {
        $user = User::whereEmail($request->email)->firstOrFail();

        if (! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => __('auth.failed'),
            ]);
        }

        $token = $setupToken($user, $request->only('platform'));

        return api()->success(null, compact('user', 'token'));
    }

    /**
     * Delete all access tokens
     *
     * @param  Request  $request
     * @return JsonResponse
     * @group User
     */
    public function destroyAllAccessTokens(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return api()->success();
    }

    /**
     * Delete current access token
     *
     * @param  Request  $request
     * @return JsonResponse
     * @group User
     */
    public function destroyCurrentAccessToken(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return api()->success();
    }

    /**
     * Delete specific access token
     *
     * @param  Request  $request
     * @param  string  $name
     * @return JsonResponse
     * @group User
     */
    public function destroySpecificAccessToken(Request $request, string $name): JsonResponse
    {
        if (! $request->user()->tokens()->where('name', $name)->delete()) {
            return api()->notFound(__('Access token name is invalid.'));
        }

        return api()->success();
    }

    public function google()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function googleCallback(Request $request, CreateUser $createUser, SetupToken $setupToken): \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            throw $e;
        }

        $last_name = explode(' ', $user->name);
        $first_name = '';

        for ($i = 0; $i < count($last_name) - 1; $i++) {
            $first_name = $last_name[$i].' ';
        }

        $first_name = trim($first_name);

        $data = [
            'email' => $user->email,
            'first_name' => $first_name,
            'last_name' => $last_name[count($last_name) - 1],
            'google_id' => $user->id,
            'meta' => [
                'google_avatar' => $user->avatar,
                'google_avatar_original' => $user->avatar_original,
                'google_token' => $user->token,
                'google_token_expire_in' => $user->expiresIn,
            ],
            'email_verified_at' => now(),
        ];

        $user = $createUser($data);

        $token = $setupToken($user, $request->only('platform'));

        return redirect(config('services.google.frontend_redirect').'?'.http_build_query(compact('token')));
    }
}
