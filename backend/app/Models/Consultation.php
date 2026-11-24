<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Consultation extends Model { protected $fillable=['patient_id','doctor_id','scheduled_at','meeting_url','status','notes']; protected $casts=['scheduled_at'=>'datetime']; public function patient(){return $this->belongsTo(Patient::class);} public function doctor(){return $this->belongsTo(User::class,'doctor_id');} }
