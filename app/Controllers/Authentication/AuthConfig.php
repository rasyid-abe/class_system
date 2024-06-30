<?php

namespace App\Controllers\Authentication;

use App\Controllers\BaseController;
use App\Models\Authentication\UserModel;
use App\Models\Authentication\TokenModel;
use App\Models\Profiles\SchoolModel;

class AuthConfig extends BaseController
{
    protected $user;
    protected $token;
    protected $school;
    public function __construct()
    {
        $this->user = new UserModel();
        $this->token = new TokenModel();
        $this->school = new SchoolModel();
    }
    public function sign_in()
    {
        $data = array();
        $data["title"] = "Login";

        return view("authentication/sign_in", $data);
    }

    public function login()
    {
        if (
            !$this->validate([
                "username" => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kolom username harus diisi',
                    ]
                ],
                "password" => [
                    'rules' => "required|trim",
                    'errors' => [
                        'required' => 'Kolom password harus diisi',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $req = $this->request->getVar();
        $user = $this->user->getSingle(['user_name' => $req['username']]);
        
        if ($user) {
            if (strlen($user['user_password']) > 10) {
                $pass = password_verify($req['password'], $user['user_password']);
            } else {
                $pass = $req['password'] === $user['user_password'];
            }
            // dd($user);
            if ($pass) {
                if ($user['user_status'] == 1) {
                    if ($user['user_role_id'] == 11 || $user['user_role_id'] == 12) {
                        
                        $session = \Config\Services::session();
                        $data = [
                            'c_id' => $user['user_id'],
                            'c_role' => $user['user_role_id'],
                            'c_trial' => $user['user_is_trial']
                        ];
                        $session->set($data);
    
                        if ($user['user_role_id'] == 11) {
                            return redirect()->to('/dashboard/teacher');
                        } else if ($user['user_role_id'] == 12) {
                            return redirect()->to('/dashboard/student');
                        } 

                    } else {
                        session()->setFlashdata('msg', 'Akun <b>'.$req['username'].'</b> tidak memiliki wewenang untuk masuk ke sistem!');
                    }
                } else if ($user['user_status'] == 9) {
                    session()->setFlashdata('msg', 'Akun <b>'.$req['username'].'</b> sudah di hapus!');
                } else {
                    session()->setFlashdata('msg', 'Akun <b>'.$req['username'].'</b> belum aktif');
                }
            } else {
                session()->setFlashdata('user', $req['username']);
                session()->setFlashdata('msg', 'Password salah');
            }
        } else {
            session()->setFlashdata('msg', 'Akun <b>'.$req['username'].'</b> tidak ditemukan');
        }
        session()->setFlashdata('head', 'Gagal!');
        session()->setFlashdata('icon', 'error');
        session()->setFlashdata('hide', 5000);
        
        return redirect()->back();
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function forgot_password()
    {
        $data = array();
        $data["title"] = "Lupa Password";

        return view("authentication/forgot_password", $data);
    }

    public function reset_password($email, $token)
    {
        $row = $this->token->where(['token_email' => $email, 'token_code' => $token])->first();

        if ($row) {
            if (time() - $row['token_time'] < (60*60*24)) {
                $data = array();
                $data["title"] = "Reset Password";
                $data["email"] = $email;
                
                $this->token->where(['token_email' => $email, 'token_code' => $token])->delete();
                return view("authentication/reset_password", $data);
            } else {
                $this->token->where(['token_email' => $email, 'token_code' => $token])->delete();
                session()->setFlashdata('msg', 'Tautan reset password melebihi batas waktu!');
            }
        } else {
            session()->setFlashdata('msg', 'Email atau token tidak sesuai!');
        }
        session()->setFlashdata('head', 'Gagal!');
        session()->setFlashdata('icon', 'error');
        session()->setFlashdata('hide', 5000);

        return redirect()->to('/');
    }

    public function submit_reset_password()
    {
        if (
            !$this->validate([
                "new_password" => [
                    'rules' => "required|trim|min_length[8]",
                    'errors' => [
                        'required' => 'Kolom password baru harus diisi',
                        'min_length' => 'Minimal password harus 8 karakater',
                    ]
                ],
                "repeat_password" => [
                    'rules' => 'required|trim|matches[new_password]',
                    'errors' => [
                        'required' => 'Kolom ulangi password harus diisi',
                        'matches' => 'Password tidak sama'
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }
        
        $req = $this->request->getVar();

        $upd = $this->user
            ->where('user_email', $req['email'])
            ->set('user_password', password_hash($req['new_password'], PASSWORD_DEFAULT))
            ->update();
        
        if ($upd) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Password berhasil diubah.');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Password gagal diubah.');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/');
    }

    public function request_reset()
    {
        $req = $this->request->getVar();
        $res = [];
        $res['sts'] = false;

        $user_email = $this->user->where('user_email', $req['email'])->first();
        if ($user_email) {
            $is_verified = $user_email['user_email_verified'];
            if ($is_verified == 1) {

                $user_token = [
                    'token_email' => $req['email'],
                    'token_code' => random_char(32),
                    'token_time' => time()
                ];

                $email_view = view('authentication/link_reset_password', $user_token);
                // $is_send = 1;
                $is_send = send_email($req['email'], $email_view, 'Link reset password', 'Lifeco Helper');
                
                if ($is_send) {
                    $this->token->save($user_token);

                    $res['msg'] = '<h3>Tautan telah terkirim</h3><br><span>Silahkan cek email kamu untuk melakukan reset password</span>';
                    $res['sts'] = true;
                } else {
                    $res['msg'] = 'Terjadi kesalahan. Coba beberapa saat lagi';
                }
            } else {
                $res['msg'] = 'Email belum diverifikasi!';
            }
        } else {
            $res['msg'] = 'Email tidak terdaftar!';
        }
        
        echo json_encode($res);
    }

    public function blocked()
    {
        return view("authentication/blocked");
    }
    public function notfound()
    {
        return view("authentication/notfound");
    }

}
