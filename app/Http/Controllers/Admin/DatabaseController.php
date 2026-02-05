<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;

class DatabaseController extends Controller
{
    /**
     * Directory for storing database backups
     */
    protected string $backupPath = 'database-backups';

    /**
     * Display database management panel
     */
    public function index()
    {
        // Get database info
        $databaseInfo = $this->getDatabaseInfo();
        
        // Get list of backup files
        $backups = $this->getBackupFiles();
        
        // Get database statistics
        $statistics = $this->getDatabaseStatistics();
        
        return view('admin.database.index', compact('databaseInfo', 'backups', 'statistics'));
    }

    /**
     * Export database to SQL file
     */
    public function export(Request $request)
    {
        try {
            $filename = 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
            
            // Ensure backup directory exists with recursive creation
            $backupDir = storage_path('app/' . $this->backupPath);
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            
            $tempPath = $backupDir . '/' . $filename;
            
            // Get database configuration
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port');
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            
            // Get selected tables or all
            $tables = $request->input('tables', []);
            
            // Build mysqldump command
            $command = sprintf(
                'mysqldump --host=%s --port=%s --user=%s --password=%s %s %s > %s',
                escapeshellarg($host),
                escapeshellarg($port),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($database),
                !empty($tables) ? implode(' ', array_map('escapeshellarg', $tables)) : '',
                escapeshellarg($tempPath)
            );
            
            // Execute command
            $result = null;
            $output = null;
            exec($command . ' 2>&1', $output, $result);
            
            if ($result !== 0) {
                // Fallback to PHP-based export if mysqldump fails
                $this->exportWithPHP($tempPath, $tables);
            }
            
            // Compress the file if requested
            if ($request->boolean('compress')) {
                $gzFilename = $filename . '.gz';
                $gzPath = $backupDir . '/' . $gzFilename;
                
                $this->compressFile($tempPath, $gzPath);
                
                // Delete original SQL file
                if (file_exists($tempPath)) {
                    unlink($tempPath);
                }
                
                $filename = $gzFilename;
            }
            
            // Get file size
            $filePath = $backupDir . '/' . $filename;
            $fileSize = file_exists($filePath) ? $this->formatBytes(filesize($filePath)) : '0 B';
            
            Log::info('Database exported successfully', [
                'filename' => $filename,
                'user' => Auth::user()?->email ?? 'system',
                'size' => $fileSize
            ]);
            
            return redirect()->route('admin.database.index')
                ->with('success', "Database berhasil diekspor ke file: {$filename} ({$fileSize})");
                
        } catch (\Exception $e) {
            Log::error('Database export failed', [
                'error' => $e->getMessage(),
                'user' => Auth::user()?->email ?? 'system'
            ]);
            
            return redirect()->route('admin.database.index')
                ->with('error', 'Gagal mengekspor database: ' . $e->getMessage());
        }
    }

    /**
     * PHP-based database export (fallback when mysqldump is not available)
     */
    protected function exportWithPHP(string $filePath, array $selectedTables = []): void
    {
        $tables = $selectedTables ?: $this->getAllTables();
        $output = "-- BUMNag Database Backup\n";
        $output .= "-- Generated: " . Carbon::now()->format('Y-m-d H:i:s') . "\n";
        $output .= "-- PHP Version: " . phpversion() . "\n";
        $output .= "-- Database: " . config('database.connections.mysql.database') . "\n\n";
        $output .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
        
        foreach ($tables as $table) {
            // Get create table statement
            $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
            $output .= "-- Table: {$table}\n";
            $output .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $output .= $createTable[0]->{'Create Table'} . ";\n\n";
            
            // Get table data
            $rows = DB::table($table)->get();
            
            if ($rows->count() > 0) {
                $columns = array_keys((array) $rows->first());
                
                foreach ($rows as $row) {
                    $values = array_map(function($value) {
                        if ($value === null) {
                            return 'NULL';
                        }
                        return "'" . addslashes($value) . "'";
                    }, array_values((array) $row));
                    
                    $output .= "INSERT INTO `{$table}` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ");\n";
                }
                $output .= "\n";
            }
        }
        
