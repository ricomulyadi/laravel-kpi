
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_code')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('source')->default('Internal');
            $table->string('department');
            $table->string('project_name')->nullable();
            $table->string('task_type');
            $table->string('task_name');
            $table->text('brief')->nullable();
            $table->date('deadline');

            $table->string('status')->default('draft');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedInteger('revision_count')->default(0);
            $table->string('result_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
