<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function viewUserTasks($id)
    {
        $user = User::findOrFail($id);
        $tasks = $user->tasks;
        return response()->json($tasks);
    }
}
