<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up():void {
 Schema::create('admission_requests',function(Blueprint $t){$t->id();$t->foreignId('patient_id')->constrained()->cascadeOnDelete();$t->text('reason');$t->json('symptoms')->nullable();$t->string('status')->default('pending');$t->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();$t->text('review_note')->nullable();$t->timestamp('reviewed_at')->nullable();$t->timestamps();});
 Schema::create('caregiver_access',function(Blueprint $t){$t->id();$t->foreignId('patient_id')->constrained()->cascadeOnDelete();$t->foreignId('caregiver_id')->constrained('users')->cascadeOnDelete();$t->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();$t->string('status')->default('pending');$t->timestamps();$t->unique(['patient_id','caregiver_id']);});
 } public function down():void {Schema::dropIfExists('caregiver_access');Schema::dropIfExists('admission_requests');}};
