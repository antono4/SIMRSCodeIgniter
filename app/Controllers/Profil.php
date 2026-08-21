<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profil extends BaseController
{
    public function index()
    {
        $user = (new UserModel())->find(session()->get('user_id'));

        return view('profil/index', ['title' => 'Profil Saya', 'user' => $user]);
    }

    public function gantiPassword()
    {
        $model = new UserModel();
        $user  = $model->find(session()->get('user_id'));

        $lama  = (string) $this->request->getPost('password_lama');
        $baru  = (string) $this->request->getPost('password_baru');
        $ulang = (string) $this->request->getPost('password_ulang');

        if (! password_verify($lama, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        if (strlen($baru) < 6) {
            return redirect()->back()->with('error', 'Password baru minimal 6 karakter.');
        }

        if ($baru !== $ulang) {
            return redirect()->back()->with('error', 'Konfirmasi password baru tidak sama.');
        }

        $model->update($user['id'], ['password' => password_hash($baru, PASSWORD_DEFAULT)]);

        return redirect()->to('/profil')->with('success', 'Password berhasil diubah.');
    }
}
