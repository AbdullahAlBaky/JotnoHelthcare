<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CarePlan extends Model { protected $fillable=['patient_id','doctor_id','title','instructions','reminder_at','status']; protected $casts=['reminder_at'=>'datetime']; public function patient(){return $this->belongsTo(Patient::class);} public function doctor(){return $this->belongsTo(User::class,'doctor_id');} }
