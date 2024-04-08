<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$users = User::paginate(5);
        $users = DB::table('users')
        ->when($request->input('name'), function($query, $name){
            return $query->where('name', 'like', '%'.$name.'%');
        })->orderBy('id', 'desc')->paginate(5);
        return view('pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        User::create($data);
        return redirect()->route('user.index')->with('success', 'User successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('pages.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $user->update($data);
        return redirect()->route('user.index')->with('success', 'User successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User successfully deleted');
    }
}
