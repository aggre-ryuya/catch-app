<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('id')->comment('ID')->change();
            $table->string('name', 15)->nullable(false)->comment('ユーザー名')->change();
            $table->string('email', 255)->nullable()->comment('メールアドレス')->change();
            $table->timestamp('email_verified_at')->nullable()->comment('メール確認可否')->change();
            $table->string('password', 255)->comment('パスワード')->change();
            $table->enum('role', [0, 1])->default(0)->nullable()->comment('権限')->after('password');;
            $table->enum('deleted_at', [0, 1])->default(0)->nullable()->comment('論理削除')->after('role');
            $table->rememberToken()->comment('認証トークン')->change();
            $table->timestamp('created_at')->comment('作成日時')->change();
            $table->timestamp('updated_at')->comment('更新日時')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('deleted_at');
        });
    }
};
