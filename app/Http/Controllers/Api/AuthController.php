<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\MainController;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Mail\MyDemoMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\PersonalAccessToken;
use Validator;

class AuthController extends MainController
{
    public function users(){
        $users = User::paginate(15);
        if(auth()->guest()){
            $users->makeHidden(['email', 'phone']);
        }
        return $this->response(['users' => $users]);
    }

    public function search(Request $request){
        $q = ' ';
        $role = ' ';
        if($request->has('q'))
            $q = $request->q;
        if($request->has('role'))
            $role = $request->role;

        $usersQuery = User::where(function($query) use (&$q) {
            $query->orWhere('name', 'LIKE', "%$q%" )->orWhere('email', 'LIKE', "%$q%");
        });
        $users = $role != ' '?$usersQuery->Where('role', $role)->get():$usersQuery->get();
        if(auth()->guest()){
            $users->makeHidden(['email', 'phone']);
        }
        return $this->response(['users' => $users]);
    }

    public function register(UserRegisterRequest $request){
        $user = User::create($request->validated());
        $token = $user->createToken('auth_token');

        return $this->response([
            'token'     =>  $token->plainTextToken,
            'user'      =>  $user
        ], 'Registered successfully');
    }

    public function login(UserLoginRequest $request){
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return $this->error('User is not found', [], self::NOT_FOUND);
        }

        if(! Hash::check($request->password, $user->password)){
            return ['error' => 'Password is wrong'];
        }
        $token = $user->createToken('auth_token');
        return $this->response([
            'token'     =>  $token->plainTextToken,
            'user'      =>  $user
        ], 'Logged in successfully');
    }

    public function loginToken(Request $request){
        $validator = Validator::make($request->all(), [
            'token'    =>  'required',
        ]);

        if($validator->fails()){
            return $this->error('Validation error', ['token' => 'Token is wrong'], self::VALIDATION_ERROR);
        }

        $personalAccessToken = PersonalAccessToken::findToken($request->token);
        if(!$personalAccessToken) {
            return $this->error('Token not found', [], self::NOT_FOUND);
        }

        return $this->response(['user' => $personalAccessToken->tokenable], 'Logged in successfully');
    }

    public function logout(){
        $this->user->tokens()->where('id', $this->user->currentAccessToken()->id)->delete();
        return $this->response([], 'Logged out successfully');
    }

    public function update(UserRegisterRequest $request){
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if(!$user){
            return $this->error('Wizkid is not found', [], self::NOT_FOUND);
        }
        $user->update($data);

        return $this->response(['wizkid' => $user], 'Wizkid updated successfully');
    }

    
    public function destroy(Request $request){
        $validator = Validator::make($request->all(), [
            'email'    =>  'required|email',
        ]);

        if($validator->fails()){
            return $this->error('Validation error', ['email' => 'Wizkid is wrong'], self::VALIDATION_ERROR);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return $this->error('Wizkid is not found', [], self::NOT_FOUND);
        }
        if($user->delete()){
            return $this->response([], 'Wizkid deleted successfully');
        }

        return $this->error('something went wrong, please try again');
    }

    public function fire(Request $request){
        return $this->firing('0', 'Fired successfully', 'Unfortunately, you are fired', $request);
    }

    public function unFire(Request $request){
        return $this->firing('1', 'Unfired successfully', 'Congrats, you are back', $request);
    }

    private function firing(string $fired, string $message, string $emailContent, Request $request){
        $validator = Validator::make($request->all(), [
            'email'    =>  'required|email',
        ]);

        if($validator->fails()){
            return $this->error('Validation error', ['email' => 'Wizkid is wrong'], self::VALIDATION_ERROR);
        }

        if($this->user->role!='boss' || $this->user->email==$request->email){
            return $this->error('You do not have permissions', [], self::FORBIDDEN);
        }

        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return $this->error('Wizkid not found', [], self::NOT_FOUND);
        }
        $user->working = $fired;
        $user->fired_at = now();
        $user->update();
   
        // $details = ['title' => 'Working status', 'message' => $emailContent, 'name' => $user->name];
  
        // Mail::to($user->email)->send(new MyDemoMail($details));

        return $this->response(['wizkid' => $user], $message);
    }
}
