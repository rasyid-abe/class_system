<style>html,body { padding: 0; margin:0; }</style>
                <div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
                        <tbody>
                            <tr>
                                <td align="center" valign="center" style="text-align:center; padding: 40px">
                                    <a href="https://keenthemes.com" rel="noopener" target="_blank">
                                        <img alt="Logo" src="../../assets/media/logos/mail.svg" style="min-height: 50px;" />
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" valign="center">
                                    <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px">
                                        <!--begin:Email content-->
                                        <div style="padding-bottom: 30px; font-size: 17px;">
                                            <strong>Halo!</strong>
                                        </div>
                                        <div style="padding-bottom: 30px">Kamu menerima email ini karena kami mendapati kamu akan melakukan verifikasi email. Untuk melakukan verifikasi email, klik tombol dibawah:</div>
                                        <div style="padding-bottom: 40px; text-align:center;">
                                            <a href="<?= base_url() . 'dashboard/school/validate-email/' . $token_email . '/' . $token_code ?>" rel="noopener" style="text-decoration:none;display:inline-block;text-align:center;padding:0.75575rem 1.3rem;font-size:0.925rem;line-height:1.5;border-radius:0.35rem;color:#ffffff;background-color:#009ef7;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle" target="_blank">Verifikasi Email</a>
                                        </div>
                                        <div style="padding-bottom: 30px">Tautan verifikasi email ini akan berakhir dalam 120 menit. Jika Anda tidak melakukan verifikasi email, maka abaikan email ini.</div>
                                        <div style="border-bottom: 1px solid #eeeeee; margin: 15px 0"></div>
                                        <div style="padding-bottom: 50px; word-wrap: break-all;">
                                            <p style="margin-bottom: 10px;">Tombol tidak berfungsi? Coba tempelkan URL ini ke browser Anda:</p>
                                            <a href="<?= base_url() . 'dashboard/school/validate-email/' . $token_email . '/' . $token_code ?>" rel="noopener" target="_blank" style="text-decoration:none;color: #009ef7"><?= base_url() . 'dashboard/school/validate-email/' . $token_email . '/' . $token_code ?></a>
                                        </div>
                                        <!--end:Email content-->
                                        <div style="padding-bottom: 10px">Salam,
                                        <br>Lifeco Team.
                                        <tr>
                                            <td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
                                                <p>Floor 5, 450 Avenue of the Red Field, SF, 10050, USA.</p>
                                                <p>Copyright &copy;
                                                <a href="https://keenthemes.com" rel="noopener" target="_blank">Keenthemes</a>.</p>
                                            </td>
                                        </tr></br></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>