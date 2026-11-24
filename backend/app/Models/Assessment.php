<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Assessment extends Model { protected $fillable=['patient_id','created_by','symptoms','predicted_label','department','priority','explanation','doctor_status','doctor_note']; protected $casts=['symptoms'=>'array']; public function patient(){return $this->belongsTo(Patient::class);} public function creator(){return $this->belongsTo(User::class,'created_by');} }
