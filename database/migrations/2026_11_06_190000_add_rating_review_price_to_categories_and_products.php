<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('admin_categories', function (Blueprint $table) {
            $table->string('rating_value')->nullable()->after('robots');
            $table->string('review_count')->nullable()->after('rating_value');
            $table->string('price')->nullable()->after('review_count');
        });

        Schema::table('admin_products', function (Blueprint $table) {
            $table->string('rating_value')->nullable()->after('robots');
            $table->string('review_count')->nullable()->after('rating_value');
            $table->string('price')->nullable()->after('review_count');
        });
    }

    public function down()
    {
        Schema::table('admin_categories', function (Blueprint $table) {
            $table->dropColumn(['rating_value', 'review_count', 'price']);
        });

        Schema::table('admin_products', function (Blueprint $table) {
            $table->dropColumn(['rating_value', 'review_count', 'price']);
        });
    }
};

