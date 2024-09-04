<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:4|max:255|confirmed',
        ]);
        $user->update($fields);
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->forceDelete();
        return [
            'message' => 'User was successfully deleted.',
        ];
    }

    /**
     * Remove user to cart
     */
    public function removeToCart(User $user)
    {
        $user->delete();
        return [
            'message' => 'User was successfully moved to cart.',
        ];
    }

    /**
     * All users in cart
     */
    public function usersInCart()
    {
        return User::onlyTrashed()->get();
    }

    /**
     * Recovery user from cart
     */
    public function recoverFromCart(User $user)
    {
        $user->restore();
        return $user;
    }

    /**
     * Remove  to cart group
     */
    public function removeToCartGroup(Request $request)
    {
        $fields = $request->validate([
            'id' => 'required|max:255|array|exists:users,id',
        ]);
        User::whereIn('id', $fields['id'])->delete();

        return [
            'message' => 'Users was successfully moved to cart.',
        ];
    }

    /**
     * Remove users from database
     */
    public function deleteGroup(Request $request)
    {
        $fields = $request->validate([
            'id' => 'required|max:255|array|exists:users,id',
        ]);
        User::whereIn('id', $fields['id'])->forceDelete();

        return [
            'message' => 'Users was successfully moved to cart.',
        ];
    }

    /**
     * Recovery users from cart
     */
    public function recoverGroupFromCart(Request $request)
    {
        $fields = $request->validate([
            'id' => 'required|max:255|array|exists:users,id',
        ]);
        User::whereIn('id', $fields['id'])->restore();

        return [
            'message' => 'Users was successfully recover from cart.',
        ];
    }
}
