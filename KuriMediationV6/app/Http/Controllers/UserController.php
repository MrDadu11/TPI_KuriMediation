<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /** 
     * 
     * Controller for different users CRUD
     * 
     * **/

    // Function that return the list of users page
    public function index(){

    return view('users', [
        'users' => User::all(),
    ]);
    }

    // Function that returns the editing page based on the user's id
    public function edit($userId){
        
        $user = DB::table('users')->where('id', $userId)->first();
        
        return view('users/edit_user', [
            'selectedUser' => $user,
        ]);
        
    }
    
    // Function that updates the selected user's informations based on the user's id
    public function update(Request $request, $userId){
        // Get the user
        $user = User::find($userId);
        
        // Validate the data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'isAdmin' => 'required|boolean'
        ]);
        
        // Check if password fields are filled out
        if (!empty($request->get('password')) || !empty($request->get('passwordConfirm'))) {
            // Validate the password and checks that both match otherwise the user gets redirected back with an error
            if ($request->get('password') === $request->get('passwordConfirm')) {
                $validatedData['password'] = Hash::make($request->get('password'));
            } else {
                return redirect()->back()->withErrors(['passwordConfirm' => ['Les mots de passes ne sont pas semblabes']]);
            }
        }
        // Update the data
        $user->update($validatedData);
        
        // Redirect to the user list
        return redirect()->route('user.index');
    }

    // Function that delete the user based on the id
    public function destroy($userId){
    
    User::destroy($userId);
    
    return redirect()->route('user.index');
    }
}
