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
        Schema::create('sales', function (Blueprint $table) {
            $table->id()->comment('Id');

            $table->string('users_id'); // 外部キーにはunsignedBigIntegerを使用

        $table->foreign('users_id')->references('id')->on('users')->comment('ユーザーId');

        $table->bigInteger('stores_id')->unsigned();
        $table->foreign('stores_id')->references('id')->on('stores')->comment('お店のId');

            $table->string('customer_payment')->comment('Id');
            $table->enum('deleted_at',[1,0])->comment('論理削除');
            $table->timestamp('created_at')->comment('作成日時');
            $table->timestamp('updated_at')->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['users_id']);
            $table->dropForeign(['stores_id']);
        });
        Schema::dropIfExists('sales');
    }
};
