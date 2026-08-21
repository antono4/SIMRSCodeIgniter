<?php

if (! function_exists('rupiah')) {
    function rupiah($angka): string
    {
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }
}

if (! function_exists('rs')) {
    function rs(string $key, ?string $default = null): ?string
    {
        static $cache = [];
        if (! isset($cache[$key])) {
            $cache[$key] = \App\Models\PengaturanModel::getValue($key, $default);
        }

        return $cache[$key];
    }
}

if (! function_exists('badge_status')) {
    function badge_status(string $status): string
    {
        $map = [
            'menunggu'     => 'warning',
            'diperiksa'    => 'info',
            'selesai'      => 'success',
            'batal'        => 'secondary',
            'dirawat'      => 'primary',
            'pulang'       => 'success',
            'diproses'     => 'info',
            'belum_bayar'  => 'danger',
            'lunas'        => 'success',
            'rawat_jalan'  => 'info',
            'rawat_inap'   => 'primary',
            'igd'          => 'danger',
            'dipanggil'    => 'success',
            'dilayani'     => 'info',
            'dilewati'     => 'dark',
        ];
        $color = $map[$status] ?? 'secondary';

        return '<span class="badge bg-' . $color . '">' . ucfirst(str_replace('_', ' ', $status)) . '</span>';
    }
}
