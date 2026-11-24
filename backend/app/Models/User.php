<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable; use Laravel\Sanctum\HasApiTokens; use Illuminate\Notifications\Notifiable; use Illuminate\Database\Eloquent\Factories\HasFactory;
class User extends Authenticatable { use HasApiTokens, HasFactory, Notifiable; protected $fillable=['name','email','password','role','phone']; protected $hidden=['password','remember_token']; protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed']; } public function patientProfile(){return $this->hasOne(Patient::class,'user_id');} public function caregiverLinks(){return $this->hasMany(CaregiverAccess::class,'caregiver_id');} }
