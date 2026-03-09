@extends('layouts.kesiswaan')

@section('title', 'Verifikasi Data')
@section('page-title', 'Verifikasi Data')

@section('content')
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Verifikasi Data</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Data</th>
                            <th>Status</th>
                            <th>Guru Verifikator</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($verifikasi->filter(function($v) { return $v->data_terkait !== null; }) as $index => $v)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $v->data_terkait->siswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $v->data_terkait->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $v->jenis_data ?? '-' }}</td>
                            <td>
                                <span class="badge 
                                    @if($v->status == 'menunggu') bg-secondary
                                    @elseif($v->status == 'diverifikasi') bg-success
                                    @elseif($v->status == 'ditolak') bg-danger
                                    @else bg-warning
                                    @endif">
                                    {{ ucfirst($v->status) }}
                                </span>
                            </td>
                            <td>{{ $v->guru->nama_guru ?? '-' }}</td>
                            <td>{{ $v->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($v->status == 'menunggu')
                                <form method="POST" action="/kesiswaan/verifikasi/{{ $v->id }}/update" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="diverifikasi">
                                    <button type="submit" class="btn btn-success btn-sm me-1">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="/kesiswaan/verifikasi/{{ $v->id }}/update" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="btn btn-danger btn-sm me-1">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                <form method="POST" action="/kesiswaan/verifikasi/{{ $v->id }}/update" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="revisi">
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </form>
                                @else
                                <span class="text-muted">Sudah diverifikasi</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data verifikasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection