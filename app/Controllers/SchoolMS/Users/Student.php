<?php

namespace App\Controllers\SchoolMS\Users;

use App\Controllers\BaseController;
use App\Models\Profiles\StudentModel;
use App\Models\Masters\StudentGroupModel;
use App\Models\Systems\StudentInGroupModel;
use App\Models\Authentication\UserModel;
use App\Models\Datas\TerritoryModel;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;

class Student extends BaseController
{
    
    protected $title;
    protected $student;
    protected $student_group;
    protected $student_in_group;
    protected $user;
    protected $territory;

    public function __construct()
    {
        $this->title = "User";
        $this->student = new StudentModel();
        $this->student_group = new StudentGroupModel();
        $this->student_in_group = new StudentInGroupModel();
        $this->user = new UserModel();
        $this->territory = new TerritoryModel();
    }

    public function index()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Siswa';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Siswa',
        ];

        $data['student'] = $this->student->list_student();
        $data['grade'] = get_list('grade')[school_level()];

        return view("schoolms/student/index", $data);
    }
    
    public function create()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Siswa';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/user/student' => 'Siswa',
            '##' => 'Tambah Siswa',
        ];
        
        $data['religion'] = get_list('religion');
        $data['province'] = $this->territory->list_province();
        $data['grade'] = get_list('grade')[school_level()]; 

        return view("schoolms/student/create", $data);
    }

    public function student_group()
    {
        $data = $this->request->getVar();
        echo json_encode($this->student_group->list_group($data));
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
                "foto" => [
                    'rules' => 'mime_in[foto,image/png,image/jpeg,image/jpg]|max_size[foto,1024]|is_image[foto]',
                    'errors' => [
                        'mime_in' => 'Tipe image harus PNG atau JPEG',
                        'max_size' => 'Ukuran maksimal file 1 Mb',
                        'is_image' => 'File terdeteksi bukan image',
                    ]
                ],
                "nisn" => [
                    'rules' => 'required|numeric|my_unique[profile.student.nisn]',
                    'errors' => [
                        'required' => 'Kolom NISN harus diisi',
                        'numeric' => 'Kolom NISN hanya menerima angka',
                        'my_unique' => 'NISN sudah terdaftar',
                    ]
                ],
                "phone" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'numeric' => 'Kolom no hp hanya menerima angka',
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
                "birth_date" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal lahir harus diisi',
                    ]
                ],
                "birth_place" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tempat lahir harus diisi',
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
                "religion" => [
                    'rules' => 'in_list[1,2,3,4,5,6]',
                    'errors' => [
                        'in_list' => 'Kolom agama harus dipilih',
                    ]
                ],
                "postal_code" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'alpha' => 'Kolom kode pos hanya menerima angka saja'
                    ]
                ],
                "order_child" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'numeric' => 'Kolom anak ke hanya menerima angka',
                    ]
                ],
                "father_name" => [
                    'rules' => 'permit_empty|alpha_space',
                    'errors' => [
                        'alpha_space' => 'Kolom nama ayah hanya menerima huruf saja'
                    ]
                ],
                "mother_name" => [
                    'rules' => 'permit_empty|alpha_space',
                    'errors' => [
                        'alpha_space' => 'Kolom nama ibu hanya menerima huruf saja'
                    ]
                ],
                "parent_phone" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'alpha' => 'Kolom no. hp orang tua hanya menerima angka saja'
                    ]
                ],
                "parent_postal_code" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'numeric' => 'Kolom kode pos orang tua hanya menerima angka saja'
                    ]
                ],
                "guardian_name" => [
                    'rules' => 'permit_empty|alpha_space',
                    'errors' => [
                        'alpha_space' => 'Kolom wali hanya menerima huruf saja'
                    ]
                ],
                "guardian_phone" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'alpha' => 'Kolom no. hp wali hanya menerima angka saja'
                    ]
                ],
                "guardian_postal_code" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'numeric' => 'Kolom kode pos wali hanya menerima angka saja'
                    ]
                ],
                "grade" => [
                    'rules' => 'in_list[1,2,3,4,5,6,7,8,9,10,11,12]',
                    'errors' => [
                        'in_list' => 'Kolom kelas harus dipilih',
                    ]
                ],
                "student_group" => [
                    'rules' => 'not_in_list[0]',
                    'errors' => [
                        'not_in_list' => 'Kolom rombongan belajar harus dipilih',
                    ]
                ],
                "registered_date" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal diterima harus dipilih',
                    ]
                ],
                "transfer" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom terdaftar sebagai harus dipilih',
                    ]
                ],
                "previous_school" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom sekolah sebelumnya harus diisi',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $img_foto = $this->request->getFile('foto');
        if ($img_foto->getError() == 4) {
            $foto_name = 'default.png';
        } else {
            $foto_name = $img_foto->getRandomName();
            $img_foto->move('images/student', $foto_name);
        }

        $fn = explode(' ', htmlspecialchars($req['first_name']));
        $password = 's-' . random_char(8);
        
        do {
            $username = 's' . rand(1000, 9999) . '.' . strtolower(end($fn)) . '@' . school_alias();
        } while (username_exists($username) > 0);

        $this->user->db->transBegin();
        try {
            $ins_user = [
                'user_name' => $username,
                'user_email' => $req['email'],
                'user_password' => $password,
                'user_role_id' => 12,
                'user_status' => 1,
                'user_trial' => 0,
            ];
            $inuser = $this->user->save($ins_user);
            if ($inuser === false) {
                throw new \Exception('Insert account failed!');
            }

            $ins_student = [
                'student_user_id' => $this->user->getInsertID(),
                'student_school_id' => userdata()['school_id'],
                'student_nisn' => htmlspecialchars($req['nisn']),
                'student_first_name' => htmlspecialchars($req['first_name']),
                'student_last_name' => htmlspecialchars($req['last_name']),
                'student_birth_place' => htmlspecialchars($req['birth_place']),
                'student_birth_date' => $req['birth_date'],
                'student_child_order_in_family' => htmlspecialchars($req['order_child']),
                'student_gender' => htmlspecialchars($req['gender']),
                'student_religion' => htmlspecialchars($req['religion']),
                'student_phone' => htmlspecialchars($req['phone']),
                'student_province' => htmlspecialchars($req['province']),
                'student_regency' => htmlspecialchars($req['regency']),
                'student_subdistrict' => htmlspecialchars($req['subdistrict']),
                'student_postal_code' => htmlspecialchars($req['postal_code']),
                'student_address' => htmlspecialchars($req['address']),
                'student_image' => $foto_name,
                'student_is_transfer' => isset($req['transfer']) ? $req['transfer'] : 0,
                'student_registered_date' => $req['registered_date'],
                'student_registered_information' => htmlspecialchars($req['registered_information']),
                'student_previous_school' => htmlspecialchars($req['previous_school']),
                'student_father_name' => htmlspecialchars($req['father_name']),
                'student_father_occupation' => htmlspecialchars($req['father_occupation']),
                'student_mother_name' => htmlspecialchars($req['mother_name']),
                'student_mother_occupation' => htmlspecialchars($req['mother_occupation']),
                'student_parent_phone' => htmlspecialchars($req['parent_phone']),
                'student_parent_address' => htmlspecialchars($req['parent_address']),
                'student_parent_postal_code' => htmlspecialchars($req['guardian_postal_code']),
                'student_guardian_name' => htmlspecialchars($req['guardian_name']),
                'student_guardian_occupation' => htmlspecialchars($req['guardian_occupation']),
                'student_guardian_phone' => htmlspecialchars($req['guardian_phone']),
                'student_guardian_address' => htmlspecialchars($req['guardian_address']),
                'student_guardian_postal_code' => htmlspecialchars($req['guardian_postal_code']),
                'student_status' => 1,
                'student_created_by' => userdata()['user_id'],
            ];
            $instudent = $this->student->save($ins_student);
            if ($instudent === false) {
                throw new \Exception('Insert student failed!');
            }
            
            $ins_student_in_group = [
                'student_in_group_school_id' => userdata()['school_id'],
                'student_in_group_student_group_id' => $req['student_group'],
                'student_in_group_grade' => $req['grade'],
                'student_in_group_student_id' => $this->student->getInsertID(),
                'student_in_group_nisn' => htmlspecialchars($req['nisn']),
                'student_in_group_status' => 1,
                'student_in_group_created_by' => userdata()['user_id'],
            ];
            $this->student_in_group->save($ins_student_in_group);
            $this->user->db->transCommit();

            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Tambah siswa berhasil');
            session()->setFlashdata('hide', 3000);
        } catch (\Exception $e) {
            $this->user->db->transRollback();
            
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Tambah siswa gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/user/student/');
    }

    public function show($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Siswa';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/user/student' => 'Siswa',
            '##' => 'Profil Siswa',
        ];

        $data['data_id'] = $id;
        $data['religion'] = get_list('religion');
        $data['province'] = $this->territory->list_province();
        $data['row'] = $this->student->show($id);
        $data['grade'] = get_list('grade')[school_level()];

        return view("schoolms/student/profile", $data);
    }

    public function edit($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Siswa';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/user/student' => 'Siswa',
            '##' => 'Ubah Siswa',
        ];

        $data['religion'] = get_list('religion');
        $data['province'] = $this->territory->list_province();
        $data['row'] = $this->student->show($id);
        $data['grade'] = get_list('grade')[school_level()];

        return view("schoolms/student/edit", $data);
    }

    public function update()
    {
        $req = $this->request->getVar();

        $old = $this->student->where('student_id', $req['student_id'])->first();
        $nisn_rule = $old['student_nisn'] == $req['nisn'] ? 'required|numeric|min_length[6]' : 'required|numeric|min_length[6]|my_unique[profile.student.nisn]';

        $old_user = $this->user->where('user_id', $old['student_user_id'])->first();
        $email_rule = $old_user['user_email'] == $req['email'] ? 'permit_empty|valid_email' : 'permit_empty|valid_email|my_unique[account.user.email]';

        if (
            !$this->validate([
                "foto" => [
                    'rules' => 'mime_in[foto,image/png,image/jpeg,image/jpg]|max_size[foto,1024]|is_image[foto]',
                    'errors' => [
                        'mime_in' => 'Tipe image harus PNG atau JPEG',
                        'max_size' => 'Ukuran maksimal file 1 Mb',
                        'is_image' => 'File terdeteksi bukan image',
                    ]
                ],
                "nisn" => [
                    'rules' => $nisn_rule,
                    'errors' => [
                        'required' => 'Kolom NISN harus diisi',
                        'numeric' => 'Kolom NISN hanya menerima angka',
                        'is_unique' => 'NISN sudah terdaftar',
                    ]
                ],
                "phone" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'numeric' => 'Kolom no hp hanya menerima angka',
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
                "birth_date" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal lahir harus diisi',
                    ]
                ],
                "birth_place" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tempat lahir harus diisi',
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
                        'is_unique' => 'Alamat email sudah terdaftar'
                    ]
                ],
                "religion" => [
                    'rules' => 'in_list[1,2,3,4,5,6]',
                    'errors' => [
                        'in_list' => 'Kolom agama harus dipilih',
                    ]
                ],
                "postal_code" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'alpha' => 'Kolom kode pos hanya menerima angka saja'
                    ]
                ],
                "order_child" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'numeric' => 'Kolom anak ke hanya menerima angka',
                    ]
                ],
                "father_name" => [
                    'rules' => 'permit_empty|alpha_space',
                    'errors' => [
                        'alpha_space' => 'Kolom nama ayah hanya menerima huruf saja'
                    ]
                ],
                "mother_name" => [
                    'rules' => 'permit_empty|alpha_space',
                    'errors' => [
                        'alpha_space' => 'Kolom nama ibu hanya menerima huruf saja'
                    ]
                ],
                "parent_phone" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'alpha' => 'Kolom no. hp orang tua hanya menerima angka saja'
                    ]
                ],
                "parent_postal_code" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'numeric' => 'Kolom kode pos orang tua hanya menerima angka saja'
                    ]
                ],
                "guardian_name" => [
                    'rules' => 'permit_empty|alpha_space',
                    'errors' => [
                        'alpha_space' => 'Kolom wali hanya menerima huruf saja'
                    ]
                ],
                "guardian_phone" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'alpha' => 'Kolom no. hp wali hanya menerima angka saja'
                    ]
                ],
                "guardian_postal_code" => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'numeric' => 'Kolom kode pos wali hanya menerima angka saja'
                    ]
                ],
                "grade" => [
                    'rules' => 'in_list[1,2,3,4,5,6,7,8,9,10,11,12]',
                    'errors' => [
                        'in_list' => 'Kolom kelas harus dipilih',
                    ]
                ],
                "student_group" => [
                    'rules' => 'not_in_list[0]',
                    'errors' => [
                        'not_in_list' => 'Kolom rombongan belajar harus dipilih',
                    ]
                ],
                "registered_date" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal diterima harus dipilih',
                    ]
                ],
                "transfer" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom terdaftar sebagai harus dipilih',
                    ]
                ],
                "previous_school" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom sekolah sebelumnya harus diisi',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $img_foto = $this->request->getFile('foto');
        if ($img_foto->getError() == 4) {
            $foto_name = $req['old_foto'];
        } else {
            $foto_name = $img_foto->getRandomName();
            $img_foto->move('images/student', $foto_name);

            if ($req['old_foto'] != 'default.png') {
                if (file_exists('images/student/' . $req['old_foto'])) {
                    unlink('images/student/' . $req['old_foto']);
                }
            }
        }

        $this->user
            ->where('user_id', $old_user['user_id'])
            ->set('user_email', htmlspecialchars($req['email']))
            ->set('user_email_verified', 0)
            ->set('user_updated_by', userdata()['user_id'])
            ->update();
            
        $this->student_in_group
            ->where('student_in_group_student_id', $req['student_id'])
            ->set('student_in_group_grade', $req['grade'])
            ->set('student_in_group_student_group_id', $req['student_group'])
            ->set('student_in_group_updated_by', userdata()['user_id'])
            ->update();

        $student = [
            'student_nisn' => htmlspecialchars($req['nisn']),
            'student_first_name' => htmlspecialchars($req['first_name']),
            'student_last_name' => htmlspecialchars($req['last_name']),
            'student_birth_place' => htmlspecialchars($req['birth_place']),
            'student_birth_date' => $req['birth_date'],
            'student_child_order_in_family' => htmlspecialchars($req['order_child']),
            'student_gender' => htmlspecialchars($req['gender']),
            'student_religion' => htmlspecialchars($req['religion']),
            'student_phone' => htmlspecialchars($req['phone']),
            'student_province' => htmlspecialchars($req['province']),
            'student_regency' => htmlspecialchars($req['regency']),
            'student_subdistrict' => htmlspecialchars($req['subdistrict']),
            'student_postal_code' => htmlspecialchars($req['postal_code']),
            'student_address' => htmlspecialchars($req['address']),
            'student_image' => $foto_name,
            'student_is_transfer' => isset($req['transfer']) ? $req['transfer'] : 0,
            'student_registered_date' => $req['registered_date'],
            'student_registered_information' => htmlspecialchars($req['registered_information']),
            'student_previous_school' => htmlspecialchars($req['previous_school']),
            'student_father_name' => htmlspecialchars($req['father_name']),
            'student_father_occupation' => htmlspecialchars($req['father_occupation']),
            'student_mother_name' => htmlspecialchars($req['mother_name']),
            'student_mother_occupation' => htmlspecialchars($req['mother_occupation']),
            'student_parent_phone' => htmlspecialchars($req['parent_phone']),
            'student_parent_address' => htmlspecialchars($req['parent_address']),
            'student_parent_postal_code' => htmlspecialchars($req['guardian_postal_code']),
            'student_guardian_name' => htmlspecialchars($req['guardian_name']),
            'student_guardian_occupation' => htmlspecialchars($req['guardian_occupation']),
            'student_guardian_phone' => htmlspecialchars($req['guardian_phone']),
            'student_guardian_address' => htmlspecialchars($req['guardian_address']),
            'student_guardian_postal_code' => htmlspecialchars($req['guardian_postal_code']),
            'student_updated_by' => userdata()['user_id'],
        ];

        $update = $this->student
        ->where("student_id", $req["student_id"])
        ->set($student)
        ->update();

        if ($update) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Ubah siswa berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Ubah siswa gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/user/student/');
    }

    public function destroy()
    {
        $id = $this->request->getVar()['id'];
        $user_id = $this->student->where('student_id', $id)->first()['student_user_id'];

        $delete = $this->student
            ->where('student_id', $id)
            ->set('student_status', 9)
            ->set("student_updated_by", userdata()['user_id'])
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
        $this->student
            ->where("student_id", $req['id'])
            ->set("student_status", $nsts)
            ->set("student_updated_by", userdata()['user_id'])
            ->update();

        echo json_encode(['msg' => $msg, 'sts' => true]);
    }
    
    public function view_credential()
    {
        $id = $this->request->getVar('id');
        $row = $this->user->where('user_id', student_user_id($id))->first();
        $password = 's-' . random_char(8);
        
        $reset = $this->user
            ->where('user_id', $row['user_id'])
            ->set('user_password', $password)
            ->set("student_updated_by", userdata()['user_id'])
            ->update();

        $user = $this->student->where('student_id', $id)->first();
        $res = [
            'status' => $reset,
            'user' => $user['student_first_name'].' '.$user['student_last_name'],
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

        $sheet->setCellValue('A1', "Import Data Siswa");
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
        $sheet->setCellValue('B5', "NISN");
        $sheet->setCellValue('C5', "NAMA DEPAN");
        $sheet->setCellValue('D5', "NAMA BELAKANG");
        $sheet->setCellValue('E5', "TEMPAT LAHIR");
        $sheet->setCellValue('F5', "TANGGAL LAHIR");
        $sheet->setCellValue('G5', "JENIS KELAMIN");
        $sheet->setCellValue('H5', "AGAMA");
        $sheet->setCellValue('I5', "NO. TELP/HP");
        $sheet->setCellValue('J5', "EMAIL");
        $sheet->setCellValue('K5', "PROVINSI");
        $sheet->setCellValue('L5', "KABUPATEN/KOTA");
        $sheet->setCellValue('M5', "KECAMATAN");
        $sheet->setCellValue('N5', "ALAMAT");
        $sheet->setCellValue('O5', "KODE POS");
        $sheet->setCellValue('P5', "TERDAFTAR SEBAGAI");
        $sheet->setCellValue('Q5', "TERDAFTAR PADA JENJANG KELAS");
        $sheet->setCellValue('R5', "NAMA JENJANG KELAS");
        $sheet->setCellValue('S5', "TANGGAL DITERIMA");
        $sheet->setCellValue('T5', "MULAI JENJANG KELAS");
        $sheet->setCellValue('U5', "SEKOLAH SEBELUMNYA");
        $sheet->setCellValue('V5', "INFORMASI PENDAFTARAN");
        $sheet->setCellValue('W5', "ANAK KE");
        $sheet->setCellValue('X5', "NAMA AYAH");
        $sheet->setCellValue('Y5', "PEKERJAAN AYAH");
        $sheet->setCellValue('Z5', "NAMA IBU");
        $sheet->setCellValue('AA5', "PEKERJAAN IBU");
        $sheet->setCellValue('AB5', "NO. TELP/HP ORANG TUA");
        $sheet->setCellValue('AC5', "ALAMAT ORANG TUA");
        $sheet->setCellValue('AD5', "KODE POS ORANG TUA");
        $sheet->setCellValue('AE5', "NAMA WALI");
        $sheet->setCellValue('AF5', "PEKERJAAN WALI");
        $sheet->setCellValue('AG5', "NO. TELP/HP WALI");
        $sheet->setCellValue('AH5', "ALAMAT WALI");
        $sheet->setCellValue('AI5', "KODE POS WALI");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header

        $sheet->getStyle('A5:AI5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('478C3B');

        $sheet->getStyle('B5:H5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('fc0303');

        $sheet->getStyle('P5:U5')->getFill()
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
        $sheet->getStyle('T5')->applyFromArray($style_col);
        $sheet->getStyle('U5')->applyFromArray($style_col);
        $sheet->getStyle('V5')->applyFromArray($style_col);
        $sheet->getStyle('W5')->applyFromArray($style_col);
        $sheet->getStyle('X5')->applyFromArray($style_col);
        $sheet->getStyle('Y5')->applyFromArray($style_col);
        $sheet->getStyle('Z5')->applyFromArray($style_col);
        $sheet->getStyle('AA5')->applyFromArray($style_col);
        $sheet->getStyle('AB5')->applyFromArray($style_col);
        $sheet->getStyle('AC5')->applyFromArray($style_col);
        $sheet->getStyle('AD5')->applyFromArray($style_col);
        $sheet->getStyle('AE5')->applyFromArray($style_col);
        $sheet->getStyle('AF5')->applyFromArray($style_col);
        $sheet->getStyle('AG5')->applyFromArray($style_col);
        $sheet->getStyle('AH5')->applyFromArray($style_col);
        $sheet->getStyle('AI5')->applyFromArray($style_col);

        $no = 1;
        $numrow = 6;

        $options = [1 => 'Laki-laki', 2 => 'Perempuan'];
        $religion = get_list('religion');
        $registered_as = [1=> 'Siswa Baru', 2=>'Siswa Pindahan'];
        $grade = get_list('grade')[school_level()];
        $student_group = $this->student_group->group_name();

        // start data
        $sheet->setCellValue('A' . $numrow, $no);
        $sheet->setCellValue('B' . $numrow, '1111111111');
        $sheet->setCellValue('C' . $numrow, 'Abe');
        $sheet->setCellValue('D' . $numrow, 'Rasyid');
        $sheet->setCellValue('E' . $numrow, 'Binjai');
        $sheet->setCellValue('F' . $numrow, '1993-12-17');
        $sheet->setCellValue('G' . $numrow, 'Laki-laki');
        $sheet->setCellValue('H' . $numrow, 'Islam');
        $sheet->setCellValue('I' . $numrow, '081200001111');
        $sheet->setCellValue('J' . $numrow, 'private.mail@gmail.com');
        $sheet->setCellValue('K' . $numrow, 'SUMATERA UTARA');
        $sheet->setCellValue('L' . $numrow, 'KOTA BINJAI');
        $sheet->setCellValue('M' . $numrow, 'Binjai Selatan');
        $sheet->setCellValue('N' . $numrow, 'Jl. Protokol No. 12 Kel. Setempat');
        $sheet->setCellValue('O' . $numrow, '20276');
        $sheet->setCellValue('P' . $numrow, 'Siswa Baru');
        $sheet->setCellValue('Q' . $numrow, 'X');
        $sheet->setCellValue('R' . $numrow, 'X RPL 1');
        $sheet->setCellValue('S' . $numrow, '2024-01-02');
        $sheet->setCellValue('T' . $numrow, 'X');
        $sheet->setCellValue('U' . $numrow, 'SMP Negeri 1 Binjai');
        $sheet->setCellValue('V' . $numrow, 'Informasi tambahan');
        $sheet->setCellValue('W' . $numrow, 3);
        $sheet->setCellValue('X' . $numrow, 'Minato');
        $sheet->setCellValue('Y' . $numrow, 'Kepala Desa');
        $sheet->setCellValue('Z' . $numrow, 'Kusina');
        $sheet->setCellValue('AA' . $numrow, 'Ibu Rumah Tangga');
        $sheet->setCellValue('AB' . $numrow, '081333332222');
        $sheet->setCellValue('AC' . $numrow, 'Jl. Protokol No. 12 Kel. Setempat, Kec. Binjai Timur, Kota Binjai, Sumatra Utara');
        $sheet->setCellValue('AD' . $numrow, '20432');
        $sheet->setCellValue('AE' . $numrow, 'Iruka');
        $sheet->setCellValue('AF' . $numrow, 'Guru SD');
        $sheet->setCellValue('AG' . $numrow, '089012344321');
        $sheet->setCellValue('AH' . $numrow, 'Jl. Kebagusan No. 22 Kel. Setempat, Kec. Binjai Barat, Kota Binjai, Sumatra Utara');
        $sheet->setCellValue('AI' . $numrow, '20765');

        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $sheet->getStyle('A' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('B' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode('#');
        $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('E' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('F' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('G' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('H' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('I' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('J' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('K' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('L' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('M' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('N' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('O' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('P' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('Q' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('R' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('S' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('T' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('U' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('V' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('W' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('X' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('Y' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('Z' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('AA' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('AB' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('AC' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('AD' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('AE' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('AF' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('AG' . $numrow)->applyFromArray($style_row_center);
        $sheet->getStyle('AH' . $numrow)->applyFromArray($style_row);
        $sheet->getStyle('AI' . $numrow)->applyFromArray($style_row_center);

        for ($i=$numrow; $i <= 1006; $i++) { 
            # drop down list gender
            $genderValidation = $sheet->getCell('G'.$i)->getDataValidation();
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
            $genderValidation->setFormula1('"'.implode(',', $options).'"');
            
            # drop down list religion
            $religionValidation = $sheet->getCell('H'.$i)->getDataValidation();
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
            $religionValidation->setFormula1('"'.implode(',', $religion).'"');
            
            # drop down list is transfer
            $religionValidation = $sheet->getCell('P'.$i)->getDataValidation();
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
            $religionValidation->setFormula1('"'.implode(',', $registered_as).'"');
            
            # drop down list is transfer
            $religionValidation = $sheet->getCell('Q'.$i)->getDataValidation();
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
            $religionValidation->setFormula1('"'.implode(',', $grade).'"');
            
            # drop down list is student group
            $religionValidation = $sheet->getCell('R'.$i)->getDataValidation();
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
            $religionValidation->setFormula1('"'.implode(',', $student_group).'"');
           
            # drop down list is transfer
            $religionValidation = $sheet->getCell('T'.$i)->getDataValidation();
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
            $religionValidation->setFormula1('"'.implode(',', $grade).'"');
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
        $sheet->getColumnDimension('T')->setAutoSize(true);
        $sheet->getColumnDimension('U')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);
        $sheet->getColumnDimension('W')->setAutoSize(true);
        $sheet->getColumnDimension('X')->setAutoSize(true);
        $sheet->getColumnDimension('Y')->setAutoSize(true);
        $sheet->getColumnDimension('Z')->setAutoSize(true);
        $sheet->getColumnDimension('AA')->setAutoSize(true);
        $sheet->getColumnDimension('AB')->setAutoSize(true);
        $sheet->getColumnDimension('AC')->setAutoSize(true);
        $sheet->getColumnDimension('AD')->setAutoSize(true);
        $sheet->getColumnDimension('AE')->setAutoSize(true);
        $sheet->getColumnDimension('AF')->setAutoSize(true);
        $sheet->getColumnDimension('AG')->setAutoSize(true);
        $sheet->getColumnDimension('AH')->setAutoSize(true);
        $sheet->getColumnDimension('AI')->setAutoSize(true);

        $sheet->getStyle('A7:B'.$numrow-1)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('478C3B');

        // # protection cell
        $sheet->getProtection()->setSheet(true);
        $sheet->getStyle('A6:AI1006')->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Import Siswa ");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="E-SchoolMS - Template Import Siswa.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    
    public function export()
    {
        # get all data
        $rows = $this->student->get_all();
        
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->freezePane('A8');
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

        // # lOGO SEKOLAH
        // $drawing->setName('Image');
        // $drawing->setDescription('Image');
        // $drawing->setPath('images/school/'. userdata()['image']);
        // $drawing->setCoordinates('A1');
        // // $drawing->setHeight(80);
        // $drawing->setWidth(130);
        // $drawing->setWorksheet($sheet);

        $sheet->setCellValue('A1', "Data Guru/Tendik");
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
        $sheet->setCellValue('B7', "NISN");
        $sheet->setCellValue('C7', "NAMA DEPAN");
        $sheet->setCellValue('D7', "NAMA BELAKANG");
        $sheet->setCellValue('E7', "TEMPAT LAHIR");
        $sheet->setCellValue('F7', "TANGGAL LAHIR");
        $sheet->setCellValue('G7', "JENIS KELAMIN");
        $sheet->setCellValue('H7', "AGAMA");
        $sheet->setCellValue('I7', "NO. TELP/HP");
        $sheet->setCellValue('J7', "EMAIL");
        $sheet->setCellValue('K7', "PROVINSI");
        $sheet->setCellValue('L7', "KABUPATEN/KOTA");
        $sheet->setCellValue('M7', "KECAMATAN");
        $sheet->setCellValue('N7', "ALAMAT");
        $sheet->setCellValue('O7', "KODE POS");
        $sheet->setCellValue('P7', "TERDAFTAR SEBAGAI");
        $sheet->setCellValue('Q7', "TERDAFTAR PADA JENJANG KELAS");
        $sheet->setCellValue('R7', "NAMA JENJANG KELAS");
        $sheet->setCellValue('S7', "TANGGAL DITERIMA");
        $sheet->setCellValue('T7', "MULAI JENJANG KELAS");
        $sheet->setCellValue('U7', "SEKOLAH SEBELUMNYA");
        $sheet->setCellValue('V7', "INFORMASI PENDAFTARAN");
        $sheet->setCellValue('W7', "ANAK KE");
        $sheet->setCellValue('X7', "NAMA AYAH");
        $sheet->setCellValue('Y7', "PEKERJAAN AYAH");
        $sheet->setCellValue('Z7', "NAMA IBU");
        $sheet->setCellValue('AA7', "PEKERJAAN IBU");
        $sheet->setCellValue('AB7', "NO. TELP/HP ORANG TUA");
        $sheet->setCellValue('AC7', "ALAMAT ORANG TUA");
        $sheet->setCellValue('AD7', "KODE POS ORANG TUA");
        $sheet->setCellValue('AE7', "NAMA WALI");
        $sheet->setCellValue('AF7', "PEKERJAAN WALI");
        $sheet->setCellValue('AG7', "NO. TELP/HP WALI");
        $sheet->setCellValue('AH7', "ALAMAT WALI");
        $sheet->setCellValue('AI7', "KODE POS WALI");
        $sheet->setCellValue('AJ7', "FOTO");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header

        $sheet->getStyle('A7:AJ7')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('478C3B');

        $sheet->getStyle('C7:H7')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('fc0303');

        $sheet->getStyle('P7:S7')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('fc0303');

        $sheet->getStyle('U7')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('fc0303');

        $sheet->getStyle('A7')->applyFromArray($style_col);
        $sheet->getStyle('B7')->applyFromArray($style_col);
        $sheet->getStyle('C7')->applyFromArray($style_col);
        $sheet->getStyle('D7')->applyFromArray($style_col);
        $sheet->getStyle('E7')->applyFromArray($style_col);
        $sheet->getStyle('F7')->applyFromArray($style_col);
        $sheet->getStyle('G7')->applyFromArray($style_col);
        $sheet->getStyle('H7')->applyFromArray($style_col);
        $sheet->getStyle('I7')->applyFromArray($style_col);
        $sheet->getStyle('J7')->applyFromArray($style_col);
        $sheet->getStyle('K7')->applyFromArray($style_col);
        $sheet->getStyle('L7')->applyFromArray($style_col);
        $sheet->getStyle('M7')->applyFromArray($style_col);
        $sheet->getStyle('N7')->applyFromArray($style_col);
        $sheet->getStyle('O7')->applyFromArray($style_col);
        $sheet->getStyle('P7')->applyFromArray($style_col);
        $sheet->getStyle('Q7')->applyFromArray($style_col);
        $sheet->getStyle('R7')->applyFromArray($style_col);
        $sheet->getStyle('S7')->applyFromArray($style_col);
        $sheet->getStyle('T7')->applyFromArray($style_col);
        $sheet->getStyle('U7')->applyFromArray($style_col);
        $sheet->getStyle('V7')->applyFromArray($style_col);
        $sheet->getStyle('W7')->applyFromArray($style_col);
        $sheet->getStyle('X7')->applyFromArray($style_col);
        $sheet->getStyle('Y7')->applyFromArray($style_col);
        $sheet->getStyle('Z7')->applyFromArray($style_col);
        $sheet->getStyle('AA7')->applyFromArray($style_col);
        $sheet->getStyle('AB7')->applyFromArray($style_col);
        $sheet->getStyle('AC7')->applyFromArray($style_col);
        $sheet->getStyle('AD7')->applyFromArray($style_col);
        $sheet->getStyle('AE7')->applyFromArray($style_col);
        $sheet->getStyle('AF7')->applyFromArray($style_col);
        $sheet->getStyle('AG7')->applyFromArray($style_col);
        $sheet->getStyle('AH7')->applyFromArray($style_col);
        $sheet->getStyle('AI7')->applyFromArray($style_col);
        $sheet->getStyle('AJ7')->applyFromArray($style_col);

        $no = 1;
        $numrow = 8;

        $options = [1 => 'Laki-laki', 2 => 'Perempuan'];
        $religion = get_list('religion');
        $registered_as = [1=> 'Siswa Baru', 2=>'Siswa Pindahan'];
        $grade = get_list('grade')[school_level()];
        $student_group = $this->student_group->group_name();

        foreach ($rows as $data) {

        // start data
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data->student_nisn);
            $sheet->setCellValue('C' . $numrow, $data->student_first_name);
            $sheet->setCellValue('D' . $numrow, $data->student_last_name);
            $sheet->setCellValue('E' . $numrow, $data->student_birth_place);
            $sheet->setCellValue('F' . $numrow, $data->student_birth_date);
            $sheet->setCellValue('G' . $numrow, $options[$data->student_gender]);
            $sheet->setCellValue('H' . $numrow, $religion[$data->student_religion]);
            $sheet->setCellValue('I' . $numrow, $data->student_phone);
            $sheet->setCellValue('J' . $numrow, $data->user_email);
            $sheet->setCellValue('K' . $numrow, $data->student_province != '' ? territory_name($data->student_province) : '');
            $sheet->setCellValue('L' . $numrow, $data->student_regency != 0 ? territory_name($data->student_regency) : '');
            $sheet->setCellValue('M' . $numrow, $data->student_subdistrict != 0 ? territory_name($data->student_subdistrict) : '');
            $sheet->setCellValue('N' . $numrow, $data->student_address);
            $sheet->setCellValue('O' . $numrow, $data->student_postal_code != 0 ? $data->student_postal_code : '');
            $sheet->setCellValue('P' . $numrow, $data->student_is_transfer > 0 ? $registered_as[$data->student_is_transfer] : '');
            $sheet->setCellValue('Q' . $numrow, $grade[$data->grade]);
            $sheet->setCellValue('R' . $numrow, $data->student_group_name);
            $sheet->setCellValue('S' . $numrow, $data->student_registered_date != '0000-00-00' ? $data->student_registered_date : '');
            $sheet->setCellValue('T' . $numrow, $data->student_grade_start != null ? $grade[$data->student_grade_start] : '');
            $sheet->setCellValue('U' . $numrow, $data->student_previous_school);
            $sheet->setCellValue('V' . $numrow, $data->student_registered_information);
            $sheet->setCellValue('W' . $numrow, $data->student_child_order_in_family);
            $sheet->setCellValue('X' . $numrow, $data->student_father_name);
            $sheet->setCellValue('Y' . $numrow, $data->student_father_occupation);
            $sheet->setCellValue('Z' . $numrow, $data->student_mother_name);
            $sheet->setCellValue('AA' . $numrow, $data->student_mother_occupation);
            $sheet->setCellValue('AB' . $numrow, $data->student_parent_phone);
            $sheet->setCellValue('AC' . $numrow, $data->student_parent_address);
            $sheet->setCellValue('AD' . $numrow, $data->student_parent_postal_code != 0 ? $data->student_parent_postal_code : '');
            $sheet->setCellValue('AE' . $numrow, $data->student_guardian_name);
            $sheet->setCellValue('AF' . $numrow, $data->student_guardian_occupation);
            $sheet->setCellValue('AG' . $numrow, $data->student_guardian_phone);
            $sheet->setCellValue('AH' . $numrow, $data->student_guardian_address);
            $sheet->setCellValue('AI' . $numrow, $data->student_guardian_postal_code != 0 ? $data->student_guardian_postal_code : '');
            $sheet->setCellValue('AK' . $numrow, $data->user_id);
            $sheet->setCellValue('AL' . $numrow, $data->student_id);
            $sheet->setCellValue('AM' . $numrow, $data->student_in_group_id);

            // # include image
            // $drawing->setName('Image');
            // $drawing->setDescription('Image');
            // $drawing->setPath('images/student/'. $data->student_image);
            // $drawing->setCoordinates('J'.$numrow);
            // $drawing->setHeight(100);
            // $drawing->setWidth(100);
            // $drawing->setWorksheet($sheet);

            # hyperlink excel
            $imglink = new Hyperlink(base_url('images/student/'.$data->student_image), 'Lihat Foto');
            $sheet->setCellValue('AJ' . $numrow, 'Foto Siswa');
            $sheet->getCell('AJ' . $numrow)->setHyperlink($imglink);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode('#');
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('K' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('L' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('M' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('N' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('O' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('P' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('Q' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('R' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('S' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('T' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('U' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('V' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('W' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('X' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('Y' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('Z' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('AA' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('AB' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('AC' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('AD' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('AE' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('AF' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('AG' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('AH' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('AI' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('AJ' . $numrow)->applyFromArray($style_row_center);
            $sheet->getStyle('AK' . $numrow)->getFont()->getColor()->setRGB('ffffff');
            $sheet->getStyle('AL' . $numrow)->getFont()->getColor()->setRGB('ffffff');
            $sheet->getStyle('AM' . $numrow)->getFont()->getColor()->setRGB('ffffff');

            # drop down list gender
            $genderValidation = $sheet->getCell('G'.$numrow)->getDataValidation();
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
            $genderValidation->setFormula1('"'.implode(',', $options).'"');
            
            # drop down list religion
            $religionValidation = $sheet->getCell('H'.$numrow)->getDataValidation();
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
            $religionValidation->setFormula1('"'.implode(',', $religion).'"');
            
            # drop down list is transfer
            $religionValidation = $sheet->getCell('P'.$numrow)->getDataValidation();
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
            $religionValidation->setFormula1('"'.implode(',', $registered_as).'"');

            # drop down list is student group
            $religionValidation = $sheet->getCell('R'.$numrow)->getDataValidation();
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
            $religionValidation->setFormula1('"'.implode(',', $student_group).'"');
            
            # drop down list is transfer
            $religionValidation = $sheet->getCell('Q'.$numrow)->getDataValidation();
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
            $religionValidation->setFormula1('"'.implode(',', $grade).'"');

            # drop down list is transfer
            $religionValidation = $sheet->getCell('T'.$numrow)->getDataValidation();
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
            $religionValidation->setFormula1('"'.implode(',', $grade).'"');

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
        $sheet->getColumnDimension('U')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);
        $sheet->getColumnDimension('W')->setAutoSize(true);
        $sheet->getColumnDimension('X')->setAutoSize(true);
        $sheet->getColumnDimension('Y')->setAutoSize(true);
        $sheet->getColumnDimension('Z')->setAutoSize(true);
        $sheet->getColumnDimension('AA')->setAutoSize(true);
        $sheet->getColumnDimension('AB')->setAutoSize(true);
        $sheet->getColumnDimension('AC')->setAutoSize(true);
        $sheet->getColumnDimension('AD')->setAutoSize(true);
        $sheet->getColumnDimension('AE')->setAutoSize(true);
        $sheet->getColumnDimension('AF')->setAutoSize(true);
        $sheet->getColumnDimension('AG')->setAutoSize(true);
        $sheet->getColumnDimension('AH')->setAutoSize(true);
        $sheet->getColumnDimension('AI')->setAutoSize(true);
        $sheet->getColumnDimension('AJ')->setAutoSize(true);

        $sheet->getStyle('A7:B'.$numrow-1)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('478C3B');

        // # protection cell
        $sheet->getProtection()->setSheet(true);
        $sheet->getStyle('C8:AI'.$numrow-1)->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("SISWA");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="E-SchoolMS - Siswa.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function import_update()
    {
        $filedata = $_FILES['import']['tmp_name'];

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filedata);
        $spreadsheet = $reader->load($filedata);
		$sheetData = $spreadsheet->getActiveSheet()->toArray();

        $religion = get_list('religion');
        $grade = get_list('grade')[school_level()];
        $student_group = $this->student_group->group_name();
        
        $idx_row = 6;
        $success = 0;
        $failed = 0;

        foreach ($sheetData as $k => $v) {
            if ($k > $idx_row) {
                if ($v[1] != '') {
                    // print_r($v);
                    $this->user->db->transBegin();
                    try {
                        $upd_user = $this->user
                            ->where('user_id', $v[36])
                            ->set('user_email', $v[9])
                            ->update();

                        if($upd_user===false){
                            throw new \Exception('Update account failed!');
                        }
                        
                        $upd_student = $this->student
                            ->where('student_id', $v[37])
                            ->set('student_first_name', htmlspecialchars($v[2]))
                            ->set('student_last_name', htmlspecialchars($v[3]))
                            ->set('student_birth_place', htmlspecialchars($v[4]))
                            ->set('student_birth_date', date("Y-m-d", strtotime(htmlspecialchars($v[5]))))
                            ->set('student_religion', array_search(htmlspecialchars($v[7]),$religion))
                            ->set('student_gender', htmlspecialchars($v[6]) == 'Laki-laki' ? 1 : 2)
                            ->set('student_phone', htmlspecialchars($v[8]))
                            ->set('student_province', $v[10] != '' ? territory_code(htmlspecialchars($v[10])) : '')
                            ->set('student_regency', $v[11] != '' ? territory_code(htmlspecialchars($v[11])) : '')
                            ->set('student_subdistrict', $v[12] != '' ? territory_code(htmlspecialchars($v[12])) : '')
                            ->set('student_address', htmlspecialchars($v[13]))
                            ->set('student_postal_code', htmlspecialchars($v[14]))
                            ->set('student_is_transfer', htmlspecialchars($v[15]) == 'Siswa Baru' ? 1 : 2)
                            ->set('student_registered_date', date("Y-m-d", strtotime(htmlspecialchars($v[18]))))
                            ->set('student_grade_start', htmlspecialchars($v[19]))
                            ->set('student_registered_information', htmlspecialchars($v[21]))
                            ->set('student_previous_school', htmlspecialchars($v[20]))
                            ->set('student_child_order_in_family', htmlspecialchars($v[22]))
                            ->set('student_father_name', htmlspecialchars($v[23]))
                            ->set('student_father_occupation', htmlspecialchars($v[24]))
                            ->set('student_mother_name', htmlspecialchars($v[25]))
                            ->set('student_mother_occupation', htmlspecialchars($v[26]))
                            ->set('student_parent_phone', htmlspecialchars($v[27]))
                            ->set('student_parent_address', htmlspecialchars($v[28]))
                            ->set('student_parent_postal_code', htmlspecialchars($v[29]))
                            ->set('student_guardian_name', htmlspecialchars($v[30]))
                            ->set('student_guardian_occupation', htmlspecialchars($v[31]))
                            ->set('student_guardian_phone', htmlspecialchars($v[32]))
                            ->set('student_guardian_address', htmlspecialchars($v[33]))
                            ->set('student_guardian_postal_code', htmlspecialchars($v[34]))
                            ->update();
                        
                        if($upd_student===false){
                            throw new \Exception('Update student failed!');
                        }

                        $this->student_in_group
                            ->where('student_in_group_id', $v[38])
                            ->set('student_in_group_student_group_id', array_search(htmlspecialchars($v[17]),$student_group))
                            ->set('student_in_group_grade', array_search(htmlspecialchars($v[16]),$grade))
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
        // die;

        session()->setFlashdata('head', 'Informasi!');
        session()->setFlashdata('icon', 'info');
        session()->setFlashdata('msg', $success .' data berhasil di ubah,'. $failed . ' data gagal di ubah.');
        session()->setFlashdata('hide', 3000);

        return redirect()->to('/sms/user/student/');
    }

    public function import_insert()
    {
        $filedata = $_FILES['import']['tmp_name'];

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filedata);
        $spreadsheet = $reader->load($filedata);
		$sheetData = $spreadsheet->getActiveSheet()->toArray();

        $religion = get_list('religion');
        $grade = get_list('grade')[school_level()];
        $student_group = $this->student_group->group_name();

        $idx_row = 4;
        $success = 0;
        $failed = 0;

        foreach ($sheetData as $k => $v) {
            if ($k > $idx_row) {
                if ($v[1] != '') {
                    $this->user->db->transBegin();
                    try {
                        $fn = explode(' ', htmlspecialchars($v[2]));
                        $password = 's-' . random_char(8);
                        
                        do {
                            $username = 's' . rand(1000, 9999) . '.' . strtolower(end($fn)) . '@' . school_alias();
                        } while (username_exists($username) > 0);
    
                        $acount_user = [
                            'user_email' => $v[9],
                            'user_name' => $username,
                            'user_password' => $password,
                            'user_role_id' => 12,
                            'user_status' => 1,
                            'user_trial' => 0,
                        ];
                        $ins_user = $this->user->insert($acount_user);
                        if($ins_user===false){
                            throw new \Exception('Insert account failed!');
                        }
                        
                        $student = [
                            'student_user_id' => $this->user->getInsertID(),
                            'student_school_id' => userdata()['id_profile'],
                            'student_nisn' => htmlspecialchars($v[1]),
                            'student_first_name' => htmlspecialchars($v[2]),
                            'student_last_name' => htmlspecialchars($v[3]),
                            'student_birth_place' => htmlspecialchars($v[4]),
                            'student_birth_date' => date("Y-m-d", strtotime(htmlspecialchars($v[5]))),
                            'student_religion' => array_search(htmlspecialchars($v[7]),$religion),
                            'student_gender' => htmlspecialchars($v[6]) == 'Laki-laki' ? 1 : 2,
                            'student_image' => 'default.png',
                            'student_phone' => htmlspecialchars($v[8]),
                            'student_province' => $v[10] != '' ? territory_code(htmlspecialchars($v[10])) : '',
                            'student_regency' => $v[11] != '' ? territory_code(htmlspecialchars($v[11])) : '',
                            'student_subdistrict' => $v[12] != '' ? territory_code(htmlspecialchars($v[12])) : '',
                            'student_address' => htmlspecialchars($v[13]),
                            'student_postal_code' => htmlspecialchars($v[14]),
                            'student_is_transfer' => htmlspecialchars($v[15]) == 'Siswa Baru' ? 1 : 2,
                            'student_registered_date' => date("Y-m-d", strtotime(htmlspecialchars($v[18]))),
                            'student_grade_start' => htmlspecialchars($v[19]),
                            'student_registered_information' => htmlspecialchars($v[21]),
                            'student_previous_school' => htmlspecialchars($v[20]),
                            'student_child_order_in_family' => htmlspecialchars($v[22]),
                            'student_father_name' => htmlspecialchars($v[23]),
                            'student_father_occupation' => htmlspecialchars($v[24]),
                            'student_mother_name' => htmlspecialchars($v[25]),
                            'student_mother_occupation' => htmlspecialchars($v[26]),
                            'student_parent_phone' => htmlspecialchars($v[27]),
                            'student_parent_address' => htmlspecialchars($v[28]),
                            'student_parent_postal_code' => htmlspecialchars($v[29]),
                            'student_guardian_name' => htmlspecialchars($v[30]),
                            'student_guardian_occupation' => htmlspecialchars($v[31]),
                            'student_guardian_phone' => htmlspecialchars($v[32]),
                            'student_guardian_address' => htmlspecialchars($v[33]),
                            'student_guardian_postal_code' => htmlspecialchars($v[34]),
                            'student_status' => 1, // cek lagi
                        ];
                        $ins_student = $this->student->insert($student);
                        if ($ins_student === false) {
                            throw new \Exception('Insert student failed!');
                        }
    
                        $ins_student_in_group = [
                            'student_in_group_school_id' => userdata()['school_id'],
                            'student_in_group_student_group_id' => array_search(htmlspecialchars($v[17]),$student_group),
                            'student_in_group_grade' => array_search(htmlspecialchars($v[16]),$grade),
                            'student_in_group_student_id' => $this->student->getInsertID(),
                            'student_in_group_nisn' => htmlspecialchars($v[1]),
                            'student_in_group_status' => 1,
                            'student_in_group_created_by' => userdata()['user_id'],
                        ];
                        $this->student_in_group->save($ins_student_in_group);
    
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
        session()->setFlashdata('msg', $success .' data berhasil di import,'. $failed . ' data gagal di import.');
        session()->setFlashdata('hide', 3000);

        return redirect()->to('/sms/user/student/');
    }

}