<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\error;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('oauth');
    // }

    public function index(Request $request) {
        $users = User::get();

        if ($request->search) {
            $users = User::where('name', 'LIKE', "%$request->search%")->orwhere('email', 'LIKE', "%$request->search%")->get();
        }
        return $this->success('Users Found', $users, 201);
    }

    public function store(Request $request) {
        $this->validateRequest($request);
        $input = $request->all();
        $user = User::create([
            'email' => $input['email'],
            'name' => $input['name'],
            'role' => $input['role'],
            'password'=> Hash::make($request->get('password'))
        ]);

        return $this->success('User '.$user->name.' has been created', $user, 201);
    }

    public function show($id) {
        $user = User::find($id);
        if(!$user){
            return $this->error('User not found', 404);
        }
        return $this->success('User Found', $user, 200);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);
        if(!$user){
            return $this->error('User not found', 404);
        }
        $this->validateRequest($request);
        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user->update($input);

        return $this->success('User '.$user->name.' has been updated', $user, 200);
    }
    public function destroy($id) {
        $user = User::find($id);
        if(!$user){
            return $this->error('User not found', 404);
        }
        $user->delete();
        return $this->success('User '.$user->name.' has been deleted', $user, 200);
    }

    public function validateRequest(Request $request) {
        $rules = [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'name' => 'required',
            'role' => 'required'
        ];
        $this->validate($request, $rules);
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
