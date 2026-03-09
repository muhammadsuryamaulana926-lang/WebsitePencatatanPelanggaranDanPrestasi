<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function index()
    {
        $backups = $this->getBackupFiles();
        return view('page_admin.backup-restore', compact('backups'));
    }

    public function backup()
    {
        try {
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $path = storage_path('app/backups/' . $filename);
            
            // Buat direktori jika belum ada
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            // Gunakan Laravel DB untuk backup
            $tables = DB::select('SHOW TABLES');
            $sql = "-- Database Backup\n-- Generated on: " . date('Y-m-d H:i:s') . "\n\n";
            
            foreach ($tables as $table) {
                $tableName = array_values((array) $table)[0];
                
                // Get table structure
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
                $sql .= "-- Table structure for `{$tableName}`\n";
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sql .= $createTable->{'Create Table'} . ";\n\n";
                
                // Get table data
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    $sql .= "-- Data for table `{$tableName}`\n";
                    $sql .= "INSERT INTO `{$tableName}` VALUES\n";
                    
                    $values = [];
                    foreach ($rows as $row) {
                        $rowData = [];
                        foreach ((array) $row as $value) {
                            if (is_null($value)) {
                                $rowData[] = 'NULL';
                            } else {
                                $rowData[] = "'" . addslashes($value) . "'";
                            }
                        }
                        $values[] = '(' . implode(', ', $rowData) . ')';
                    }
                    $sql .= implode(",\n", $values) . ";\n\n";
                }
            }
            
            // Write to file
            if (file_put_contents($path, $sql)) {
                $fileSize = filesize($path);
                if ($fileSize > 0) {
                    return redirect()->back()->with('success', 'Backup berhasil dibuat: ' . $filename . ' (' . $this->formatBytes($fileSize) . ')');
                } else {
                    unlink($path); // Hapus file kosong
                    return redirect()->back()->with('error', 'Backup gagal - file kosong');
                }
            } else {
                return redirect()->back()->with('error', 'Backup gagal - tidak bisa menulis file');
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql,gz'
        ]);

        try {
            $file = $request->file('backup_file');
            $filename = $file->getClientOriginalName();
            $path = storage_path('app/backups/' . $filename);
            
            $file->move(storage_path('app/backups'), $filename);

            // Jika file .gz, extract dulu
            if (pathinfo($filename, PATHINFO_EXTENSION) === 'gz') {
                exec("gunzip {$path}");
                $path = str_replace('.gz', '', $path);
            }

            // Baca file SQL
            $sql = file_get_contents($path);
            if (!$sql) {
                return redirect()->back()->with('error', 'File backup kosong atau tidak valid');
            }

            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            // Split SQL statements
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            
            foreach ($statements as $statement) {
                if (!empty($statement) && !str_starts_with($statement, '--')) {
                    DB::statement($statement);
                }
            }
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            return redirect()->back()->with('success', 'Database berhasil di-restore');
            
        } catch (\Exception $e) {
            // Re-enable foreign key checks jika error
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        if (file_exists($path)) {
            return response()->download($path);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }

    public function delete($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        if (file_exists($path)) {
            unlink($path);
            return redirect()->back()->with('success', 'Backup berhasil dihapus');
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }

    private function getBackupFiles()
    {
        $backupPath = storage_path('app/backups');
        if (!file_exists($backupPath)) {
            return [];
        }

        $files = scandir($backupPath);
        $backups = [];

        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && (strpos($file, '.sql') !== false || strpos($file, '.gz') !== false)) {
                $filePath = $backupPath . '/' . $file;
                $fileSize = filesize($filePath);
                
                // Hapus file kosong
                if ($fileSize === 0) {
                    unlink($filePath);
                    continue;
                }
                
                $backups[] = [
                    'name' => $file,
                    'size' => $this->formatBytes($fileSize),
                    'date' => date('Y-m-d H:i:s', filemtime($filePath))
                ];
            }
        }

        return array_reverse($backups);
    }
    
    public function cleanEmptyBackups()
    {
        $backupPath = storage_path('app/backups');
        if (!file_exists($backupPath)) {
            return redirect()->back()->with('info', 'Folder backup tidak ditemukan');
        }

        $files = scandir($backupPath);
        $deletedCount = 0;

        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && (strpos($file, '.sql') !== false || strpos($file, '.gz') !== false)) {
                $filePath = $backupPath . '/' . $file;
                if (filesize($filePath) === 0) {
                    unlink($filePath);
                    $deletedCount++;
                }
            }
        }

        return redirect()->back()->with('success', "Berhasil menghapus {$deletedCount} file backup kosong");
    }

    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        return round($size, $precision) . ' ' . $units[$i];
    }
}