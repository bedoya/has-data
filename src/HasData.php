<?php

    namespace Bedoya\HasData;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Facades\Config;

    /**
     * Trait HasData
     *
     * Adds support for accessing a JSON column (like `data`, `settings`, etc.) via dot notation.
     *
     * @property array $casts
     * @mixin Model
     * @property array $data
     * @method static static|Model retrieved( \Closure $callback )
     * @method static static|Model creating( \Closure $callback )
     */
    trait HasData
    {
        protected string $resolvedDataColumn;

        /**
         * Laravel will call this automatically when using the trait.
         * https://laravel.com/docs/eloquent#trait-initialization
         */
        public function initializeHasData (): void
        {
            $this->resolvedDataColumn = $this->resolveDataColumn();

            if ( !isset( $this->casts[ $this->resolvedDataColumn ] ) ) {
                $this->casts[ $this->resolvedDataColumn ] = Config::get( 'has-data.database.casts', 'array' );
            }
        }

        /**
         * @return string
         */
        protected function resolveDataColumn (): string
        {
            return property_exists( $this, 'data_column' ) ?
                $this->data_column :
                Config::get( 'has-data.database.column-name', 'data' );
        }

        /**
         * Returns the name of the JSON column
         *
         * @return string
         */
        public function getDataColumn (): string
        {
            return $this->resolvedDataColumn ?? $this->resolveDataColumn();
        }

        /**
         * Determines if the model should auto-save after setting data.
         *
         * @return bool
         */
        public function shouldAutoSave (): bool
        {
            return property_exists( $this, 'hasDataAutoSave' ) ?
                (bool)$this->hasDataAutoSave :
                config( 'has-data.auto_save', true );
        }

        // === Getters ===

        /**
         * Retrieves the given $key from the JSON column. If $key is not defined in
         * the JSON column, it will return the $default value. If no $key is provided,
         * returns the entire JSON column.
         *
         * @param string|null $key
         * @param mixed|null  $default
         *
         * @return mixed
         */
        public function getData ( ?string $key = null, mixed $default = null ): mixed
        {
            $data = $this->{$this->getDataColumn()} ?? [];

            return is_null( $key )
                ? $data
                : data_get( $data, $key, $default );
        }

        /**
         * Verifies if a given $key exists in the JSON column
         *
         * @param string $key
         *
         * @return bool
         */
        public function hasData ( string $key ): bool
        {
            return !is_null( data_get( $this->{$this->getDataColumn()} ?? [], $key ) );
        }

        // === Setters ===

        /**
         * Sets $value as the value for the given $key in the JSON column
         *
         * @param string $key
         * @param mixed  $value
         *
         * @return $this
         */
        public function setData ( string $key, mixed $value ): static
        {
            $column = $this->getDataColumn();
            $data = $this->{$column} ?? [];

            data_set( $data, $key, $value );
            $this->forceFill( [ $column => $data ] );

            if ( $this->exists && $this->shouldAutoSave() ) {
                $this->save();
            }

            return $this;
        }

        /**
         * Merges the existing JSON column value, with the $values array provided.
         *
         * @param array $values
         *
         * @return $this
         */
        public function mergeData ( array $values ): static
        {
            $column = $this->getDataColumn();
            $current = $this->{$column} ?? [];
            $this->{$column} = array_replace_recursive( $current, $values );

            return $this;
        }

        /**
         * Removes the specified $keys from the JSON column.
         *
         * @param string|array $keys
         *
         * @return $this
         */
        public function removeData ( string|array $keys ): static
        {
            $column = $this->getDataColumn();
            $data = $this->{$column} ?? [];

            foreach ( (array)$keys as $key ) {
                Arr::forget( $data, $key );
            }

            $this->{$column} = $data;

            return $this;
        }
    }
