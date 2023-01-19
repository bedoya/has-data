<?php

    namespace Bedoya\HasData\Traits;

    trait HasData {
        /**
         * Initialize the has data trait for an instance.
         *
         * @return void
         */
        public function initializeHasData(): void
        {
            if( !isset( $this->casts[ $this->getDataColumn() ] ) ){
                $this->casts[ $this->getDataColumn() ] = config( 'hasdata.database.default.casts', 'array' );
            }
        }

        // Checkers

        /**
         * Determines if the object has a value defined for the given key
         *
         * @param string $key
         *
         * @return bool
         */
        public function hasData( string $key ): bool
        {
            return data_get( $this->{$this->getDataColumn()}, $key, null ) != null;
        }

        // Getters

        /**
         * Retrieves the object's value of the given key in the data column
         *
         * @param                   $key
         * @param array|string|null $default
         *
         * @return array|string|bool|null
         */
        public function getData( $key, array | string $default = null ): array | string | bool | null
        {
            if( is_array( $key ) ){
                $values = [];
                foreach( $key as $data ){
                    if( data_get( $this->{$this->getDataColumn()}, $data ) != null ){
                        $values[ $data ] = data_get( $this->{$this->getDataColumn()}, $data );
                    }
                }

                return $values;
            }
            else{
                return data_get( $this->{$this->getDataColumn()}, $key, $default );
            }
        }

        // Setters

        /**
         * Sets a value in the data column for the given object
         *
         * @param string $key
         * @param mixed  $value
         *
         * @return $this
         */
        public function setData( string $key, mixed $value ): static
        {
            $data = $this->{$this->getDataColumn()};
            data_set( $data, $key, $value );
            $this->{$this->getDataColumn()} = $data;
            $this->save();

            return $this->refresh();
        }

        /**
         * Obtiene el nombre de la columna "data".
         *
         * @return string
         */
        public function getDataColumn(): string
        {
            return $this->data_column ?? config( 'hasdata.database.column-name', 'data' );
        }
    }
