<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('metatrader_configs', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->json('value');
            $t->timestamps();
            $t->softDeletes(); }); }
    public function down(): void
    {
        Schema::dropIfExists('metatrader_configs'); }
};
