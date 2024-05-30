<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /** 
     * 
     * Controller for different users CRUD
     * 
     * **/


    public function index(){

    return view('users', [
        'users' => User::all(),
    ]);
    }

    public function destroy($userId){

    User::destroy($userId);

    return redirect()->route('user.index');
    }

    public function edit($userId){

    $user = DB::table('users')->where('id', $userId)->first();
    
    return view('users/edit_user', [
        'selectedUser' => $user,
    ]);

    }

    public function update(Request $request, $userId){
        // Gets the user
        $user = User::find($userId);

        // Validates the data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);
        // Validates the password and check that both match otherwise the user gets redirected back with an error
        if($request->get('password') == $request->get('passwordConfirm')){
            $validatedData['password'] = Hash::make($request->get('password'));
        }else{
            return redirect()->back()->withErrors(['passwordConfirm' => ['Les mots de passes ne sont pas semblabes']]);
        }
        // Updates the data
        $user->update($validatedData);

        // Redirects to the user list
        return redirect()->route('user.index');
    }
}
