<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class LoadEnv
 * Hook untuk memuat file .env yang sesuai (development/production)
 * Harus dijalankan pada tahap 'pre_system'.
 */
class LoadEnv {

    public function load_dotenv()
    {
        // Pastikan composer/vendor autoload sudah dimuat,
        // (Biasanya sudah di index.php, tapi ini untuk jaga-jaga)
        if (!file_exists(FCPATH . 'vendor/autoload.php')) {
            return;
        }
        
        require_once FCPATH . 'vendor/autoload.php';

        // 1. Tentukan Environment Mode
        // Cek CI_ENV dari server (htaccess) atau default ke development
        $env_mode = getenv('CI_ENV') ?: 'development';

        // 2. Tentukan File .env mana yang dimuat
        $env_filename = ($env_mode === 'production') ? '.env.production' : '.env.development';
        $env_file_path = FCPATH . $env_filename;

        // 3. Load .env yang sesuai
        if (file_exists($env_file_path)) {
            try {
                $dotenv = Dotenv\Dotenv::createImmutable(FCPATH, $env_filename);
                $dotenv->safeLoad(); // safeLoad tidak akan error jika variabel sudah ada
            } catch (Exception $e) {
                // Biarkan CodeIgniter berjalan jika ada error
            }
        }
        
        // 4. Update Konstanta ENVIRONMENT CI3 (Ini PENTING)
        // Jika belum didefinisikan, kita definisikan sekarang
        if (!defined('ENVIRONMENT')) {
            // Setelah dotenv dimuat, kita bisa pakai getenv()
            $ci_env = getenv('CI_ENV') ?: $env_mode;
            define('ENVIRONMENT', $ci_env);
        }
    }
}