<?php

use App\Models\Genre;
use App\Models\Media;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->integer('uniqueBookId')->unique();
            $table->foreignIdFor(Genre::class, 'genreId')->constrained('genres')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignIdFor(User::class, 'authorId')->constrained('users')->onDelete('restrict')->onUpdate('restrict');
            $table->longText('description');
            $table->string('isbn', 13);
            $table->string("image")->nullable();
            $table->foreignIdFor(Media::class, 'mediaId')->nullable()->constrained('media')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignIdFor(Publisher::class, 'publisherId')->constrained('publishers')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamp('createdAt')->nullable();
            $table->timestamp('updatedAt')->nullable();
            $table->softDeletes('deletedAt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
