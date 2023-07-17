<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('isbn_10')->nullable()->change();

            $targetList = \App\Models\Book::where('isbn_10', '=', 0)->get();

            if ($targetList->count() > 0) {
                foreach ($targetList as $target) {
                    $target->update(['isbn_10' => null]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('isbn_10')->change();
        });
    }
};
