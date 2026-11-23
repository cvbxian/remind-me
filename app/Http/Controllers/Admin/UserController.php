<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('activities')->orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $activities = $user->activities()
            ->orderBy('activity_date')
            ->orderBy('activity_time')
            ->get();

        return view('admin.users.show', compact('user', 'activities'));
    }
}