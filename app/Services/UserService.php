<?php

namespace App\Services;

use App\Models\User;
use App\Traits\GeneralHelperTrait;
use Illuminate\Support\Facades\Hash;

class UserService
{
    use GeneralHelperTrait;

    /**
     * @param array $data
     * @return array
     * @throws \ErrorException
     *
     */
    public function createUser(array $data): array
    {
        try {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->role = User::ROLES['customer'];
            $user->uniqueUserId = $this->generateUniqueId();
            $user->save();

            $result['message'] = 'User Registered Successfully';
            $result['user'] = $user;
            $result['accessToken'] = $user->createToken('userRegisteredToken')->plainTextToken;

            return $result;
        } catch (\Exception $e) {
            throw new \ErrorException("Unable to Register User");
        }
    }
}
