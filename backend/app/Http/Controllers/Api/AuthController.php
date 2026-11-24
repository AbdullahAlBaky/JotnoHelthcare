<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; use App\Models\User; use Illuminate\Http\Request; use Illuminate\Support\Facades\Hash; use Illuminate\Validation\Rules\Password;
class AuthController extends Controller {
 public function register(Request $r){$d=$r->validate(['name'=>'required|string|max:120','email'=>'required|email|unique:users,email','password'=>['required','confirmed',Password::min(8)],'role'=>'required|in:patient,caregiver']); $u=User::create($d); if($u->role==='patient') $u->patientProfile()->create([]); return response()->json(['token'=>$u->createToken('web')->plainTextToken,'user'=>$u->load('patientProfile')],201);}
 public function login(Request $r){$d=$r->validate(['email'=>'required|email','password'=>'required']); $u=User::where('email',$d['email'])->first(); if(!$u||!Hash::check($d['password'],$u->password)) return response()->json(['message'=>'Invalid credentials'],422); return response()->json(['token'=>$u->createToken('web')->plainTextToken,'user'=>$u->load('patientProfile')]);}
 public function users(Request $r){abort_unless(in_array($r->user()->role,['doctor','admin']),403);$role=$r->query('role');return User::when($role,fn($q)=>$q->where('role',$role))->select('id','name','email','role')->orderBy('name')->get();} public function me(Request $r){return $r->user()->load('patientProfile');} public function logout(Request $r){$r->user()->currentAccessToken()->delete();return response()->json(['message'=>'Logged out']);}
}
