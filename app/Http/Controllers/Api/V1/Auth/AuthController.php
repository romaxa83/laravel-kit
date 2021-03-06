<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\DTO\User\UserDto;
use App\Http\Controllers\Api\ApiController;
use App\Http\Request\Api\V1\Auth\LoginRequest;
use App\Http\Request\Api\V1\Auth\SignUpRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Models\User\User;
use App\Repositories\User\UserRepository;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected UserService $userService,
    )
    {
        parent::__construct();
    }

    public function signUp(SignUpRequest $request): JsonResponse
    {
        $dto = UserDto::byArgs($request->all());

        try {
            $user = $this->userService->create($dto);

            return static::successJsonMessage(
                UserResource::make($user),
                Response::HTTP_CREATED
            );
        } catch (\Throwable $e){
            return static::errorJsonMessage($e->getMessage(), $e->getCode());
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');

        /** @var  $user User */
        $user = $this->userRepository->getBy('email', $email);

        if(!$user){
            return static::errorJsonMessage(__('message.user_wrong_login'), Response::HTTP_NOT_FOUND);
        }

        if(!password_verify($password, $user->password)){
            return static::errorJsonMessage(__('message.user_wrong_password'), Response::HTTP_BAD_REQUEST);
        }

        $token = $user->createToken('admin');

        return static::successJsonMessage($token->plainTextToken);
    }

    public function me(): JsonResponse
    {
        return static::successJsonMessage(
            UserResource::make(Auth::user())
        );
    }
}
