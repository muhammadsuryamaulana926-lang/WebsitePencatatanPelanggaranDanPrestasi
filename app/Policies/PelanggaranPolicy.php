<?php

namespace App\Policies;

use App\Models\Pelanggaran;
use App\Models\User;

class PelanggaranPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isKesiswaan() || $user->isGuru() || $user->isBK() || $user->isWaliKelas() || $user->isKepalaSekolah();
    }

    public function view(User $user, Pelanggaran $pelanggaran): bool
    {
        if ($user->isAdmin() || $user->isKesiswaan() || $user->isGuru() || $user->isBK() || $user->isWaliKelas() || $user->isKepalaSekolah()) {
            return true;
        }

        // Siswa can only see their own violations
        return $user->isSiswa() && $user->username === $pelanggaran->siswa?->nis;
    }

    public function create(User $user): bool
    {
        // Many roles can record a violation
        return $user->isAdmin() || $user->isKesiswaan() || $user->isGuru() || $user->isBK() || $user->isWaliKelas();
    }

    public function update(User $user, Pelanggaran $pelanggaran): bool
    {
        // Only Admin, Kesiswaan, or the recorder (if teacher) can update
        if ($user->isAdmin() || $user->isKesiswaan()) return true;

        return ($user->isGuru() || $user->isBK() || $user->isWaliKelas()) && $user->guru_id === $pelanggaran->guru_pencatat;
    }

    public function delete(User $user, Pelanggaran $pelanggaran): bool
    {
        return $user->isAdmin() || $user->isKesiswaan();
    }
}
