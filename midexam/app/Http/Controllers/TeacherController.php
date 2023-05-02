<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

Class TeacherController extends Controller {
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function getUsers()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function showUserWithID($id)
    { 
        return User::where('teacherid', '=', $id)->get();
    }

    public function add(Request $request){
        
        $rules = [
            'lastname' => 'required | max:50 | alpha_num',
            'firstname'=> 'required | max:50 | alpha_num',
            'middlename' => 'required | max:50 | alpha_num',
            'age' => 'required|int:gt:18'
        ];

        $this->validate($request,$rules);

        $user = User::create($request->all());
        return response()->json($user, 200);
    }

    public function updateUser(Request $request, $id) { //UPDATE USER
        $rules = [
            'lastname' => 'required | max:50 | alpha_num',
            'firstname'=> 'required | max:50 | alpha_num',
            'middlename' => 'required | max:50 | alpha_num',
            'age' => 'required|int:gt:18'
        ];
    
        $this->validate($request, $rules);
    
        $user = User::findOrFail($id);
    
        $user->fill($request->all());
    
        if ($user->isClean()) {
            return response()->json("At least one value must
            change", 403);
        } else {
            $user->save();
            return response()->json($user, 200);
        }
    
    }

    public function deleteTeacher($id)
    {
        $user = User::where('teacherid', $id)->delete();

        return $user;
    }
}


