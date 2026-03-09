<?php

namespace App\Policies;

use App\Models\Siswa;
use App\Models\User;

class SiswaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isKesiswaan() || $user->isGuru() || $user->isBK() || $user->isWaliKelas() || $user->isKepalaSekolah();
    }

    public function view(User $user, Siswa $siswa): bool
    {
        if ($user->isAdmin() || $user->isKesiswaan() || $user->isGuru() || $user->isBK() || $user->isWaliKelas() || $user->isKepalaSekolah()) {
            return true;
        }

        // Siswa can view their own data (mapped by username/nis)
        return $user->isSiswa() && $user->username === $siswa->nis;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isKesiswaan();
    }

    public function update(User $user, Siswa $siswa): bool
    {
        return $user->isAdmin() || $user->isKesiswaan();
    }

    public function delete(User $user, Siswa $siswa): bool
    {
        return $user->isAdmin();
    }
}
