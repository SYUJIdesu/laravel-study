<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function show()
    {
        return inertia('User/Show');
    }
}
