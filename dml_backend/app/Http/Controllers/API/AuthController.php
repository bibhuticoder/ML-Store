<?php
namespace App\Http\Controllers\API;

use Validator;
use App\User;
use \Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Models\CustomerDetail;
use App\Models\ProgrammerDetail;

class AuthController extends BaseController
{

  public function __construct(Request $request)
  {
    $this->request = $request;
    $this->middleware('jwt.auth', ['only' => [
      'me'
    ]]);
  }

  protected function jwt(User $user)
  {
    $payload = [
      'iss' => "dml-marketplace-jwt", // Issuer of the token
      'sub' => $user->id, // Subject of the token
      'iat' => time(), // Time when JWT was issued. 
      'exp' => time() + 60 * 60 * 60 // Expiration time
    ];
    return JWT::encode($payload, env('JWT_SECRET'));
  }

  public function authenticate()
  {
    $this->validate($this->request, [
      'email'     => 'required|email',
      'password'  => 'required'
    ]);

    // Find User by Email
    $user = User::where('email', $this->request->input('email'))->first();
    if (!$user) {
      return response()->json([
        'message' => 'Email does not exist.'
      ], 400);
    }

    // Verify the password and generate the token
    if (Hash::check($this->request->input('password'), $user->password)) {
      return response()->json([
        'token' => $this->jwt($user)
      ], 200);
    }

    // Bad Request response
    return response()->json([
      'message' => 'Email or password is wrong.'
    ], 400);
  }

  public function register(Request $request)
  {
    $this->validate($this->request, [
      'username'      => 'required',
      'email'     => 'required|email|unique:users',
      'password'  => 'required|confirmed|min:6', //password_confirmation field must be present
      'role'      => 'required'
    ]);

    
    return DB::transaction(function () {
      // hash the password
      $passwordHash = Hash::make($this->request->input('password'));
      $role = $this->request->input('role');

      // create user
      $user = User::create([
        'username'  => $this->request->input('username'),
        'email'     => $this->request->input('email'),
        'password'  => $passwordHash,
        'role'      => ($role === 'customer') ? 0 : 1
      ]);

      // give default profile_pic for user
      $profile_pic_name = Hash::make($user->user_id . $user->created_at) . '.png';
      Storage::copy('public\\profile_pics\\new_user.png', 'public\\profile_pics\\' . $profile_pic_name);
      $user->update(['profile_pic_path' => $profile_pic_name]);

      // user details
      $user->details()->create(['user_id' => $user->id]);

      return response()->json([
        'token' => $this->jwt($user)
      ], 201);

    });

  }

  public function me()
  {
    return response()->json($this->request->auth);
  }
}
