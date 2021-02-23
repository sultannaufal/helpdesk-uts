<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::paginate(10);
        $manager = User::where('role', 'manager')->get();
        $client = User::where('role', 'client')->get();
        return view('users.index', compact('users', 'manager', 'client'));
    }

    public function create()
    {
        Gate::authorize('create-ticket');
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        Gate::authorize('manage');
        $user = User::make($request->only(['email']));
        $user->name = Str::title($request['name']);
        $user->password = Hash::make($request['password']);
        $user->save();
        return redirect()
            ->route('users.index')
            ->with('toast_success', 'User telah ditambah');
    }

    public function destroy(User $user)
    {
        Gate::authorize('manage');
        $user->delete();
        return redirect()
            ->route('users.index')
            ->with('toast_success', 'User berhasil dihapus');
    }

    public function setAsManager()
    {
        $user->role = Ticket::ROLE_MANAGER;
    }

    public function setAsClient()
    {
        $user->role = Ticket::ROLE_CLIENT;
    }
}
