
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_sequences', function (Blueprint $table) {
            $table->id();
            $table->string('department_code')->unique();
            $table->unsignedInteger('next_number')->default(1);
            $table->timestamps();
        });

        DB::table('task_sequences')->insert([
            [
                'department_code' => 'D',
                'next_number' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_code' => 'V',
                'next_number' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('task_sequences');
    }
};
