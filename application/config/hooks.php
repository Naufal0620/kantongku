<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/

$hook['pre_system'] = function() {
    // 1. LOAD AUTOLOAD MANUAL
    // Kita wajib load ini manual karena config.php belum jalan di tahap pre_system
    if (file_exists(FCPATH . 'vendor/autoload.php')) {
        require_once FCPATH . 'vendor/autoload.php';
    } else {
        // Jika tidak ada vendor, hentikan eksekusi agar tidak error fatal
        return; 
    }

    // 2. TENTUKAN ENV MODE
    // Cek apakah ada variabel lingkungan CI_ENV dari server/htaccess
    $env_mode = getenv('CI_ENV') ?: 'development';

    // 3. PILIH FILE .ENV
    $env_filename = ($env_mode === 'production') ? '.env.production' : '.env.development';
    
    // 4. LOAD DOTENV
    if (file_exists(FCPATH . $env_filename)) {
        try {
            // Gunakan createImmutable agar aman
            $dotenv = Dotenv\Dotenv::createImmutable(FCPATH, $env_filename);
            $dotenv->load();
        } catch (Exception $e) {
            // Biarkan lanjut (silent fail) atau log error jika perlu
        }
    }

    // 5. DEFINE ENVIRONMENT CONSTANT (PENTING)
    // Agar index.php atau config lain tahu kita di env mana
    if (!defined('ENVIRONMENT')) {
        define('ENVIRONMENT', getenv('CI_ENV') ?: $env_mode);
    }
};