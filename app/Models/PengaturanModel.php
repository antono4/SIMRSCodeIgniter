<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table         = 'pengaturan';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['key', 'value', 'updated_at'];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        $row = (new self())->where('key', $key)->first();

        return $row['value'] ?? $default;
    }

    public static function setValue(string $key, string $value): void
    {
        $model = new self();
        $existing = $model->where('key', $key)->first();

        if ($existing) {
            $model->update($existing['id'], ['value' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
        } else {
            $model->insert(['key' => $key, 'value' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
        }
    }
}
