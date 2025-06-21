# HasData

A Laravel trait to manage dynamic JSON fields (usually named `data`) in Eloquent models, with elegant access, flexible customization, and auto-save support.

---

## 📦 Installation

You can install the package via Composer:

```bash
composer require bedoya/has-data
```

Optionally, publish the configuration file:

```bash
php artisan vendor:publish --tag=has-data-config
```

## 🚀 Usage

Add the trait to any Eloquent model that has a JSON column (default: `data`):

```php
use Bedoya\HasData\Traits\HasData;

class Raffle extends Model
{
    use HasData;

    protected $casts = [
        'data' => 'array',
    ];
}
```

### ✅ Access data using dot notation

```php
$raffle->getData('grid.rows');        // returns 25
$raffle->getData('grid');             // returns [25, 40]
$raffle->setData('grid.cols', 40);    // sets the value and optionally saves
$raffle->hasData('grid.rows');        // returns true
```

## ⚙️ Configuration

Default config (`config/has-data.php`)

```php
return [
    'database' => [
        'column-name' => 'data',    // default JSON column name
        'nullable'    => true,
        'casts'       => 'array',
    ],
    'auto_save' => true,            // auto-save after setData()
];
```

### 🧠 Per-model configuration

You can override the JSON column or auto-save behavior per model.

**Custom column per model**

```php
class Client extends Model
{
    use HasData;

    protected string $dataColumn = 'metadata';
    protected $casts = [
        'metadata' => 'array',
    ];
}
```

**Disable auto-save per model**

```php
class Client extends Model
{
    use HasData;

    public bool $hasDataAutoSave = false;
}
```

If `hasDataAutoSave` is not set, it falls back to the global config.

## 🧪 Testing

This package includes full test coverage using PestPHP.
To run the tests:

```bash
composer test
```

## 🧱 Requirements

- PHP 8.1+
- Laravel 10 or 11
- JSON-compatible database column (casted to array)

## 📄 License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/license/mit).

## ✍️ Author

**Andrés Bedoya**
