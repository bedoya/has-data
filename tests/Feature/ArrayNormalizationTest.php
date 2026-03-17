<?php

    use Bedoya\HasData\Tests\Fixtures\TestModel;

    it( 'decodes json strings when retrieving data', function() {

        $model = TestModel::query()->create( [
            'data' => '{"country":"US","logo_path":"logos/dji.png"}',
        ] );

        expect( $model->getData() )
            ->toBeArray()
            ->and( $model->getData( 'country' ) )->toBe( 'US' )
            ->and( $model->getData( 'logo_path' ) )->toBe( 'logos/dji.png' );
    } );

    it( 'returns array data without modification', function() {

        $model = new TestModel( [
            'data' => [
                'country'   => 'US',
                'logo_path' => 'logos/dji.png',
            ],
        ] );

        expect( $model->getData() )
            ->toBeArray()
            ->and( $model->getData( 'country' ) )->toBe( 'US' );
    } );