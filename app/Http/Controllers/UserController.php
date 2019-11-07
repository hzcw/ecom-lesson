<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function getUsers(){
        $roles=Role::get();
        $users=User::get();
        return view('users/all')->with(['roles'=>$roles,'users'=>$users]);
    }
    public function postAssignUserRole(Request $request){
        $user_id=$request['user_id'];
        $role=$request['role'];
        $user=User::whereId($user_id)->firstOrFail();
        $user->syncRoles($role);
        return redirect()->back()->with('info','The selected user role have been changed');
    }
    public function getDeleteUser($id){
        $user_id=User::whereId($id)->firstOrFail();
        $user_id->delete();
        return redirect()->back()->with('info','The selected user information have been deleted');


    }
    public function getUpdateUser(Request $request){
        $id=$request['user_id'];
        $user=User::whereId($id)->firstOrFail();
        $user->name=$request['user_name'];
        $user->email=$request['email'];
        $user->update();
        return redirect()->back()->with('info','The selected user information have been updated ');

    }
}
