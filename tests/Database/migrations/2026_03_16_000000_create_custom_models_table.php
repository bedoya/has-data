<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * @return void
         */
        public function up(): void
        {
            Schema::create( 'custom_models', function( Blueprint $table ) {
                $table->id();
                $table->json( 'custom_json' )->nullable();
                $table->timestamps();
            } );
        }

        /**
         * @return void
         */
        public function down(): void
        {
            Schema::dropIfExists( 'custom_models' );
        }
    };