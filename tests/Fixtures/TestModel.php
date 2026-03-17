<?php

    namespace Bedoya\HasData\Tests\Fixtures;

    use Bedoya\HasData\HasData;
    use Illuminate\Database\Eloquent\Model;

    /**
     *
     * @property int  $id
     */
    class TestModel extends Model
    {
        use HasData;

        protected $table = 'test_models';

        protected $fillable = [ 'data' ];

        public $timestamps = false;

        public bool $hasDataAutoSave = true;
    }