<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\QuestionRepository;
use App\User;


class UserController extends Controller
{
    public function __construct(UserRepository $users,
                                QuestionRepository $questions)
    {
        $this->users = $users;
        $this->questions = $questions;
    }

    public function index()
    {
        $data['users'] = User::where("id","!=",\Auth::user()->id)->get();
        return view('users.index')->with($data);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'active' => $data['active'],
            'is_admin' => $data['is_admin'],
        ]);
    }

    public function profile($email)
    {
        $user = $this->users->getUserByEmail($email);

        return view('users.profile', [
            'user' => $user,
            'questions' => $this->questions->getPublicQuestionsByUser($user),
            'private' => $this->questions->getPrivateQuestionsByUser($user)
        ]);
    }

    public function emailConfirmation($data)
    {
            $json   = base64_decode($data);
            $values = json_decode($json);
            
            $user   = User::where("confirmation_code","=",$values->confirmation_code)->where("email","=",$values->email)->first();
            
            if( isset($user->id) && $user->id > 0){
                $user = User::find($user->id);
                $user->update(["active"=>1 ]);
                \Auth::login($user);
        
                return redirect("/")->with("messages", "Welcome, you have been successfully registered!");
            }
    }

    public static function activate($id)
    {
        $user = User::findOrFail($id);
                
        $user->active = 1;
        $user->save();

        return redirect("/users")->with('messages', 'User was activated');
    }

    public static function deactivate($id)
    {
        $user = User::findOrFail($id);
                
        $user->active = 0;
        $user->save();

        return redirect("/users")->with('messages', 'User was deactivated');
    }

    public static function admin($id)
    {
        $user = User::findOrFail($id);
                
        $user->is_admin = 1;
        $user->save();

        return redirect("/users")->with('messages', 'User was given administrator privileges');
    }

    public static function regular($id)
    {
        $user = User::findOrFail($id);
                
        $user->delete();

        return redirect("/users")->with('messages', 'User was deleted');
    }

    public static function delete($id)
    {
        $user = User::findOrFail($id);
                
        $user->delete();

        return redirect("/users")->with('messages', 'User was deactivated');
    }
}