        $output .= "SET FOREIGN_KEY_CHECKS=1;\n";
        
        file_put_contents($filePath, $output);
    }

    /**
     * Import database from SQL file
     */
    public function import(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|string',
            'confirm' => 'required|accepted',
        ]);
        
        try {
            $filename = $request->input('backup_file');
            $filePath = storage_path('app/' . $this->backupPath . '/' . $filename);
            
            if (!file_exists($filePath)) {
                return redirect()->route('admin.database.index')
                    ->with('error', 'File backup tidak ditemukan.');
            }
            
            // Handle compressed files
            $sqlContent = '';
            if (str_ends_with($filename, '.gz')) {
                $sqlContent = gzdecode(file_get_contents($filePath));
            } else {
                $sqlContent = file_get_contents($filePath);
            }
            
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            // Split SQL content into individual statements
            $statements = $this->parseSqlStatements($sqlContent);
            
            $successCount = 0;
            $errorCount = 0;
            
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (empty($statement) || strpos($statement, '--') === 0) {
                    continue;
                }
                
                try {
                    DB::unprepared($statement);
                    $successCount++;
                } catch (\Exception $e) {
                    $errorCount++;
                    Log::warning('SQL statement failed during import', [
                        'statement' => substr($statement, 0, 100),
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            // Clear caches
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            
            Log::info('Database imported successfully', [
                'filename' => $filename,
                'user' => Auth::user()?->email ?? 'system',
                'statements_success' => $successCount,
                'statements_error' => $errorCount
            ]);
            
            return redirect()->route('admin.database.index')
                ->with('success', "Database berhasil diimpor dari file: {$filename}. ({$successCount} statements berhasil" . ($errorCount > 0 ? ", {$errorCount} error" : "") . ")");
                
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            Log::error('Database import failed', [
                'error' => $e->getMessage(),
                'user' => Auth::user()?->email ?? 'system'
            ]);
            
            return redirect()->route('admin.database.index')
                ->with('error', 'Gagal mengimpor database: ' . $e->getMessage());
        }
    }

    /**
     * Upload and import database file
     */
    public function upload(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|file|mimes:sql,gz,zip,txt|max:102400', // Max 100MB
            'confirm_upload' => 'required|accepted',
        ]);
        
        try {
            $file = $request->file('sql_file');
            $filename = 'upload_' . Carbon::now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
            
            // Store the uploaded file
            $path = $file->storeAs($this->backupPath, $filename);
            
            Log::info('Database backup file uploaded', [
                'filename' => $filename,
                'user' => Auth::user()?->email ?? 'system',
                'size' => $this->formatBytes($file->getSize())
            ]);
            
            return redirect()->route('admin.database.index')
                ->with('success', "File berhasil diupload: {$filename}. Anda dapat mengimpornya dari daftar backup.");
                
        } catch (\Exception $e) {
            Log::error('Database file upload failed', [
                'error' => $e->getMessage(),
                'user' => Auth::user()?->email ?? 'system'
            ]);
            
            return redirect()->route('admin.database.index')
                ->with('error', 'Gagal mengupload file: ' . $e->getMessage());
        }
    }

    /**
     * Download backup file
     */
    public function download(string $filename)
    {
        $filePath = storage_path('app/' . $this->backupPath . '/' . $filename);
        
        if (!file_exists($filePath)) {
            return redirect()->route('admin.database.index')
                ->with('error', 'File backup tidak ditemukan.');
        }
        
        Log::info('Database backup downloaded', [
            'filename' => $filename,
            'user' => Auth::user()?->email ?? 'system'
        ]);
        
        return response()->download($filePath);
    }

    /**
     * Delete backup file
     */
    public function delete(string $filename)
    {
        try {
            $filePath = $this->backupPath . '/' . $filename;
            
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
                
                Log::info('Database backup deleted', [
                    'filename' => $filename,
                    'user' => Auth::user()?->email ?? 'system'
                ]);
                
                return redirect()->route('admin.database.index')
                    ->with('success', "File backup berhasil dihapus: {$filename}");
            }
            
            return redirect()->route('admin.database.index')
                ->with('error', 'File backup tidak ditemukan.');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.database.index')
                ->with('error', 'Gagal menghapus file: ' . $e->getMessage());
        }
    }

    /**
     * Run database migrations
     */
    public function migrate(Request $request)
    {
        try {
            // Create backup before migration
            if ($request->boolean('backup_first')) {
                $backupFilename = 'pre_migration_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
                $backupPath = storage_path('app/' . $this->backupPath . '/' . $backupFilename);
                Storage::makeDirectory($this->backupPath);
                $this->exportWithPHP($backupPath);
            }
            
            $output = Artisan::call('migrate', ['--force' => true]);
            $outputText = Artisan::output();
            
            Log::info('Database migration executed', [
                'user' => Auth::user()?->email ?? 'system',
                'output' => $outputText
            ]);
            
            return redirect()->route('admin.database.index')
                ->with('success', 'Migrasi database berhasil dijalankan.');
                
        } catch (\Exception $e) {
            Log::error('Database migration failed', [
                'error' => $e->getMessage(),
                'user' => Auth::user()?->email ?? 'system'
            ]);
            
            return redirect()->route('admin.database.index')
                ->with('error', 'Gagal menjalankan migrasi: ' . $e->getMessage());
        }
    }

    /**
     * Clear and rebuild caches
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            
            Log::info('Application cache cleared', [
                'user' => Auth::user()?->email ?? 'system'
            ]);
            
            return redirect()->route('admin.database.index')
                ->with('success', 'Cache aplikasi berhasil dibersihkan.');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.database.index')
                ->with('error', 'Gagal membersihkan cache: ' . $e->getMessage());
        }
    }

    /**
     * Optimize database tables
     */
    public function optimize()
    {
        try {
            $tables = $this->getAllTables();
            $optimized = [];
            
            foreach ($tables as $table) {
                DB::statement("OPTIMIZE TABLE `{$table}`");
                $optimized[] = $table;
            }
            
            Log::info('Database tables optimized', [
                'tables' => $optimized,
                'user' => Auth::user()?->email ?? 'system'
            ]);
            
            return redirect()->route('admin.database.index')
                ->with('success', 'Optimasi database berhasil. ' . count($optimized) . ' tabel dioptimasi.');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.database.index')
                ->with('error', 'Gagal mengoptimasi database: ' . $e->getMessage());
        }
    }

    /**
     * Get database information
     */
    protected function getDatabaseInfo(): array
    {
        $connection = config('database.default');
        $config = config("database.connections.{$connection}");
        
        // Get MySQL version
        $version = DB::select('SELECT VERSION() as version')[0]->version ?? 'Unknown';
        
        // Get database size
        $dbName = $config['database'];
        $sizeQuery = DB::select("
            SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) as size_mb
            FROM information_schema.TABLES 
            WHERE table_schema = ?
        ", [$dbName]);
        
        $size = $sizeQuery[0]->size_mb ?? 0;
        
        return [
            'driver' => $config['driver'] ?? 'mysql',
            'host' => $config['host'] ?? 'localhost',
            'port' => $config['port'] ?? 3306,
            'database' => $dbName,
            'username' => $config['username'] ?? '',
            'version' => $version,
            'size' => $size . ' MB',
            'charset' => $config['charset'] ?? 'utf8mb4',
            'collation' => $config['collation'] ?? 'utf8mb4_unicode_ci',
        ];
    }

    /**
     * Get database statistics
     */
    protected function getDatabaseStatistics(): array
    {
        $tables = $this->getAllTables();
        $tableStats = [];
        
        foreach ($tables as $table) {
            $stats = DB::select("
                SELECT 
                    table_name,
                    table_rows,
                    ROUND((data_length + index_length) / 1024 / 1024, 2) as size_mb,
                    ROUND(data_length / 1024 / 1024, 2) as data_size_mb,
                    ROUND(index_length / 1024 / 1024, 2) as index_size_mb,
                    engine,
                    table_collation,
                    create_time,
                    update_time
                FROM information_schema.TABLES 
                WHERE table_schema = ? AND table_name = ?
            ", [config('database.connections.mysql.database'), $table]);
            
            if (!empty($stats)) {
                $stat = (array) $stats[0];
                // Ensure all keys exist with default values
                $tableStats[] = [
                    'table_name' => $stat['table_name'] ?? $table,
                    'table_rows' => $stat['table_rows'] ?? 0,
                    'size_mb' => $stat['size_mb'] ?? 0,
                    'data_size_mb' => $stat['data_size_mb'] ?? 0,
                    'index_size_mb' => $stat['index_size_mb'] ?? 0,
                    'engine' => $stat['engine'] ?? 'Unknown',
                    'table_collation' => $stat['table_collation'] ?? null,
                    'create_time' => $stat['create_time'] ?? null,
                    'update_time' => $stat['update_time'] ?? null,
                ];
            }
        }
        
        // Sort by size descending
        usort($tableStats, function($a, $b) {
            return ($b['size_mb'] ?? 0) <=> ($a['size_mb'] ?? 0);
        });
        
        return [
            'total_tables' => count($tables),
            'tables' => $tableStats
        ];
    }

    /**
     * Get list of backup files
     */
    protected function getBackupFiles(): array
    {
        $files = [];
        $path = storage_path('app/' . $this->backupPath);
        
        if (!is_dir($path)) {
            Storage::makeDirectory($this->backupPath);
            return $files;
        }
        
        $allFiles = scandir($path);
        
        foreach ($allFiles as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            
            $filePath = $path . '/' . $file;
            
            if (is_file($filePath)) {
                $files[] = [
                    'name' => $file,
                    'size' => $this->formatBytes(filesize($filePath)),
                    'size_bytes' => filesize($filePath),
                    'date' => Carbon::createFromTimestamp(filemtime($filePath))->format('d M Y H:i:s'),
                    'timestamp' => filemtime($filePath),
                    'type' => pathinfo($file, PATHINFO_EXTENSION),
                ];
            }
        }
        
        // Sort by date descending
        usort($files, function($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });
        
        return $files;
    }

    /**
     * Get all database tables
     */
    protected function getAllTables(): array
    {
        $tables = DB::select('SHOW TABLES');
        $key = 'Tables_in_' . config('database.connections.mysql.database');
        
        return array_map(function($table) use ($key) {
            return $table->$key;
        }, $tables);
    }

    /**
     * Parse SQL statements from content
     */
    protected function parseSqlStatements(string $content): array
    {
        // Remove comments and split by semicolons
        $content = preg_replace('/--.*$/m', '', $content);
        $content = preg_replace('/\/\*.*?\*\//s', '', $content);
        
        return preg_split('/;\s*$/m', $content);
    }

    /**
     * Compress file with gzip
     */
    protected function compressFile(string $source, string $destination): void
    {
        $mode = 'wb9'; // Max compression
        $error = false;
        
        $fp_in = fopen($source, 'rb');
        $fp_out = gzopen($destination, $mode);
        
        while (!feof($fp_in)) {
            gzwrite($fp_out, fread($fp_in, 1024 * 512));
        }
        
        fclose($fp_in);
        gzclose($fp_out);
    }

    /**
     * Format bytes to human readable format
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
