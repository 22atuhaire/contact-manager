<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['user_id', 'name']);
        });

        Schema::create('contact_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();

            $table->unique(['user_id', 'slug']);
        });

        Schema::create('contact_contact_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('contact_tags')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['contact_id', 'tag_id']);
        });

        Schema::create('contact_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('kind', 50)->default('note');
            $table->text('note');
            $table->timestamp('interacted_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_interactions');
        Schema::dropIfExists('contact_contact_tag');
        Schema::dropIfExists('contact_tags');
        Schema::dropIfExists('contact_groups');
    }
};
