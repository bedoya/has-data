<?php

    declare( strict_types=1 );

    use Illuminate\Database\Eloquent\Model;
    use Bedoya\HasData\HasData;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Schema;

    uses( RefreshDatabase::class );

    beforeEach( function () {
        // Setup temporary table for test
        Schema::create( 'default_models', function ( $table ) {
            $table->id();
            $table->json( 'data' )->nullable();
            $table->timestamps();
        } );

        // Reset config
        config()->set( 'has-data.auto_save', true );
    } );

    afterEach( function () {
        Schema::dropIfExists( 'default_models' );
        config()->set( 'has-data.auto_save', true );
    } );

    test( 'setData persists data when auto-save is enabled (default)', function () {
        $model = new class extends Model
        {
            use HasData;

            protected $table    = 'default_models';
            protected $fillable = [ 'data' ];
            protected $casts    = [ 'data' => 'array' ];
        };

        $instance = $model::query()->create( [ 'data' => [] ] );
        $instance->setData( 'key', 'value' );

        $reloaded = $model::query()->find( $instance->id );
        expect( $reloaded->getData( 'key' ) )->toBe( 'value' );
    } );

    test( 'setData does not persist data when auto-save is disabled in model', function () {
        $model = new class extends Model
        {
            use HasData;

            protected $table    = 'default_models';
            protected $fillable = [ 'data' ];
            protected $casts    = [ 'data' => 'array' ];

            public bool $hasDataAutoSave = false;
        };

        $instance = $model::query()->create( [ 'data' => [] ] );
        $instance->setData( 'key', 'value' );

        $reloaded = $model::query()->find( $instance->id );
        expect( $reloaded->getData( 'key' ) )->toBeNull(); // Not saved
    } );

    test( 'setData does not persist data when auto-save is disabled in config', function () {
        config()->set( 'has-data.auto_save', false );

        $model = new class extends Model
        {
            use HasData;

            protected $table    = 'default_models';
            protected $fillable = [ 'data' ];
            protected $casts    = [ 'data' => 'array' ];
        };

        $instance = $model::query()->create( [ 'data' => [] ] );
        $instance->setData( 'key', 'value' );

        $reloaded = $model::query()->find( $instance->id );
        expect( $reloaded->getData( 'key' ) )->toBeNull(); // Not saved
    } );
