<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MedicalReport extends Model { protected $fillable=['patient_id','uploaded_by','original_name','file_path','mime_type','file_size','description']; public function patient(){return $this->belongsTo(Patient::class);} }
