<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AdmissionRequest extends Model {protected $fillable=['patient_id','reason','symptoms','status','reviewed_by','review_note','reviewed_at'];protected $casts=['symptoms'=>'array','reviewed_at'=>'datetime'];public function patient(){return $this->belongsTo(Patient::class);}public function reviewer(){return $this->belongsTo(User::class,'reviewed_by');}}
