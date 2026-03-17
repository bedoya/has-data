<?php

    namespace Bedoya\HasData\Tests\Fixtures;

    use Bedoya\HasData\HasData;
    use Illuminate\Database\Eloquent\Model;

    /**
     *
     */
    class CustomModel extends Model
    {
        use HasData;

        protected $table = 'custom_models';

        protected $fillable = [ 'custom_json' ];

        protected $casts = [
            'custom_json' => 'array',
        ];

        protected string $data_column = 'custom_json';
    }