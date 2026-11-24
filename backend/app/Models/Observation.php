<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Observation extends Model { protected $fillable=['patient_id','recorded_by','temperature','spo2','heart_rate','systolic_bp','diastolic_bp','symptoms','notes','recorded_at']; protected $casts=['symptoms'=>'array','recorded_at'=>'datetime']; public function patient(){return $this->belongsTo(Patient::class);} }
