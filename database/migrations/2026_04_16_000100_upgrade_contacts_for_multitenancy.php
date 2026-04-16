<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            $table->string('normalized_phone', 32)->nullable()->after('phone');
            $table->foreignId('group_id')->nullable()->after('address')->constrained('contact_groups')->nullOnDelete();
            $table->boolean('is_favorite')->default(false)->after('group_id');
            $table->softDeletes();

            $table->dropUnique('contacts_phone_unique');
            $table->dropUnique('contacts_email_unique');
            $table->index(['user_id', 'phone']);
            $table->index(['user_id', 'email']);
            $table->index(['user_id', 'normalized_phone']);
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'phone']);
            $table->dropIndex(['user_id', 'email']);
            $table->dropIndex(['user_id', 'normalized_phone']);
            $table->dropConstrainedForeignId('group_id');
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['normalized_phone', 'is_favorite', 'deleted_at']);

            $table->unique('phone');
            $table->unique('email');
        });
    }
};
