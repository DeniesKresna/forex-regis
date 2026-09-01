<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('metatrader_account_id')->constrained()->restrictOnDelete();
            $t->string('type');
            $t->decimal('amount', 20, 2);
            $t->unsignedInteger('duration_days');
            $t->date('expired_before')->nullable();
            $t->date('expired_after');
            $t->timestamps(); }); }
    public function down(): void
    {
        Schema::dropIfExists('payments'); }
};
