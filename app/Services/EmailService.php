<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        $this->mailer->isSMTP();
        $this->mailer->Host       = env('MAIL_HOST', 'smtp.example.com');
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = env('MAIL_USERNAME');
        $this->mailer->Password   = env('MAIL_PASSWORD');
        $this->mailer->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
        $this->mailer->Port       = env('MAIL_PORT', 587);
        $this->mailer->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->SMTPKeepAlive = true;
    }

    public function sendRegisterSuccess($toEmail, $toName)
    {
        try {
            $this->mailer->addAddress($toEmail, $toName);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Registrasi Berhasil';
            $this->mailer->Body = '
                                    <!DOCTYPE html>
                                    <html lang="id">
                                    <head>
                                    <meta charset="UTF-8">
                                    <title>Registrasi Berhasil</title>
                                    </head>
                                    <body style="background-color: #f4f4f4; margin: 0; padding: 20px; font-family: Arial, sans-serif;">
                                    <table style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 10px;">
                                        <tr>
                                        <td style="text-align: center;">
                                            <img src="https://diskominfo.badungkab.go.id/theme/error/images/badung.png" alt="Logo" style="margin-bottom: 20px;">
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                            <h2 style="color: #333333;">Selamat Datang, '.$toName.'!</h2>
                                            <p style="color: #555555; font-size: 16px;">
                                            Terima kasih telah melakukan registrasi. Kami senang menyambut Anda ke dalam komunitas kami.
                                            </p>
                                            <p style="color: #555555; font-size: 16px;">
                                            Jangan ragu untuk mengeksplorasi layanan kami dan hubungi kami jika ada pertanyaan.
                                            </p>
                                            <div style="text-align: center; margin-top: 30px;">
                                            <a href="https://badungkab.go.id" style="background-color: #007bff; color: #ffffff; padding: 12px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                                                Mulai Sekarang
                                            </a>
                                            </div>
                                            <p style="margin-top: 40px; color: #aaaaaa; font-size: 12px; text-align: center;">
                                            &copy; '.date('Y').' DISKOMINFO BADUNG. All rights reserved.
                                            </p>
                                        </td>
                                        </tr>
                                    </table>
                                    </body>
                                    </html>';

            $this->mailer->send();
        } catch (Exception $e) {
            dd("Email gagal dikirim: " . $e->getMessage());
        }
    }
}
