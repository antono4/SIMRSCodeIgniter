<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    protected UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        return view('user/index', [
            'title' => 'Manajemen User',
            'users' => $this->model->orderBy('role')->orderBy('nama')->findAll(),
        ]);
    }

    public function create()
    {
        return view('user/form', ['title' => 'Tambah User', 'user' => null]);
    }

    public function store()
    {
        $data = $this->request->getPost();

        if ($this->model->where('username', $data['username'])->first()) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan.');
        }

        if (strlen((string) $data['password']) < 6) {
            return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter.');
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->model->insert($data);

        return redirect()->to('/user')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $user = $this->model->find($id);
        if (! $user) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan.');
        }

        return view('user/form', ['title' => 'Edit User', 'user' => $user]);
    }

    public function update(int $id)
    {
        $data = $this->request->getPost();

        $duplikat = $this->model->where('username', $data['username'])->where('id !=', $id)->first();
        if ($duplikat) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan.');
        }

        $update = [
            'username'  => $data['username'],
            'nama'      => $data['nama'],
            'email'     => $data['email'] ?? null,
            'role'      => $data['role'],
            'is_active' => (int) ($data['is_active'] ?? 1),
        ];

        // Password hanya diubah bila diisi
        if (! empty($data['password'])) {
            if (strlen((string) $data['password']) < 6) {
                return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter.');
            }
            $update['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $this->model->update($id, $update);

        return redirect()->to('/user')->with('success', 'User berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        if ($id === (int) session()->get('user_id')) {
            return redirect()->to('/user')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $this->model->delete($id);

        return redirect()->to('/user')->with('success', 'User berhasil dihapus.');
    }
}
