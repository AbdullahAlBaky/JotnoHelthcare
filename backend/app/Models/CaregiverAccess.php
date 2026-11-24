<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CaregiverAccess extends Model {protected $table='caregiver_access';protected $fillable=['patient_id','caregiver_id','approved_by','status'];public function patient(){return $this->belongsTo(Patient::class);}public function caregiver(){return $this->belongsTo(User::class,'caregiver_id');}}
