<?php

namespace App\Policies;

use App\Models\Kelas;
use App\Models\User;

class KelasPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isKesiswaan() || $user->isGuru() || $user->isBK() || $user->isWaliKelas() || $user->isKepalaSekolah();
    }

    public function view(User $user, Kelas $kelas): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isKesiswaan();
    }

    public function update(User $user, Kelas $kelas): bool
    {
        return $user->isAdmin() || $user->isKesiswaan();
    }

    public function delete(User $user, Kelas $kelas): bool
    {
        return $user->isAdmin();
    }
}
