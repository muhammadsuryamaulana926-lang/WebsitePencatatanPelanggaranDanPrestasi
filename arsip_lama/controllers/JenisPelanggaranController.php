<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPelanggaran;

class JenisPelanggaranController extends Controller
{
    public function index()
    {
        $jenisPelanggaran = JenisPelanggaran::all();
        return view('page_admin.data-jenis-pelanggaran', compact('jenisPelanggaran'));
    }
}