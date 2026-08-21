<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table         = 'pasien';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['no_rm', 'nik', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'golongan_darah', 'alamat', 'telepon', 'penjamin', 'no_bpjs'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'nama'          => 'required|min_length[3]',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'no_rm'         => 'permit_empty|is_unique[pasien.no_rm,id,{id}]',
    ];

    public function generateNoRm(): string
    {
        $last = $this->orderBy('id', 'DESC')->first();
        $next = $last ? ((int) substr($last['no_rm'], 2)) + 1 : 1;

        return 'RM' . str_pad((string) $next, 6, '0', STR_PAD_LEFT);
    }

    public function search(string $keyword)
    {
        return $this->like('nama', $keyword)
            ->orLike('no_rm', $keyword)
            ->orLike('nik', $keyword)
            ->findAll();
    }
}
