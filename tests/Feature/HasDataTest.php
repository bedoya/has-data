<?php

    use Bedoya\HasData\HasData;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    beforeEach( function () {
        Schema::dropAllTables();

        Schema::create( 'custom_models', function ( Blueprint $table ) {
            $table->id();
            $table->json( 'custom_json' )->nullable();
            $table->timestamps();
        } );

        Schema::create( 'default_models', function ( Blueprint $table ) {
            $table->id();
            $table->json( 'data' )->nullable();
            $table->timestamps();
        } );
    } );

    it( 'allows different models to use custom data columns independently', function () {
        $custom_model = new class extends Model
        {
            use HasData;

            protected        $table       = 'custom_models';
            protected        $fillable    = [ 'custom_json' ];
            protected        $casts       = [ 'custom_json' => 'array' ];
            protected string $data_column = 'custom_json';
        };

        $default_model = new class extends Model
        {
            use HasData;

            protected $table    = 'default_models';
            protected $fillable = [ 'data' ];
            protected $casts    = [ 'data' => 'array' ];
        };

        $custom = $custom_model::query()->create( [ 'custom_json' => [ 'foo' => 'bar' ] ] );
        $default = $default_model::query()->create( [ 'data' => [ 'foo' => 'baz' ] ] );

        expect( $custom->getData( 'foo' ) )->toBe( 'bar' )
                                           ->and( $default->getData( 'foo' ) )->toBe( 'baz' );
    } );

    test( 'getData retrieves the key if it exists', function () {
        $default_model = new class extends Model
        {
            use HasData;

            protected $table    = 'default_models';
            protected $fillable = [ 'data' ];
            protected $casts    = [ 'data' => 'array' ];
        };

        $instance = $default_model::query()->create( [ 'data' => [ 'key1' => 'value1' ] ] );

        expect( $instance->getData( 'key1' ) )->toBe( 'value1' );
    } );

    test( 'getData returns default if key does not exist', function () {
        $model = new class extends Model
        {
            use HasData;

            protected $table    = 'default_models';
            protected $fillable = [ 'data' ];
            protected $casts    = [ 'data' => 'array' ];
        };

        $instance = $model::query()->create( [ 'data' => [ 'key1' => 'value1' ] ] );

        expect( $instance->getData( 'nonexistent', 'default' ) )->toBe( 'default' );
    } );

    test( 'getData without parameters returns the whole array', function () {
        $model = new class extends Model
        {
            use HasData;

            protected $table    = 'default_models';
            protected $fillable = [ 'data' ];
            protected $casts    = [ 'data' => 'array' ];
        };

        $data = [ 'one' => 1, 'two' => 2 ];
        $instance = $model::query()->create( [ 'data' => $data ] );

        expect( $instance->getData() )->toBe( $data );
    } );

    test( 'setData assigns the given key and value', function () {
        $model = new class extends Model
        {
            use HasData;

            protected $table    = 'default_models';
            protected $fillable = [ 'data' ];
            protected $casts    = [ 'data' => 'array' ];
        };

        $instance = $model::query()->create( [ 'data' => [] ] );

        $instance->setData( 'new.key', 'hello' );

        expect( $instance->getData( 'new.key' ) )->toBe( 'hello' );
    } );

    test( 'setData persists data in the database if model is saved', function () {
        $model = new class extends Model
        {
            use HasData;

            protected $table    = 'default_models';
            protected $fillable = [ 'data' ];
            protected $casts    = [ 'data' => 'array' ];
        };

        $instance = $model::query()->create( [ 'data' => [] ] );
        $instance->setData( 'persisted.key', 'yes' );

        $reloaded = $model::query()->find( $instance->id );

        expect( $reloaded->getData( 'persisted.key' ) )->toBe( 'yes' );
    } );