<?php

namespace App\Models;

class Student extends User
{
    // Student accounts are stored in the existing users table.
    // The Student role distinguishes them from other user accounts.

    protected $table = 'users';
}