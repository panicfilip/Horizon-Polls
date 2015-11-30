<?php

namespace App\Repositories;

use App\User;
use App\Question;

class UserRepository
{
    public function getAll()
    {
        return User::with('questions')->get();
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }
}
