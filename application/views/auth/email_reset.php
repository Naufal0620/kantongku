<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <style>
        /* Reset CSS dasar untuk email client */
        body { margin: 0; padding: 0; min-width: 100%; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; background-color: #f3f4f6; color: #333333; }
        a { color: #22c55e; text-decoration: none; }
        table { border-collapse: collapse; width: 100%; }
        
        /* Container Utama */
        .wrapper { width: 100%; table-layout: fixed; background-color: #f3f4f6; padding-bottom: 40px; }
        .main-content { background-color: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        
        /* Header */
        .header { background-color: #22c55e; padding: 30px 0; text-align: center; }
        .app-name { color: #ffffff; font-size: 24px; font-weight: bold; letter-spacing: 1px; }
        
        /* Body */
        .body-section { padding: 40px 30px; }
        .heading { font-size: 22px; font-weight: bold; margin-bottom: 20px; color: #111827; }
        .text { color: #4B5563; margin-bottom: 24px; }
        
        /* Button */
        .btn-container { text-align: center; margin: 30px 0; }
        .btn { background-color: #22c55e; color: #ffffff !important; padding: 14px 30px; border-radius: 8px; font-weight: bold; display: inline-block; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2); }
        .btn:hover { background-color: #059669; }
        
        /* Footer */
        .footer { background-color: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb; font-size: 12px; color: #9CA3AF; }
        
        /* Mobile Responsive */
        @media screen and (max-width: 600px) {
            .main-content { width: 100% !important; border-radius: 0 !important; }
            .body-section { padding: 30px 20px !important; }
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center" style="padding-top: 40px; padding-bottom: 40px;">
                    
                    <div class="main-content">
                        <div class="header">
                            <div class="app-name">
                                KantongKu
                            </div>
                        </div>

                        <div class="body-section">
                            <h1 class="heading">Lupa Password?</h1>
                            <p class="text">
                                Halo Sobat Hemat! 👋<br>
                                Kami menerima permintaan untuk mereset password akun <b>KantongKu</b> Anda.
                            </p>
                            <p class="text">
                                Jangan khawatir, klik tombol di bawah ini untuk membuat password baru:
                            </p>

                            <div class="btn-container">
                                <a href="<?= $url; ?>" class="btn">Reset Password Saya</a>
                            </div>

                            <p class="text" style="font-size: 14px; margin-top: 30px;">
                                <small>Atau copy link berikut ke browser Anda:</small><br>
                                <a href="<?= $url; ?>" style="word-break: break-all; font-size: 12px;"><?= $url; ?></a>
                            </p>

                            <p class="text" style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                                <em>Jika Anda tidak merasa meminta reset password, abaikan saja email ini. Akun Anda tetap aman.</em>
                            </p>
                        </div>

                        <div class="footer">
                            &copy; <?= date('Y'); ?> KantongKu App.<br>
                            Dibuat dengan ❤️ untuk Mahasiswa.
                        </div>
                    </div>

                </td>
            </tr>
        </table>
    </div>

</body>
</html>