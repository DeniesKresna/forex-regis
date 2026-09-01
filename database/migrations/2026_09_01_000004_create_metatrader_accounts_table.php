<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('metatrader_accounts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('server_name');
            $t->string('account_number', 100);
            $t->decimal('balance', 20, 2)->default(0);
            $t->date('expired_date')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->unique(['server_name', 'account_number']); }); }
    public function down(): void
    {
        Schema::dropIfExists('metatrader_accounts'); }
};
