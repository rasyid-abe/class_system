<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Profiles\SchoolModel;
use App\Models\Datas\TerritoryModel;
use App\Models\Authentication\UserModel;
use App\Models\Authentication\TokenModel;

class DashboardSchool extends BaseController
{
    protected $title;
    protected $school;
    protected $territory;
    protected $user;
    protected $token;
    public function __construct()
    {
        $this->title = "Dashboard";
        $this->school = new SchoolModel();
        $this->user = new UserModel();
        $this->territory = new TerritoryModel();
        $this->token = new TokenModel();
    }
    public function index()
    {
        $data = array();
        $data["title"] = $this->title;
        $data["sidebar"] = "Sekolah";
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Sekolah',
        ];
        
        $data['user'] = userdata();
        # filter tahun ajaran & semester
        # total guru 
        # total mapel
        # total siswa
        # total rombel

        return view("dashboard/school", $data);
    }

    public function email_verify()
    {
        $req = $this->request->getVar();
        
        $user_token = [
            'token_email' => $req['email'],
            'token_code' => random_char(32),
            'token_time' => time()
        ];

        $email_view = view('dashboard/link_email_verify', $user_token);
        $is_send = send_email($req['email'], $email_view, 'Verifikasi Email', 'Lifeco Helper');

        $res = [];
        if ($is_send) {
            $this->token->save($user_token);

            $res['msg'] = '<h3>Tautan telah terkirim</h3><br><span>Silahkan cek email kamu untuk melakukan verifikasi</span>';
            $res['sts'] = true;
        } else {
            $res['msg'] = '<h3>Terjadi kesalahan</h3><br><span>Siahkan verifikasi beberapa saat lagi.</span>';
            $res['sts'] = false;
        }

        echo json_encode($res);
    }

    public function validate_email($email, $token){
        $row = $this->token->where(['token_email' => $email, 'token_code' => $token])->first();
        $res = [];
        $res['head'] = 'Terjadi kesalahan';
        if ($row) {
            if (time() - $row['token_time'] < (60*60*24)) {
               $upd = $this->user
                    ->where('user_email', $row['token_email'])
                    ->set('user_email_verified', 1)
                    ->update();

                    if ($upd) {
                    $this->token->where(['token_email' => $email, 'token_code' => $token])->delete();

                    $res['head'] = 'Selamat!';
                    $res['msg'] = 'Email kamu telah berhasil diverifikasi';
                    
                    // return redirect()->to('/email-verified');
                    return view('dashboard/email_verified', $res);
                } else {
                    $res['msg'] = 'Silahkan coba beberapa saat lagi';
                }
            } else {
                $this->token->where(['token_email' => $email, 'token_code' => $token])->delete();
                $res['head'] = 'Gagal';
                $res['msg'] = 'Tautan validasi email melebihi batas waktu!';
            }
        } else {
            $this->token->where(['token_email' => $email, 'token_code' => $token])->delete();
            $res['msg'] = 'Token tidak sesuai, cobalah untuk kirim ulang tautan verifikasi!';
        }

        // return redirect()->to('/email-verified');
        return view('dashboard/email_verified', $res);
    }
    
    public function show($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Sekolah';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/dashboard/school' => 'Sekolah',
            '##' => 'Profil Sekolah',
        ];

        $data['edit_btn'] = '/dashboard/school/edit/' . userdata()['id_profile'];
        $data['level'] = get_list('school_level');
        $data['religion'] = get_list('religion');
        $data['province'] = $this->territory->list_province();
        $data['row'] = $this->school->show($id);

        return view("schoolms/school/profile", $data);
    }

    public function edit($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Sekolah';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/dashboard/school' => 'Sekolah',
            '##' => 'Ubah Profil',
        ];

        $data['url_territory'] = '/dashboard/school/list_area';
        $data['level'] = get_list('school_level');
        $data['province'] = $this->territory->list_province();
        $data['row'] = $this->school->show($id);

        return view("schoolms/school/edit", $data);
    }

    public function list_area()
    {
        $data = $this->request->getVar();
        echo json_encode($this->territory->list_area($data));
    }

    public function update()
    {
        $req = $this->request->getVar();

        $old = $this->school->where('school_id', $req['school_id'])->first();
        $npsn_rule = $old['school_npsn'] == $req['npsn'] ? 'required|min_length[6]' : 'required|min_length[6]|is_unique[profile_school.school_npsn]';
        $phone_rule = $old['school_phone'] == $req['phone'] ? 'required' : 'required|is_unique[profile_school.school_phone]';

        $old_user = $this->user->where('user_id', $old['school_user_id'])->first();
        $email_rule = $old_user['user_email'] == $req['email'] ? 'required|valid_email' : 'required|valid_email|is_unique[account_user.user_email]';

        $ls_prov = $this->territory->arr_id_prov();
        $ls_rege = $this->territory->arr_id_rege(2, $req['province'], 5);
        $ls_dist = $this->territory->arr_id_rege(5, $req['regency'], 8);

        if (
            !$this->validate([
                "npsn" => [
                    'rules' => $npsn_rule,
                    'errors' => [
                        'required' => 'Kolom NPSN harus diisi',
                        'is_unique' => 'NPSN sudah terdaftar',
                        'min_length' => 'Minimal karakter 6 digit',
                    ]
                ],
                "name" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nama sekolah harus diisi',
                    ]
                ],
                "alias" => [
                    'rules' => 'required|max_length[15]',
                    'errors' => [
                        'required' => 'Kolom alias sekolah harus diisi',
                        'max_length' => 'Maksimal panjang alias sekolah 15 digit'
                    ]
                ],
                "level" => [
                    'rules' => 'in_list[1,2,3]',
                    'errors' => [
                        'in_list' => 'Kolom jenjang sekolah harus dipilih',
                    ]
                ],
                "email" => [
                    'rules' => $email_rule,
                    'errors' => [
                        'required' => 'Kolom email harus diisi',
                        'valid_email' => 'Alamat email tidak valid',
                        'is_unique' => 'Alamat email sudah terdaftar'
                    ]
                ],
                "phone" => [
                    'rules' => $phone_rule,
                    'errors' => [
                        'required' => 'Kolom no hp/telepon harus diisi',
                        'is_unique' => 'No hp/telepon sudah terdaftar'
                    ]
                ],
                "principal" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom kepala sekolah harus diisi',
                    ]
                ],
                "principal_nip" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom NIP kepala sekolah harus diisi',
                    ]
                ],
                "province" => [
                    'rules' => 'in_list[' . $ls_prov . ']',
                    'errors' => [
                        'in_list' => 'Kolom provinsi harus dipilih',
                    ]
                ],
                "regency" => [
                    'rules' => 'in_list[' . $ls_rege . ']',
                    'errors' => [
                        'in_list' => 'Kolom kabupaten/kota harus dipilih',
                    ]
                ],
                "subdistrict" => [
                    'rules' => 'in_list[' . $ls_dist . ']',
                    'errors' => [
                        'in_list' => 'Kolom kecamatan harus dipilih',
                    ]
                ],
                "postal_code" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom kode pos harus diisi',
                    ]
                ],
                "address" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom alamat lengkap harus diisi',
                    ]
                ],
                "logo" => [
                    'rules' => 'mime_in[logo,image/png,image/jpeg,image/jpg]|max_size[logo,1024]|is_image[logo]',
                    'errors' => [
                        'mime_in' => 'Tipe gambar harus PNG atau JPEG',
                        'max_size' => 'Ukuran maksimal file 1 Mb',
                        'is_image' => 'File terdeteksi bukan image',
                    ]
                ],
                "ttdhead" => [
                    'rules' => 'mime_in[ttdhead,image/png]|max_size[ttdhead,1024]|is_image[ttdhead]',
                    'errors' => [
                        'mime_in' => 'Tipe gambar harus PNG',
                        'max_size' => 'Ukuran maksimal file 1 Mb',
                        'is_image' => 'File terdeteksi bukan gambar',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }        

        $img_logo = $this->request->getFile('logo');
        if ($img_logo->getError() == 4) {
            $logo_name = $req['old_logo'];
        } else {
            $logo_name = $img_logo->getRandomName();
            $img_logo->move('images/school', $logo_name);

            if ($req['old_logo'] != 'default.png') {
                if (file_exists('images/school/' . $req['old_logo'])) {
                    unlink('images/school/' . $req['old_logo']);
                }
            }
        }

        $img_ttd = $this->request->getFile('ttdhead');
        if ($img_ttd->getError() == 4) {
            $ttd_name = $req['old_ttd'];
        } else {
            $ttd_name = $img_ttd->getRandomName();
            $img_ttd->move('images/school', $ttd_name);

            if ($req['old_ttd'] != 'default.png') {
                if (file_exists('images/school/' . $req['old_ttd'])) {
                    unlink('images/school/' . $req['old_ttd']);
                }
            }
        }

        $this->user
            ->where('user_id', $old_user['user_id'])
            ->set('user_email', htmlspecialchars($req['email']))
            ->set('user_email_verified', 0)
            ->update();

        $school = [
            'school_npsn' => htmlspecialchars($req['npsn']),
            'school_name' => htmlspecialchars($req['name']),
            'school_alias' => htmlspecialchars($req['alias']),
            'school_level' => htmlspecialchars($req['level']),
            'school_foundation' => htmlspecialchars($req['foundation']),
            'school_logo' => $logo_name,
            'school_phone' => htmlspecialchars($req['phone']),
            'school_website' => htmlspecialchars($req['website']),
            'school_principal' => htmlspecialchars($req['principal']),
            'school_principal_nip' => htmlspecialchars($req['principal_nip']),
            'school_principal_sign' => $ttd_name,
            'school_province' => htmlspecialchars($req['province']),
            'school_regency' => htmlspecialchars($req['regency']),
            'school_subdistrict' => htmlspecialchars($req['subdistrict']),
            'school_postal_code' => htmlspecialchars($req['postal_code']),
            'school_address' => htmlspecialchars($req['address']),
            'school_map_latitude' => htmlspecialchars($req['map_latitude']),
            'school_map_longitude' => htmlspecialchars($req['map_longitude']),
        ];

        $update = $this->school
            ->where("school_id", $req["school_id"])
            ->set($school)
            ->update();

        if ($update) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Ubah sekolah berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Ubah sekolah gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/dashboard/school/edit/' . $req["school_id"]);
    }

    public function change_password()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Sekolah';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/dashboard/school' => 'Sekolah',
            '##' => 'Ubah Password',
        ];

        $data['row'] = $this->school->show(userdata()['id_profile']);

        return view("dashboard/password", $data);
    }

    public function update_password()
    {
        if (
            !$this->validate([
                "old_password" => [
                    'rules' => "required|trim|min_length[8]",
                    'errors' => [
                        'required' => 'Kolom password harus diisi',
                    ]
                ],
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
        $upd = change_pass($req);

        if ($upd['status']) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', $upd['msg']);
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', $upd['msg']);
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to(userdata()['change_password']);
    }

}
