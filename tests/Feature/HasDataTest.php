<?php

    namespace Bedoya\HasData\Tests\Feature;

    use Bedoya\HasData\Tests\Fixtures\CustomModel;
    use Bedoya\HasData\Tests\Fixtures\TestModel;

    it( 'allows different models to use custom data columns independently', function () {

        $model = TestModel::query()->create( [ 'data' => [ 'foo' => 'baz' ] ] );
        $custom_model = CustomModel::query()->create( [ 'custom_json' => [ 'foo' => 'bar' ] ] );

        expect( $custom_model->getData( 'foo' ) )
            ->toBe( 'bar' )
            ->and( $model->getData( 'foo' ) )
            ->toBe( 'baz' );
    } );

    it( 'returns an empty array when the data column is null', function() {

        $model = TestModel::query()->create( [
            'data' => null,
        ] );

        expect( $model->getData() )->toBeArray()->toBe( [] );
    } );

    it( 'returns empty array when json is invalid', function() {

        $model = new TestModel();

        $model->setRawAttributes( [
            'data' => '{"country":',
        ] );

        expect( $model->getData() )->toBeArray()->toBe( [] );
    } );

    test( 'getData retrieves the key if it exists', function () {
        $default_model = TestModel::class;

        $instance = $default_model::query()->create( [ 'data' => [ 'key1' => 'value1' ] ] );

        expect( $instance->getData( 'key1' ) )->toBe( 'value1' );
    } );

    test( 'getData returns default if key does not exist', function () {
        $model = TestModel::class;

        $instance = $model::query()->create( [ 'data' => [ 'key1' => 'value1' ] ] );

        expect( $instance->getData( 'nonexistent', 'default' ) )->toBe( 'default' );
    } );

    test( 'getData without parameters returns the whole array', function () {
        $model = TestModel::class;

        $data = [ 'one' => 1, 'two' => 2 ];
        $instance = $model::query()->create( [ 'data' => $data ] );

        expect( $instance->getData() )->toBe( $data );
    } );

    test( 'setData assigns the given key and value', function () {
        $model = TestModel::class;

        $instance = $model::query()->create( [ 'data' => [] ] );

        $instance->setData( 'new.key', 'hello' );

        expect( $instance->getData( 'new.key' ) )->toBe( 'hello' );
    } );

    test( 'setData persists data in the database if model is saved', function () {
        $model = TestModel::class;

        $instance = $model::query()->create( [ 'data' => [] ] );
        $instance->setData( 'persisted.key', 'yes' );

        $reloaded = $model::query()->find( $instance->id );

        expect( $reloaded->getData( 'persisted.key' ) )->toBe( 'yes' );
    } );