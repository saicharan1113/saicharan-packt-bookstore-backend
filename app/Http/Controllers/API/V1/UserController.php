<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @param UserService $userService
     * @return JsonResponse
     * @throws \ErrorException
     */
    public function register(Request $request, UserService $userService): JsonResponse
    {
        $validatedData = $request->validate(
            [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => [
                    'required',
                    Password::min(8)
                        ->mixedCase()
                        ->letters()
                        ->numbers()
                        ->uncompromised(),
                    'regex:/[!,@,$,#,&]/',
                    'same:confirmPassword'
                ]
            ],
            [
                'password.regex' => 'The :attribute must contain atleast one of [!,@,$,#,&].'
            ]
        );

        $userData = $userService->createUser($validatedData);

        return new JsonResponse(['response' => $userData], Response::HTTP_CREATED);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function login(Request $request): JsonResponse
    {
        $validatedData = $request->validate(
            [
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => ['required']
            ],
            [
                'email.exists' => 'Incorrect email'
            ]
        );

        if (!Auth::attempt($validatedData)) {
            throw new AuthenticationException("Invalid credentials");
        }

        $result['message'] = 'Login success';
        $result['user'] = Auth::user();
        $result['accessToken'] = Auth::user()->createToken('userLoginToken')->plainTextToken;

        return new JsonResponse(['response' => $result], Response::HTTP_OK);

    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return new JsonResponse(['response' => 'User Successfully Logged out'], Response::HTTP_OK);
    }
}
