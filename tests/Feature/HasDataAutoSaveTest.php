<?php

    declare( strict_types=1 );

    namespace Bedoya\HasData\Tests\Feature;

    use Bedoya\HasData\Tests\Fixtures\CustomModel;
    use Bedoya\HasData\Tests\Fixtures\TestModel;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Foundation\Testing\RefreshDatabase;

    uses( RefreshDatabase::class );

    beforeEach( function() {
        config()->set( 'has-data.auto_save', true );
    } );

    afterEach( function() {
        Schema::dropIfExists( 'test_models' );
        Schema::dropIfExists( 'custom_models' );
        config()->set( 'has-data.auto_save', true );
    } );

    test( 'setData persists data when auto-save is enabled (default)', function() {
        $instance = TestModel::query()->create( [ 'data' => [] ] );
        $instance->setData( 'key', 'value' );

        $reloaded = TestModel::query()->find( $instance->id );
        expect( $reloaded->getData( 'key' ) )->toBe( 'value' );
    } );

    test( 'setData does not persist data when auto-save is disabled in model', function () {
        $instance = TestModel::query()->create( [ 'data' => [] ] );
        $instance->hasDataAutoSave = false;

        $instance->setData( 'key', 'value' );

        $reloaded = TestModel::query()->find( $instance->id );
        expect( $reloaded->getData( 'key' ) )->toBeNull(); // Not saved
    } );

    test( 'setData does not persist data when auto-save is disabled in config', function () {
        config()->set( 'has-data.auto_save', false );

        $instance = CustomModel::query()->create( [ 'data' => [] ] );
        $instance->setData( 'key', 'value' );

        $reloaded = CustomModel::query()->find( $instance->id );
        expect( $reloaded->getData( 'key' ) )->toBeNull(); // Not saved
    } );
