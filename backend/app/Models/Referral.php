<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Referral extends Model { protected $fillable=['patient_id','doctor_id','specialist_id','department','reason','status','specialist_note']; public function patient(){return $this->belongsTo(Patient::class);} public function specialist(){return $this->belongsTo(User::class,'specialist_id');} public function doctor(){return $this->belongsTo(User::class,'doctor_id');} }
