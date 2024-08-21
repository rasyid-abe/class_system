<?php

namespace App\Controllers\SchoolMS\Users;

use App\Controllers\BaseController;
use App\Models\Profiles\TeacherModel;
use App\Models\Authentication\UserModel;
use App\Models\Datas\TerritoryModel;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;

class Teacher extends BaseController
{

    protected $title;
    protected $teacher;
    protected $user;
    protected $territory;

    public function __construct()
    {
        $this->title = "User";
        $this->teacher = new TeacherModel();
        $this->user = new UserModel();
        $this->territory = new TerritoryModel();
    }

    public function index()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Guru';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Guru',
        ];

        $data['teacher'] = $this->teacher->view_get_all();
        return view("schoolms/teacher/index", $data);
    }

    public function create()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Guru';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/user/teacher' => 'Guru',
            '##' => 'Tambah Guru',
        ];

        $data['religion'] = get_list('religion');
        $data['province'] = $this->territory->list_province();

        return view("schoolms/teacher/create", $data);
    }

    public function list_area()
    {
        $data = $this->request->getVar();
        echo json_encode($this->territory->list_area($data));
    }

    public function store()
    {
        $req = $this->request->getVar();

        if (
            !$this->validate([
                "avatar" => [
                    'rules' => 'mime_in[avatar,image/png,image/jpeg,image/jpg]|max_size[avatar,1024]|is_image[avatar]',
                    'errors' => [
                        'mime_in' => 'Tipe image harus PNG atau JPEG',
                        'max_size' => 'Ukuran maksimal file 1 Mb',
                        'is_image' => 'File terdeteksi bukan image',
                    ]
                ],
                "nip" => [
                    'rules' => 'permit_empty|numeric|my_unique[profile.teacher.nip]',
                    'errors' => [
                        'numeric' => 'Kolom NIP hanya menerima angka',
                        'my_unique' => 'NIP sudah terdaftar',
                    ]
                ],
                "nuptk" => [
                    'rules' => 'permit_empty|numeric|my_unique[profile.teacher.nuptk]',
                    'errors' => [
                        'numeric' => 'Kolom NUPTK hanya menerima angka',
                        'my_unique' => 'NUPTK sudah terdaftar',
                    ]
                ],
                "first_name" => [
                    'rules' => 'required|alpha_space',
                    'errors' => [
                        'required' => 'Kolom nama harus diisi',
                        'alpha_space' => 'Kolom nama depan hanya menerima huruf saja'
                    ]
                ],
                "last_name" => [
                    'rules' => 'required|alpha_space',
                    'errors' => [
                        'required' => 'Kolom nama harus diisi',
                        'alpha_space' => 'Kolom nama belakang hanya menerima huruf saja'
                    ]
                ],
                "nick_name" => [
                    'rules' => 'required|alpha_space',
                    'errors' => [
                        'required' => 'Kolom kode guru harus diisi',
                        'alpha_space' => 'Kolom kode guru hanya menerima huruf saja'
                    ]
                ],
                "birth_date" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal lahir harus diisi',
                    ]
                ],
                "religion" => [
                    'rules' => 'in_list[1,2,3,4,5,6]',
                    'errors' => [
                        'in_list' => 'Kolom agama harus dipilih',
                    ]
                ],
                "gender" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom jenis kelamin harus dipilih',
                    ]
                ],
                "email" => [
                    'rules' => 'permit_empty|valid_email|my_unique[account.user.email]',
                    'errors' => [
                        'valid_email' => 'Alamat email tidak valid',
                        'my_unique' => 'Alamat email sudah terdaftar'
                    ]
                ],
                "phone" => [
                    'rules' => 'permit_empty|numeric|my_unique[profile.teacher.phone]',
                    'errors' => [
                        'numeric' => 'Kolom no hp hanya menerima angka',
                        'my_unique' => 'No handphone sudah terdaftar'
                    ]
                ],
                "postal_code" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'alpha' => 'Kolom kode pos hanya menerima angka saja'
                    ]
                ],
                "employment_status" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom status kepegawaian harus dipilih',
                    ]
                ],
                "is_teaching" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom mengajar di kelas harus dipilih',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }
        $img_avatar = $this->request->getFile('avatar');
        if ($img_avatar->getError() == 4) {
            $avatar_name = 'default.png';
        } else {
            $avatar_name = $img_avatar->getRandomName();
            $img_avatar->move('images/teacher', $avatar_name);
        }

        $fn = explode(' ', htmlspecialchars($req['first_name']));
        $password = 'g-' . random_char(8);
        
        do {
            $username = 'g' . rand(1000, 9999) . '.' . strtolower(end($fn)) . '@' . school_alias();
        } while (username_exists($username) > 0);

        $this->user->db->transBegin();
        try {
            $acount_user = [
                'user_name' => $username,
                'user_email' => htmlspecialchars($req['email']),
                'user_password' => $password,
                'user_role_id' => 11,
                'user_status' => 1,
                'user_trial' => 0,
                'user_created_by' => userdata()['user_id'],
            ];
            $ins_user = $this->user->save($acount_user);
            if ($ins_user === false) {
                throw new \Exception('Insert account failed!');
            }
    
            $ins_teacher = [
                'teacher_user_id' => $this->user->getInsertID(),
                'teacher_school_id' => userdata()['school_id'],
                'teacher_nip' => htmlspecialchars($req['nip']),
                'teacher_nuptk' => htmlspecialchars($req['nuptk']),
                'teacher_first_name' => htmlspecialchars($req['first_name']),
                'teacher_last_name' => htmlspecialchars($req['last_name']),
                'teacher_degree' => htmlspecialchars($req['degree']),
                'teacher_nick_name' => htmlspecialchars($req['nick_name']),
                'teacher_birth_date' => $req['birth_date'],
                'teacher_gender' => htmlspecialchars($req['gender']),
                'teacher_religion' => htmlspecialchars($req['religion']),
                'teacher_phone' => htmlspecialchars($req['phone']),
                'teacher_image' => $avatar_name,
                'teacher_province' => htmlspecialchars($req['province']),
                'teacher_regency' => htmlspecialchars($req['regency']),
                'teacher_subdistrict' => htmlspecialchars($req['subdistrict']),
                'teacher_postal_code' => htmlspecialchars($req['postal_code']),
                'teacher_address' => htmlspecialchars($req['address']),
                'teacher_employment_status' => htmlspecialchars($req['employment_status']),
                'teacher_is_teaching' => htmlspecialchars($req['is_teaching']),
                'teacher_status' => 1,
                'teacher_created_by' => userdata()['user_id'],
            ];
            $this->teacher->save($ins_teacher);
            $this->user->db->transCommit();

            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Tambah guru/tendik berhasil');
            session()->setFlashdata('hide', 3000);
        } catch (\Exception $e) {
            $this->user->db->transRollback();
            
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Tambah guru/tendik gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/user/teacher/');
    }

    public function show($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Guru';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/user/teacher' => 'Guru',
            '##' => 'Profil Guru',
        ];

        $data['data_id'] = $id;
        $data['religion'] = get_list('religion');
        $data['province'] = $this->territory->list_province();
        $data['row'] = $this->teacher->show($id);

        return view("schoolms/teacher/profile", $data);
    }

    public function edit($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Guru';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/user/teacher' => 'Guru',
            '##' => 'Ubah Guru',
        ];

        $data['religion'] = get_list('religion');
        $data['province'] = $this->territory->list_province();
        $data['row'] = $this->teacher->show($id);

        return view("schoolms/teacher/edit", $data);
    }

    public function update()
    {
        $req = $this->request->getVar();

        $old = $this->teacher->where('teacher_id', $req['teacher_id'])->first();
        $nip_rule = $old['teacher_nip'] == $req['nip'] ? 'permit_empty|numeric' : 'permit_empty|numeric|my_unique[profile.teacher.nip]';
        $nuptk_rule = $old['teacher_nuptk'] == $req['nuptk'] ? 'permit_empty|numeric' : 'permit_empty|numeric|my_unique[profile.teacher.nuptk]';

        $old_user = $this->user->where('user_id', $old['teacher_user_id'])->first();
        $email_rule = $old_user['user_email'] == $req['email'] ? 'permit_empty|valid_email' : 'permit_empty|valid_email|my_unique[account.user.email]';
        $phone_rule = $old['teacher_phone'] == $req['phone'] ? 'permit_empty|numeric' : 'permit_empty|numeric|my_unique[profile.teacher.phone]';

        if (
            !$this->validate([
                "avatar" => [
                    'rules' => 'mime_in[avatar,image/png,image/jpeg,image/jpg]|max_size[avatar,1024]|is_image[avatar]',
                    'errors' => [
                        'mime_in' => 'Tipe image harus PNG atau JPEG',
                        'max_size' => 'Ukuran maksimal file 1 Mb',
                        'is_image' => 'File terdeteksi bukan image',
                    ]
                ],
                "nip" => [
                    'rules' => $nip_rule,
                    'errors' => [
                        'numeric' => 'Kolom NIP hanya menerima angka',
                        'my_unique' => 'NIP sudah terdaftar',
                    ]
                ],
                "nuptk" => [
                    'rules' => $nuptk_rule,
                    'errors' => [
                        'numeric' => 'Kolom NUPTK hanya menerima angka',
                        'my_unique' => 'NUPTK sudah terdaftar',
                    ]
                ],
                "first_name" => [
                    'rules' => 'required|alpha_space',
                    'errors' => [
                        'required' => 'Kolom nama harus diisi',
                        'alpha_space' => 'Kolom nama depan hanya menerima huruf saja'
                    ]
                ],
                "last_name" => [
                    'rules' => 'required|alpha_space',
                    'errors' => [
                        'required' => 'Kolom nama harus diisi',
                        'alpha_space' => 'Kolom nama belakang hanya menerima huruf saja'
                    ]
                ],
                "nick_name" => [
                    'rules' => 'permit_empty|alpha_space',
                    'errors' => [
                        'alpha_space' => 'Kolom nama singkatan hanya menerima huruf saja'
                    ]
                ],
                "birth_date" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal lahir harus diisi',
                    ]
                ],
                "religion" => [
                    'rules' => 'in_list[1,2,3,4,5,6]',
                    'errors' => [
                        'in_list' => 'Kolom agama harus dipilih',
                    ]
                ],
                "gender" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom jenis kelamin harus dipilih',
                    ]
                ],
                "email" => [
                    'rules' => $email_rule,
                    'errors' => [
                        'valid_email' => 'Alamat email tidak valid',
                        'my_unique' => 'Alamat email sudah terdaftar'
                    ]
                ],
                "phone" => [
                    'rules' => $phone_rule,
                    'errors' => [
                        'numeric' => 'Kolom no hp hanya menerima angka',
                        'my_unique' => 'No handphone sudah terdaftar',
                    ]
                ],
                "postal_code" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'alpha' => 'Kolom kode pos hanya menerima angka saja'
                    ]
                ],
                "employment_status" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom status kepegawaian harus dipilih',
                    ]
                ],
                "is_teaching" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom mengajar di kelas harus dipilih',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $img_avatar = $this->request->getFile('avatar');
        if ($img_avatar->getError() == 4) {
            $avatar_name = $req['old_avatar'];
        } else {
            $avatar_name = $img_avatar->getRandomName();
            $img_avatar->move('images/teacher', $avatar_name);

            if ($req['old_avatar'] != 'default.png') {
                if (file_exists('images/teacher/' . $req['old_avatar'])) {
                    unlink('images/teacher/' . $req['old_avatar']);
                }
            }
        }

        $this->user
            ->where('user_id', $old_user['user_id'])
            ->set('user_email', htmlspecialchars($req['email']))
            ->set('user_email_verified', 0)
            ->set("user_updated_by", userdata()['user_id'])
            ->update();

        $update_teacher = [
            'teacher_nip' => htmlspecialchars($req['nip']),
            'teacher_nuptk' => htmlspecialchars($req['nuptk']),
            'teacher_first_name' => htmlspecialchars($req['first_name']),
            'teacher_last_name' => htmlspecialchars($req['last_name']),
            'teacher_nick_name' => htmlspecialchars($req['nick_name']),
            'teacher_birth_date' => $req['birth_date'],
            'teacher_degree' => htmlspecialchars($req['degree']),
            'teacher_gender' => htmlspecialchars($req['gender']),
            'teacher_religion' => htmlspecialchars($req['religion']),
            'teacher_phone' => htmlspecialchars($req['phone']),
            'teacher_image' => $avatar_name,
            'teacher_province' => htmlspecialchars($req['province']),
            'teacher_regency' => htmlspecialchars($req['regency']),
            'teacher_subdistrict' => htmlspecialchars($req['subdistrict']),
            'teacher_postal_code' => htmlspecialchars($req['postal_code']),
            'teacher_address' => htmlspecialchars($req['address']),
            'teacher_employment_status' => htmlspecialchars($req['employment_status']),
            'teacher_is_teaching' => htmlspecialchars($req['is_teaching']),
            'teacher_updated_by' => userdata()['user_id'],
        ];

        $update = $this->teacher
            ->where("teacher_id", $req["teacher_id"])
            ->set($update_teacher)
            ->update();

        if ($update) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Ubah guru berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Ubah guru gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/user/teacher/');
    }

    public function destroy()
    {
        $id = $this->request->getVar()['id'];
        $user_id = $this->teacher->where('teacher_id', $id)->first()['teacher_user_id'];

        $delete = $this->teacher
            ->where('teacher_id', $id)
            ->set('teacher_status', 9)
            ->set("teacher_updated_by", userdata()['user_id'])
            ->update();

        if ($delete) {
            $this->user->where('user_id', $user_id)->set('user_status', 9)->update();
        }

        echo json_encode(['msg' => 'dihapus', 'sts' => true]);
    }

    public function status()
    {
        $req = $this->request->getVar();
        $nsts = $req['sts'] == 1 ? 0 : 1;

        $msg = $nsts > 0 ? "aktifkan" : "nonaktifkan";
        $this->teacher
            ->where("teacher_id", $req['id'])
            ->set("teacher_status", $nsts)
            ->set("teacher_updated_by", userdata()['user_id'])
            ->update();

        echo json_encode(['msg' => $msg, 'sts' => true]);
    }

    public function reset_password_not_used()
    {
        $row = $this->teacher->where('teacher_id', $this->request->getVar('id'))->first();
        $password = 'g-' . random_char(8);

        $reset = $this->user
            ->where('user_id', $row['teacher_user_id'])
            ->set('user_password', $password)
            ->set("teacher_updated_by", userdata()['user_id'])
            ->update();

        $res = [
            'status' => $reset,
            'new_pass' => $password,
        ];

        echo json_encode($res);
    }

    public function view_credential()
    {
        $id = $this->request->getVar('id');
        $row = $this->user->where('user_id', teacher_user_id($id))->first();
        $password = 'g-' . random_char(8);

        $reset = $this->user
            ->where('user_id', $row['user_id'])
            ->set('user_password', $password)
            ->set("teacher_updated_by", userdata()['user_id'])
            ->update();

        $user = $this->teacher->where('teacher_id', $id)->first();
        $degree = $user['teacher_degree'] != '' ? ', '.$user['teacher_degree'] : '';
        $res = [
            'status' => $reset,
            'user' => $user['teacher_first_name'].' '.$user['teacher_last_name'].$degree,
            'password' => strlen($row['user_password']) == 10 ? $row['user_password'] : '[sudah diubah]',
            'username' => $row['user_name'],
        ];

        echo json_encode($res);
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->freezePane('A6');
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
       
        $style_row_center = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $sheet->setCellValue('A1', "Import Data Guru & Tendik");
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14); // Set bold kolom A1

        $sheet->setCellValue('A2', strtoupper(userdata()['name']));
        $sheet->mergeCells('A2:J2');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(20); // Set bold kolom A1
        // $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12); // Set bold kolom A1
        // $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(16)->getColor()->setRGB ('478C3B'); // Set bold kolom A1
        
        $sheet->setCellValue('A3', userdata()['address']);
        $sheet->mergeCells('A3:J3');
        $sheet->getStyle('A3')->getFont()->setSize(12); // Set bold kolom A1
        

        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A5', "NO");
        $sheet->setCellValue('B5', "NIP");
        $sheet->setCellValue('C5', "NUPTK");
        $sheet->setCellValue('D5', "KODE GURU");
        $sheet->setCellValue('E5', "NAMA DEPAN");
        $sheet->setCellValue('F5', "NAMA BELAKANG");
        $sheet->setCellValue('G5', "GELAR AKADEMIK");
        $sheet->setCellValue('H5', "TANGGAL LAHIR");
        $sheet->setCellValue('I5', "JENIS KELAMIN");
        $sheet->setCellValue('J5', "AGAMA");
        $sheet->setCellValue('K5', "NO. TELP/HP");
        $sheet->setCellValue('L5', "EMAIL");
        $sheet->setCellValue('M5', "PROVINSI");
        $sheet->setCellValue('N5', "KABUPATEN/KOTA");
        $sheet->setCellValue('O5', "KECAMATAN");
        $sheet->setCellValue('P5', "ALAMAT");
        $sheet->setCellValue('Q5', "KODE POS");
        $sheet->setCellValue('R5', "STATUS KEPEGAWAIAN");
        $sheet->setCellValue('S5', "MENGAJAR DI KELAS");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header

        $sheet->getStyle('A5:S5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('478C3B');

        $sheet->getStyle('D5:F5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('fc0303');

        $sheet->getStyle('H5:J5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('fc0303');

        $sheet->getStyle('R5:S5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('fc0303');

        $sheet->getStyle('A5')->applyFromArray($style_col);
        $sheet->getStyle('B5')->applyFromArray($style_col);
        $sheet->getStyle('C5')->applyFromArray($style_col);
        $sheet->getStyle('D5')->applyFromArray($style_col);
        $sheet->getStyle('E5')->applyFromArray($style_col);
        $sheet->getStyle('F5')->applyFromArray($style_col);
        $sheet->getStyle('G5')->applyFromArray($style_col);
        $sheet->getStyle('H5')->applyFromArray($style_col);
        $sheet->getStyle('I5')->applyFromArray($style_col);
        $sheet->getStyle('J5')->applyFromArray($style_col);
        $sheet->getStyle('K5')->applyFromArray($style_col);
        $sheet->getStyle('L5')->applyFromArray($style_col);
        $sheet->getStyle('M5')->applyFromArray($style_col);
        $sheet->getStyle('N5')->applyFromArray($style_col);
        $sheet->getStyle('O5')->applyFromArray($style_col);
        $sheet->getStyle('P5')->applyFromArray($style_col);
        $sheet->getStyle('Q5')->applyFromArray($style_col);
        $sheet->getStyle('R5')->applyFromArray($style_col);
        $sheet->getStyle('S5')->applyFromArray($style_col);

        $no = 1;
        $numrow = 6;

        $gender = [1 => 'Laki-laki', 2 => 'Perempuan'];
        $religion = get_list('religion');
        $is_teaching = [1 => 'Ya', 2 => 'Tidak'];
        $status_employement = [1 => 'PNS', 2 => 'Tetap', 3 => 'Honorer'];

        // dd($status_employement);

        // start data
        $sheet->setCellValue('A' . $numrow, $no);
        $sheet->setCellValue('B' . $numrow, '1111111111');
        $sheet->setCellValue('C' . $numrow, '2222222222');
        $sheet->setCellValue('D' . $numrow, 'RY');
        $sheet->setCellValue('E' . $numrow, 'Agus');
        $sheet->setCellValue('F' . $numrow, 'Susanto');
        $sheet->setCellValue('G' . $numrow, 'S.Pd');
        $sheet->setCellValue('H' . $numrow, '1990-04-30');
        $sheet->setCellValue('I' . $numrow, 'Laki-laki');
        $sheet->setCellValue('J' . $numrow, 'Islam');
        $sheet->setCellValue('K' . $numrow, '089000000000');
        $sheet->setCellValue('L' . $numrow, 'guru@mail.com');
        $sheet->setCellValue('M' . $numrow, 'SUMATERA UTARA');
        $sheet->setCellValue('N' . $numrow, 'KOTA BINJAI');
        $sheet->setCellValue('O' . $numrow, 'Binjai Selatan');
        $sheet->setCellValue('P' . $numrow, 'Jl. Protokol No. 12 Kel. Setempat');
        $sheet->setCellValue('Q' . $numrow, '20276');
        $sheet->setCellValue('R' . $numrow, 'Tetap');
        $sheet->setCellValue('S' . $numrow, 'Ya');

        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $sheet->getStyle('A' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('B' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode('#');
        $sheet->getStyle('C' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('D' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('G' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('H' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('I' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('J' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('K' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('L' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('M' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('N' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('O' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('P' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('Q' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('R' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('S' . $numrow)->applyFromArray($style_row_center);


        for ($i=$numrow; $i <= 1006; $i++) { 
            # drop down list gender
            $genderValidation = $sheet->getCell('I' . $i)->getDataValidation();
            $genderValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $genderValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $genderValidation->setAllowBlank(false);
            $genderValidation->setShowInputMessage(true);
            $genderValidation->setShowErrorMessage(true);
            $genderValidation->setShowDropDown(true);
            $genderValidation->setErrorTitle('Input salah');
            $genderValidation->setError('Nilai tidak ada dalam daftar');
            $genderValidation->setPromptTitle('Pilih dari daftar');
            $genderValidation->setPrompt('Mohon pilih nilai dari daftar yang tersedia.');
            $genderValidation->setFormula1('"' . implode(',', $gender) . '"');
    
            # drop down list religion
            $religionValidation = $sheet->getCell('J' . $i)->getDataValidation();
            $religionValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $religionValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $religionValidation->setAllowBlank(false);
            $religionValidation->setShowInputMessage(true);
            $religionValidation->setShowErrorMessage(true);
            $religionValidation->setShowDropDown(true);
            $religionValidation->setErrorTitle('Input salah');
            $religionValidation->setError('Nilai tidak ada dalam daftar');
            $religionValidation->setPromptTitle('Pilih dari daftar');
            $religionValidation->setPrompt('Mohon pilih nilai dari daftar yang tersedia.');
            $religionValidation->setFormula1('"' . implode(',', $religion) . '"');
    
            # drop down list is transfer
            $religionValidation = $sheet->getCell('R' . $i)->getDataValidation();
            $religionValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $religionValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $religionValidation->setAllowBlank(false);
            $religionValidation->setShowInputMessage(true);
            $religionValidation->setShowErrorMessage(true);
            $religionValidation->setShowDropDown(true);
            $religionValidation->setErrorTitle('Input salah');
            $religionValidation->setError('Nilai tidak ada dalam daftar');
            $religionValidation->setPromptTitle('Pilih dari daftar');
            $religionValidation->setPrompt('Mohon pilih nilai dari daftar yang tersedia.');
            $religionValidation->setFormula1('"' . implode(',', $status_employement) . '"');
    
            # drop down list is transfer
            $religionValidation = $sheet->getCell('S' . $i)->getDataValidation();
            $religionValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $religionValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $religionValidation->setAllowBlank(false);
            $religionValidation->setShowInputMessage(true);
            $religionValidation->setShowErrorMessage(true);
            $religionValidation->setShowDropDown(true);
            $religionValidation->setErrorTitle('Input salah');
            $religionValidation->setError('Nilai tidak ada dalam daftar');
            $religionValidation->setPromptTitle('Pilih dari daftar');
            $religionValidation->setPrompt('Mohon pilih nilai dari daftar yang tersedia.');
            $religionValidation->setFormula1('"' . implode(',', $is_teaching) . '"');
        }
        // end data

        // Set width kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);


        $sheet->getStyle('A7:B'.$numrow-1)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('478C3B');

        // # protection cell
        $sheet->getProtection()->setSheet(true);
        $sheet->getStyle('A6:S1006')->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Import GuruT & Tendik ");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="E-SchoolMS - Template Import Guru dan Tendik.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function export()
    {
        # get all data
        $rows = $this->teacher->get_all();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->freezePane('A8');
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $style_col_center = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $style_row_center = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        // # lOGO SEKOLAH
        // $drawing->setName('Image');
        // $drawing->setDescription('Image');
        // $drawing->setPath('images/school/' . userdata()['image']);
        // $drawing->setCoordinates('A1');
        // // $drawing->setHeight(80);
        // $drawing->setWidth(130);
        // $drawing->setWorksheet($sheet);

        $sheet->setCellValue('A1', "Data Guru & Tendik");
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14); // Set bold kolom A1

        $sheet->setCellValue('A2', strtoupper(userdata()['name']));
        $sheet->mergeCells('A2:J2');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(20); // Set bold kolom A1
        // $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12); // Set bold kolom A1
        // $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(16)->getColor()->setRGB ('478C3B'); // Set bold kolom A1

        $sheet->setCellValue('A3', userdata()['address']);
        $sheet->mergeCells('A3:J3');
        $sheet->getStyle('A3')->getFont()->setSize(12); // Set bold kolom A1

        $sheet->setCellValue('A4', 'Total Guru dan Tendik : ' . count($rows));
        $sheet->mergeCells('A4:J4');
        $sheet->getStyle('A4')->getFont()->setSize(12); // Set bold kolom A1


        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A7', "NO");
        $sheet->setCellValue('B7', "NIP");
        $sheet->setCellValue('C7', "NUPTK");
        $sheet->setCellValue('D7', "KODE GURU");
        $sheet->setCellValue('E7', "NAMA DEPAN");
        $sheet->setCellValue('F7', "NAMA BELAKANG");
        $sheet->setCellValue('G7', "GELAR AKADEMIK");
        $sheet->setCellValue('H7', "TANGGAL LAHIR");
        $sheet->setCellValue('I7', "JENIS KELAMIN");
        $sheet->setCellValue('J7', "AGAMA");
        $sheet->setCellValue('K7', "NO. TELP/HP");
        $sheet->setCellValue('L7', "EMAIL");
        $sheet->setCellValue('M7', "PROVINSI");
        $sheet->setCellValue('N7', "KABUPATEN/KOTA");
        $sheet->setCellValue('O7', "KECAMATAN");
        $sheet->setCellValue('P7', "ALAMAT");
        $sheet->setCellValue('Q7', "KODE POS");
        $sheet->setCellValue('R7', "STATUS KEPEGAWAIAN");
        $sheet->setCellValue('S7', "MENGAJAR DI KELAS");
        $sheet->setCellValue('T7', "FOTO");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header

        $sheet->getStyle('A7:T7')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('478C3B');

        $sheet->getStyle('E7:F7')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('fc0303');

        $sheet->getStyle('H7:J7')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('fc0303');
            
        $sheet->getStyle('R7:S7')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('fc0303');

        $sheet->getStyle('A7')->applyFromArray($style_col_center);
        $sheet->getStyle('B7')->applyFromArray($style_col_center);
        $sheet->getStyle('C7')->applyFromArray($style_col_center);
        $sheet->getStyle('D7')->applyFromArray($style_col_center);
        $sheet->getStyle('E7')->applyFromArray($style_col);
        $sheet->getStyle('F7')->applyFromArray($style_col);
        $sheet->getStyle('G7')->applyFromArray($style_col_center);
        $sheet->getStyle('H7')->applyFromArray($style_col_center);
        $sheet->getStyle('I7')->applyFromArray($style_col_center);
        $sheet->getStyle('J7')->applyFromArray($style_col_center);
        $sheet->getStyle('K7')->applyFromArray($style_col_center);
        $sheet->getStyle('L7')->applyFromArray($style_col_center);
        $sheet->getStyle('M7')->applyFromArray($style_col_center);
        $sheet->getStyle('N7')->applyFromArray($style_col_center);
        $sheet->getStyle('O7')->applyFromArray($style_col_center);
        $sheet->getStyle('P7')->applyFromArray($style_col);
        $sheet->getStyle('Q7')->applyFromArray($style_col_center);
        $sheet->getStyle('R7')->applyFromArray($style_col_center);
        $sheet->getStyle('S7')->applyFromArray($style_col_center);
        $sheet->getStyle('T7')->applyFromArray($style_col_center);

        $no = 1;
        $numrow = 8;

        $gender = [1 => 'Laki-laki', 2 => 'Perempuan'];
        $religion = get_list('religion');
        $is_teaching = [1 => 'Ya', 2 => 'Tidak'];
        $status_employement = [1 => 'PNS', 2 => 'Tetap', 3 => 'Honorer'];

        foreach ($rows as $data) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data->teacher_nip);
            $sheet->setCellValue('C' . $numrow, $data->teacher_nuptk);
            $sheet->setCellValue('D' . $numrow, $data->teacher_nick_name);
            $sheet->setCellValue('E' . $numrow, $data->teacher_first_name);
            $sheet->setCellValue('F' . $numrow, $data->teacher_last_name);
            $sheet->setCellValue('G' . $numrow, $data->teacher_degree);
            $sheet->setCellValue('H' . $numrow, $data->teacher_birth_date);
            $sheet->setCellValue('I' . $numrow, $gender[$data->teacher_gender]);
            $sheet->setCellValue('J' . $numrow, $religion[$data->teacher_religion]);
            $sheet->setCellValue('K' . $numrow, $data->teacher_phone);
            $sheet->setCellValue('L' . $numrow, $data->user_email);
            $sheet->setCellValue('M' . $numrow, $data->teacher_province != '' ? territory_name($data->teacher_province) : '');
            $sheet->setCellValue('N' . $numrow, $data->teacher_regency != 0 ? territory_name($data->teacher_regency) : '');
            $sheet->setCellValue('O' . $numrow, $data->teacher_subdistrict != 0 ? territory_name($data->teacher_subdistrict) : '');
            $sheet->setCellValue('P' . $numrow, $data->teacher_address);
            $sheet->setCellValue('Q' . $numrow, $data->teacher_postal_code != 0 ? $data->teacher_postal_code : '');
            $sheet->setCellValue('R' . $numrow, $data->teacher_employment_status > 0 ? $status_employement[$data->teacher_employment_status] : '');
            $sheet->setCellValue('S' . $numrow, $data->teacher_is_teaching > 0 ? $is_teaching[$data->teacher_is_teaching] : '');
            $sheet->setCellValue('U' . $numrow, $data->user_id);
            $sheet->setCellValue('V' . $numrow, $data->teacher_id);

            # hyperlink excel
            $imglink = new Hyperlink(base_url('images/teacher/' . $data->teacher_image), 'Lihat Foto');
            $sheet->setCellValue('T' . $numrow, 'Foto Guru');
            $sheet->getCell('T' . $numrow)->setHyperlink($imglink);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode('#');
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode('#');
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('K' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('L' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('M' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('N' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('O' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('P' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('Q' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('R' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('S' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('T' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('U' . $numrow)->getFont()->getColor()->setRGB('ffffff');
            $sheet->getStyle('V' . $numrow)->getFont()->getColor()->setRGB('ffffff');

            # drop down list gender
            $genderValidation = $sheet->getCell('I' . $numrow)->getDataValidation();
            $genderValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $genderValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $genderValidation->setAllowBlank(false);
            $genderValidation->setShowInputMessage(true);
            $genderValidation->setShowErrorMessage(true);
            $genderValidation->setShowDropDown(true);
            $genderValidation->setErrorTitle('Input salah');
            $genderValidation->setError('Nilai tidak ada dalam daftar');
            $genderValidation->setPromptTitle('Pilih dari daftar');
            $genderValidation->setPrompt('Mohon pilih nilai dari daftar yang tersedia.');
            $genderValidation->setFormula1('"' . implode(',', $gender) . '"');

            # drop down list religion
            $religionValidation = $sheet->getCell('J' . $numrow)->getDataValidation();
            $religionValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $religionValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $religionValidation->setAllowBlank(false);
            $religionValidation->setShowInputMessage(true);
            $religionValidation->setShowErrorMessage(true);
            $religionValidation->setShowDropDown(true);
            $religionValidation->setErrorTitle('Input salah');
            $religionValidation->setError('Nilai tidak ada dalam daftar');
            $religionValidation->setPromptTitle('Pilih dari daftar');
            $religionValidation->setPrompt('Mohon pilih nilai dari daftar yang tersedia.');
            $religionValidation->setFormula1('"' . implode(',', $religion) . '"');

            # drop down list is transfer
            $religionValidation = $sheet->getCell('R' . $numrow)->getDataValidation();
            $religionValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $religionValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $religionValidation->setAllowBlank(false);
            $religionValidation->setShowInputMessage(true);
            $religionValidation->setShowErrorMessage(true);
            $religionValidation->setShowDropDown(true);
            $religionValidation->setErrorTitle('Input salah');
            $religionValidation->setError('Nilai tidak ada dalam daftar');
            $religionValidation->setPromptTitle('Pilih dari daftar');
            $religionValidation->setPrompt('Mohon pilih nilai dari daftar yang tersedia.');
            $religionValidation->setFormula1('"' . implode(',', $status_employement) . '"');

            # drop down list is transfer
            $religionValidation = $sheet->getCell('S' . $numrow)->getDataValidation();
            $religionValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $religionValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $religionValidation->setAllowBlank(false);
            $religionValidation->setShowInputMessage(true);
            $religionValidation->setShowErrorMessage(true);
            $religionValidation->setShowDropDown(true);
            $religionValidation->setErrorTitle('Input salah');
            $religionValidation->setError('Nilai tidak ada dalam daftar');
            $religionValidation->setPromptTitle('Pilih dari daftar');
            $religionValidation->setPrompt('Mohon pilih nilai dari daftar yang tersedia.');
            $religionValidation->setFormula1('"' . implode(',', $is_teaching) . '"');

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);

        $sheet->getStyle('A7:D' . $numrow - 1)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('478C3B');

        // # protection cell
        $sheet->getProtection()->setSheet(true);
        $sheet->getStyle('E8:S' . $numrow - 1)->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("GURU & TENDIK");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="E-SchoolMS - Guru & Tendik.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function import_insert()
    {
        $filedata = $_FILES['import']['tmp_name'];

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filedata);
        $spreadsheet = $reader->load($filedata);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $religion = get_list('religion');
        $status_employement = [1 => 'PNS', 2 => 'Tetap', 3 => 'Honorer'];

        $idx_row = 4;
        $success = 0;
        $failed = 0;
        foreach ($sheetData as $k => $v) {
            if ($k > $idx_row) {
                if ($v[1] != '') {
                    $this->user->db->transBegin();
                    try {
                        $fn = explode(' ', htmlspecialchars(htmlspecialchars($v[4])));
                        $password = 'g-' . random_char(8);
                        
                        do {
                            $username = 'g' . rand(1000, 9999) . '.' . strtolower(end($fn)) . '@' . school_alias();
                        } while (username_exists($username) > 0);

                        $acount_user = [
                            'user_name' => $username,
                            'user_password' => $password,
                            'user_email' => htmlspecialchars($v[11]),
                            'user_role_id' => 11,
                            'user_status' => 1,
                            'user_trial' => 0,
                        ];
                        $ins_user = $this->user->insert($acount_user);
                        if ($ins_user === false) {
                            throw new \Exception('Insert account failed!');
                        }
    
                        $teacher = [
                            'teacher_school_id' => userdata()['id_profile'],
                            'teacher_user_id' => $this->user->getInsertID(),
                            'teacher_nip' => htmlspecialchars($v[1]),
                            'teacher_nuptk' => htmlspecialchars($v[2]),
                            'teacher_nick_name' => htmlspecialchars($v[3]),
                            'teacher_first_name' => htmlspecialchars($v[4]),
                            'teacher_last_name' => htmlspecialchars($v[5]),
                            'teacher_degree' => htmlspecialchars($v[6]),
                            'teacher_birth_date' => date("Y-m-d", strtotime(htmlspecialchars($v[7]))),
                            'teacher_gender' => htmlspecialchars($v[8]) == 'Laki-laki' ? 1 : 2,
                            'teacher_religion' => array_search(htmlspecialchars($v[9]), $religion),
                            'teacher_image' => 'default.png',
                            'teacher_phone' => htmlspecialchars($v[10]),
                            'teacher_province' => $v[12] != '' ? territory_code(htmlspecialchars($v[12])) : '',
                            'teacher_regency' => $v[13] != '' ? territory_code(htmlspecialchars($v[13])) : '',
                            'teacher_subdistrict' => $v[14] != '' ? territory_code(htmlspecialchars($v[14])) : '',
                            'teacher_address' => htmlspecialchars($v[15]),
                            'teacher_postal_code' => htmlspecialchars($v[16]),
                            'teacher_employment_status' => array_search(htmlspecialchars($v[17]), $status_employement),
                            'teacher_is_teaching' => htmlspecialchars($v[18]) == 'Ya' ? 1 : 2,
                            'teacher_status' => 1,
                        ];
                        $this->teacher->insert($teacher);
    
                        $this->user->db->transCommit();
                        $success++;
                    } catch (\Exception $e) {
                        $this->user->db->transRollback();
                        $failed++;
                    }
                }
            }
        }

        session()->setFlashdata('head', 'Informasi!');
        session()->setFlashdata('icon', 'info');
        session()->setFlashdata('msg', $success . ' data berhasil di import,' . $failed . ' data gagal di import.');
        session()->setFlashdata('hide', 3000);

        return redirect()->to('/sms/user/teacher/');
    }

    public function import_update()
    {
        $filedata = $_FILES['import']['tmp_name'];

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filedata);
        $spreadsheet = $reader->load($filedata);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $religion = get_list('religion');
        $status_employement = [1 => 'PNS', 2 => 'Tetap', 3 => 'Honorer'];

        $idx_row = $sheetData[3][0] == "NO" ? 3 : 6;
        $success = 0;
        $failed = 0;
        foreach ($sheetData as $k => $v) {
            if ($k > $idx_row) {
                if ($v[1] != '') {
                    $this->user->db->transBegin();
                    try {
                        $upd_user = $this->user
                            ->where('user_id', $v[20])
                            ->set('user_email', $v[11])
                            ->update();

                        if($upd_user===false){
                            throw new \Exception('Update account failed!');
                        }

                        // $teacher = [
                        //     'teacher_nip' => htmlspecialchars($v[1]),
                        //     'teacher_nuptk' => htmlspecialchars($v[2]),
                        //     'teacher_nick_name' => htmlspecialchars($v[3]),
                        //     'teacher_first_name' => htmlspecialchars($v[4]),
                        //     'teacher_last_name' => htmlspecialchars($v[5]),
                        //     'teacher_degree' => htmlspecialchars($v[6]),
                        //     'teacher_birth_date' => date("Y-m-d", strtotime(htmlspecialchars($v[7]))),
                        //     'teacher_gender' => htmlspecialchars($v[8]) == 'Laki-laki' ? 1 : 2,
                        //     'teacher_religion' => array_search(htmlspecialchars($v[9]), $religion),
                        //     'teacher_image' => 'default.png',
                        //     'teacher_phone' => htmlspecialchars($v[10]),
                        //     'teacher_province' => $v[12] != '' ? territory_code(htmlspecialchars($v[12])) : '',
                        //     'teacher_regency' => $v[13] != '' ? territory_code(htmlspecialchars($v[13])) : '',
                        //     'teacher_subdistrict' => $v[14] != '' ? territory_code(htmlspecialchars($v[14])) : '',
                        //     'teacher_address' => htmlspecialchars($v[15]),
                        //     'teacher_postal_code' => htmlspecialchars($v[16]),
                        //     'teacher_employment_status' => array_search(htmlspecialchars($v[17]), $status_employement),
                        //     'teacher_is_teaching' => htmlspecialchars($v[18]) == 'Ya' ? 1 : 2,
                        //     'teacher_status' => 1,
                        // ];

                        $this->teacher
                            ->where('teacher_id', $v[21])
                            ->set('teacher_nip', htmlspecialchars($v[1]))
                            ->set('teacher_nuptk', htmlspecialchars($v[2]))
                            ->set('teacher_nick_name', htmlspecialchars($v[3]))
                            ->set('teacher_first_name', htmlspecialchars($v[4]))
                            ->set('teacher_last_name', htmlspecialchars($v[5]))
                            ->set('teacher_degree', htmlspecialchars($v[6]))
                            ->set('teacher_birth_date', date("Y-m-d", strtotime(htmlspecialchars($v[7]))))
                            ->set('teacher_gender', htmlspecialchars($v[8]) == 'Laki-laki' ? 1 : 2)
                            ->set('teacher_religion', array_search(htmlspecialchars($v[9]), $religion))
                            ->set('teacher_phone', htmlspecialchars($v[10]))
                            ->set('teacher_province', $v[12] != '' ? territory_code(htmlspecialchars($v[12])) : '')
                            ->set('teacher_regency', $v[13] != '' ? territory_code(htmlspecialchars($v[13])) : '')
                            ->set('teacher_subdistrict', $v[14] != '' ? territory_code(htmlspecialchars($v[14])) : '')
                            ->set('teacher_address', htmlspecialchars($v[15]))
                            ->set('teacher_postal_code', htmlspecialchars($v[16]))
                            ->set('teacher_employment_status', array_search(htmlspecialchars($v[17]), $status_employement))
                            ->set('teacher_is_teaching', htmlspecialchars($v[18]) == 'Ya' ? 1 : 2)
                            ->update();
    
                        $this->user->db->transCommit();
                        $success++;
                    } catch (\Exception $e) {
                        dd($e);
                        $this->user->db->transRollback();
                        $failed++;
                    }
                }

            }
        }

        session()->setFlashdata('head', 'Informasi!');
        session()->setFlashdata('icon', 'info');
        session()->setFlashdata('msg', $success . ' data berhasil di import,' . $failed . ' data gagal di import.');
        session()->setFlashdata('hide', 3000);

        return redirect()->to('/sms/user/teacher/');
    }
}