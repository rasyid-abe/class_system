<?php

namespace App\Controllers\SchoolMS\Users;

use App\Controllers\BaseController;
use App\Models\Profiles\SchoolModel;
use App\Models\Authentication\UserModel;
use App\Models\Datas\TerritoryModel;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class School extends BaseController
{
    protected $title;
    protected $school;
    protected $user;
    protected $territory;

    public function __construct()
    {
        $this->title = "User";
        $this->school = new SchoolModel();
        $this->user = new UserModel();
        $this->territory = new TerritoryModel();
    }

    public function index()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Sekolah';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Sekolah',
        ];

        $data['level'] = get_list('school_level');
        $data['school'] = $this->school->list_school();

        return view("schoolms/school/index", $data);
    }

    public function create()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Sekolah';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/user/school' => 'Sekolah',
            '##' => 'Tambah Sekolah',
        ];

        $data['level'] = get_list('school_level');
        $data['province'] = $this->territory->list_province();

        return view("schoolms/school/create", $data);
    }

    public function list_area()
    {
        $data = $this->request->getVar();
        echo json_encode($this->territory->list_area($data));
    }

    public function store()
    {
        $req = $this->request->getVar();

        $ls_prov = $this->territory->arr_id_prov();
        $ls_rege = $this->territory->arr_id_rege(2, $req['province'], 5);
        $ls_dist = $this->territory->arr_id_rege(5, $req['regency'], 8);

        if (
            !$this->validate([
                "npsn" => [
                    'rules' => 'required|min_length[6]|is_unique[profile_school.school_npsn]',
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
                    'rules' => 'required|valid_email|is_unique[account_user.user_email]',
                    'errors' => [
                        'required' => 'Kolom email harus diisi',
                        'valid_email' => 'Alamat email tidak valid',
                        'is_unique' => 'Alamat email sudah terdaftar'
                    ]
                ],
                "phone" => [
                    'rules' => 'required|is_unique[profile_school.school_phone]',
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
                    'rules' => 'required|is_unique[profile_school.school_principal_nip]',
                    'errors' => [
                        'required' => 'Kolom NIP kepala sekolah harus diisi',
                        'is_unique' => 'NIP sudah terdaftar'
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
                        'in_list' => 'Kolom kelurahan harus dipilih',
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
                "ttdhead" => [
                    'rules' => 'mime_in[ttdhead,image/*]|max_size[ttdhead,1024]|uploaded[ttdhead]|is_image[ttdhead]',
                    'errors' => [
                        'mime_in' => 'Tipe gambar harus PNG',
                        'max_size' => 'Ukuran maksimal file 1 Mb',
                        'is_image' => 'File terdeteksi bukan gambar',
                        'uploaded' => 'Gambar tanda tangan harus dipilih',
                    ]
                ],
                "logo" => [
                    'rules' => 'mime_in[logo,image/*]|max_size[logo,1024]|is_image[logo]',
                    'errors' => [
                        'mime_in' => 'Tipe image harus PNG atau JPEG',
                        'max_size' => 'Ukuran maksimal file 1 Mb',
                        'is_image' => 'File terdeteksi bukan image',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $img_ttd = $this->request->getFile('ttdhead');
        $ttd_name = $img_ttd->getRandomName();
        $img_ttd->move('images/school', $ttd_name);


        $img_logo = $this->request->getFile('logo');
        if ($img_logo->getError() == 4) {
            $logo_name = 'default.png';
        } else {
            $logo_name = $img_logo->getRandomName();
            $img_logo->move('images/school', $logo_name);
        }

        $ins_user = [
            'user_name' => htmlspecialchars($req['email']),
            'user_email' => htmlspecialchars($req['email']),
            'user_password' => password_hash($req['alias'] . '-' . substr($req['npsn'], -3), PASSWORD_DEFAULT),
            'user_role_id' => 3,
            'user_status' => 1,
            'user_trial' => 0,
        ];
        $this->user->save($ins_user);

        $ins_school = [
            'school_user_id' => $this->user->getInsertID(),
            'school_npsn' => $req['npsn'],
            'school_name' => htmlspecialchars($req['name']),
            'school_alias' => htmlspecialchars($req['alias']),
            'school_foundation' => htmlspecialchars($req['foundation']),
            'school_level' => htmlspecialchars($req['level']),
            'school_principal' => htmlspecialchars($req['principal']),
            'school_principal_nip' => htmlspecialchars($req['principal_nip']),
            'school_principal_sign' => $ttd_name,
            'school_phone' => htmlspecialchars($req['phone']),
            'school_logo' => $logo_name,
            'school_website' => htmlspecialchars($req['website']),
            'school_map_latitude' => htmlspecialchars($req['map_latitude']),
            'school_map_longitude' => htmlspecialchars($req['map_longitude']),
            'school_address' => htmlspecialchars($req['address']),
            'school_province' => htmlspecialchars($req['province']),
            'school_regency' => htmlspecialchars($req['regency']),
            'school_subdistrict' => htmlspecialchars($req['subdistrict']),
            'school_postal_code' => htmlspecialchars($req['postal_code']),
            'school_status' => 1,
        ];
        $insert = $this->school->save($ins_school);

        if ($insert) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Tambah sekolah berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Tambah sekolah gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/user/school/');
    }

    public function show($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Sekolah';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/user/school' => 'Sekolah',
            '##' => 'Profil Sekolah',
        ];

        $data['level'] = get_list('school_level');
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
            '/sms/user/school' => 'Sekolah',
            '##' => 'Ubah Sekolah',
        ];

        $data['level'] = get_list('school_level');
        $data['province'] = $this->territory->list_province();
        $data['row'] = $this->school->show($id);

        return view("schoolms/school/edit", $data);
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
                        'in_list' => 'Kolom kelurahan harus dipilih',
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
                "ttdhead" => [
                    'rules' => 'mime_in[ttdhead,image/png,image/jpeg,image/jpg]|max_size[ttdhead,1024]|is_image[ttdhead]',
                    'errors' => [
                        'mime_in' => 'Tipe gambar harus PNG',
                        'max_size' => 'Ukuran maksimal file 1 Mb',
                        'is_image' => 'File terdeteksi bukan gambar',
                    ]
                ],
                "logo" => [
                    'rules' => 'mime_in[logo,image/png,image/jpeg,image/jpg]|max_size[logo,1024]|is_image[logo]',
                    'errors' => [
                        'mime_in' => 'Tipe image harus PNG atau JPEG',
                        'max_size' => 'Ukuran maksimal file 1 Mb',
                        'is_image' => 'File terdeteksi bukan image',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
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

        $this->user
            ->where('user_id', $old_user['user_id'])
            ->set('user_email', htmlspecialchars($req['email']))
            ->set('user_email_verified', 0)
            ->update();

        $school = [
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

        return redirect()->to('/sms/user/school/');
    }

    public function destroy($id)
    {
        $user_id = $this->school->where('school_id', $id)->first()['school_user_id'];

        $delete = $this->school
            ->where('school_id', $id)
            ->set('school_status', 9)
            ->update();

        if ($delete) {
            $this->user->where('user_id', $user_id)->set('user_status', 9)->update();

            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Hapus sekolah berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Gagal!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Hapus sekolah gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/user/school/');
    }

    public function status($id, $sts)
    {
        $nsts = $sts == 1 ? 0 : 1;

        $msg = $nsts > 0 ? "aktifkan" : "nonaktifkan";
        $this->school
            ->where("school_id", $id)
            ->set("school_status", $nsts)
            ->update();

        session()->setFlashdata('head', 'Sukses!');
        session()->setFlashdata('icon', 'success');
        session()->setFlashdata("msg", "Berhasil di " . $msg);
        session()->setFlashdata('hide', 3000);

        return redirect()->to('/sms/user/school/');
    }

    public function reset_password()
    {
        $row = $this->school->where('school_id', $this->request->getVar('id'))->first();

        $password = $row['school_alias']. '-' . substr($row['school_npsn'], -3);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $reset = $this->user
            ->where('user_id', $row['school_user_id'])
            ->set('user_password', $password_hash)
            ->update();

        $res = [
            'status' => $reset,
            'new_pass' => $password,
        ];

        echo json_encode($res);
    }

    public function import()
    {
        
        $import = $this->request->getFile('import');
        $filedata = $_FILES['import']['tmp_name'];

		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filedata);
        $spreadsheet = $reader->load($filedata);
		$sheetData = $spreadsheet->getActiveSheet()->toArray();
        $xlsObj = $spreadsheet->getActiveSheet();

        $arrImages = [];
        foreach ($xlsObj->getDrawingCollection() as $key => $drawing) {
            $imagePath = $drawing->getPath();
            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
            $imageName = 'image_' . uniqid() . '.' . $extension;
            $imageCoor = $drawing->getCoordinates2();
            copy($imagePath, 'images/testupload/' . $imageName);
            $arrImages[$imageCoor] = $imageName;
        }

        $myarray = array_map(function($sheetData) use ($arrImages) {
			if (count($sheetData) > 0) {
                if ($sheetData[0] != 'no') {
                    static $ii = 1; $ii++;
                    return array(
                        'no' => $sheetData[0],
                        'soal' => $sheetData[1],
                        'soal_gbr' => array_key_exists("C".$ii,$arrImages) ? $arrImages['C'.$ii] : '',
                        'desk' => $sheetData[3],
                        'jawab_gbr' => array_key_exists("E".$ii,$arrImages) ? $arrImages['E'.$ii] : '',
                        'keys' => $ii,
                    ); 
                }
			}
		}, $sheetData);
        $clearsheet = array_filter($myarray, fn($value) => !is_null($value) && $value !== '');
        
        dd($clearsheet);
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
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
        $sheet->setCellValue('A1', "DATA SEKOLAH");
        $sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "NPSN");
        $sheet->setCellValue('C3', "YAYASAN/DINAS PENDIDIKAN");
        $sheet->setCellValue('D3', "NAMA SEKOLAH");
        $sheet->setCellValue('E3', "JENJANG");
        $sheet->setCellValue('F3', "KEPALA SEKOLAH");
        $sheet->setCellValue('G3', "NIP KEPALA SEKOLAH");
        $sheet->setCellValue('H3', "EMAIL");
        $sheet->setCellValue('I3', "NO. TELP/HP");
        $sheet->setCellValue('J3', "WEBSITE");
        $sheet->setCellValue('K3', "PROVINSI");
        $sheet->setCellValue('L3', "KABUPATEN/KOTA");
        $sheet->setCellValue('M3', "KELURAHAN");
        $sheet->setCellValue('N3', "ALAMAT");
        $sheet->setCellValue('O3', "KODE POS");
        $sheet->setCellValue('P3', "MAP LATITUDE");
        $sheet->setCellValue('Q3', "MAP LONGITUDE");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header

        $sheet->getStyle('A3:Q3')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('343a40');

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        $sheet->getStyle('K3')->applyFromArray($style_col);
        $sheet->getStyle('L3')->applyFromArray($style_col);
        $sheet->getStyle('M3')->applyFromArray($style_col);
        $sheet->getStyle('N3')->applyFromArray($style_col);
        $sheet->getStyle('O3')->applyFromArray($style_col);
        $sheet->getStyle('P3')->applyFromArray($style_col);
        $sheet->getStyle('Q3')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $rows = $this->school->get_all();
        $level = get_list('school_level');

        $no = 1;
        $numrow = 4;

        foreach ($rows as $data) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data->school_npsn);
            $sheet->setCellValue('C' . $numrow, $data->school_foundation);
            $sheet->setCellValue('D' . $numrow, $data->school_name);
            $sheet->setCellValue('E' . $numrow, $level[$data->school_level]);
            $sheet->setCellValue('F' . $numrow, $data->school_principal);
            $sheet->setCellValue('G' . $numrow, $data->school_principal_nip);
            $sheet->setCellValue('H' . $numrow, $data->user_email);
            $sheet->setCellValue('I' . $numrow, $data->school_phone);
            $sheet->setCellValue('J' . $numrow, $data->school_website);
            $sheet->setCellValue('K' . $numrow, territory_name($data->school_province));
            $sheet->setCellValue('L' . $numrow, territory_name($data->school_regency));
            $sheet->setCellValue('M' . $numrow, territory_name($data->school_subdistrict));
            $sheet->setCellValue('N' . $numrow, $data->school_address);
            $sheet->setCellValue('O' . $numrow, $data->school_postal_code);
            $sheet->setCellValue('P' . $numrow, $data->school_map_latitude);
            $sheet->setCellValue('Q' . $numrow, $data->school_map_longitude);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode('#');
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode('#');
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('M' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('N' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('O' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('P' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode('#');
            $sheet->getStyle('Q' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode('#');

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

        $sheet->getStyle('A4:B'.$numrow-1)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('343a40');

        $sheet->getProtection()->setSheet(true);

        $sheet->getStyle('C4:Q'.$numrow-1)->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("DATA SELURUH SEKOLAH");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="E-SchoolMS - Data Sekolah.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}