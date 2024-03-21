<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prueba extends CI_Controller
{

	public $mhs, $user;

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		}
		$this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
		$this->load->helper('my');
		$this->load->model('Master_model', 'master');
		$this->load->model('Banco_preguntas_model', 'banco_preguntas');
		$this->load->model('Prueba_model', 'prueba');
		$this->form_validation->set_error_delimiters('', '');

		$this->user = $this->ion_auth->user()->row();
		$this->mhs 	= $this->prueba->getIdEstudiante($this->user->username);
	}

	public function akses_profesor()
	{
		if (!$this->ion_auth->in_group('Lecturer')) {
			show_error('This page is specifically for lecturers to make an Online Test, <a href="' . base_url('dashboard') . '">Back to main menu</a>', 403, 'Forbidden Access');
		}
	}

	public function akses_estudiante()
	{
		if (!$this->ion_auth->in_group('Student')) {
			show_error('This page is specifically for students taking the exam, <a href="' . base_url('dashboard') . '">Back to main menu</a>', 403, 'Forbidden Access');
		}
	}

	public function output_json($data, $encode = true)
	{
		if ($encode) $data = json_encode($data);
		$this->output->set_content_type('application/json')->set_output($data);
	}

	public function json($id = null)
	{
		$this->akses_profesor();

		$this->output_json($this->prueba->getDataPrueba($id), false);
	}

	public function master()
	{
		$this->akses_profesor();
		$user = $this->ion_auth->user()->row();
		$data = [
			'user' => $user,
			'titulo'	=> 'Exam',
			'subtitulo' => 'Exam Data',
			'profesor' => $this->prueba->getIdProfesor($user->username),
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('prueba/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function add()
	{
		$this->akses_profesor();

		$user = $this->ion_auth->user()->row();

		$data = [
			'user' 		=> $user,
			'titulo'		=> 'Exam',
			'subtitulo'	=> 'Add Exam',
			'curso'	=> $this->banco_preguntas->getCursoProfesor($user->username),
			'profesor'		=> $this->prueba->getIdProfesor($user->username),
		];

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('prueba/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit($id)
	{
		$this->akses_dosen();

		$user = $this->ion_auth->user()->row();

		$data = [
			'user' 		=> $user,
			'judul'		=> 'Exam',
			'subjudul'	=> 'Edit Exam',
			'matkul'	=> $this->soal->getMatkulDosen($user->username),
			'dosen'		=> $this->prueba->getIdDosen($user->username),
			'prueba'		=> $this->prueba->getPruebaById($id),
		];

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('prueba/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function convert_tgl($tgl)
	{
		$this->akses_profesor();
		return date('Y-m-d H:i:s', strtotime($tgl));
	}

	public function validasi()
	{
		$this->akses_profesor();

		$user 	= $this->ion_auth->user()->row();
		$profesor 	= $this->prueba->getIdProfesor($user->username);
		$jml 	= $this->prueba->getCantidadBanco_preguntas($profesor->id_profesor)->jml_banco_preguntas;
		$jml_a 	= $jml + 1; // If you don't understand, please read the user_guide codeigniter about form_validation in the less_than section

		$this->form_validation->set_rules('nombre_prueba', 'Exam Name', 'required|alpha_numeric_spaces|max_length[50]');
		$this->form_validation->set_rules('cantidad_banco_preguntas', 'Number of Questions', "required|integer|less_than[{$jml_a}]|greater_than[0]", ['less_than' => "banco_preguntas tidak cukup, anda hanya punya {$jml} banco_preguntas"]);
		$this->form_validation->set_rules('fecha_inicio', 'Start Date', 'required');
		$this->form_validation->set_rules('fecha_terminacion', 'Completion Date', 'required');
		$this->form_validation->set_rules('tiempo', 'Time', 'required|integer|max_length[4]|greater_than[0]');
		$this->form_validation->set_rules('tipo', 'Random Question', 'required|in_list[Random,Sort]');
	}


	public function file_config()
	{
		$allowed_type     = [
			"image/jpeg", "image/jpg", "image/png", "image/gif",
			"audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav",
			"video/mp4", "application/octet-stream"
		];
		$config['upload_path']      = FCPATH . 'uploads/banco_preguntas/';
		$config['allowed_types']    = 'jpeg|jpg|png|gif|mpeg|mpg|mpeg3|mp3|wav|wave|mp4';
		$config['encrypt_name']     = TRUE;

		return $this->load->library('upload', $config);
	}

	public function save()
	{
		$this->validasi();
		$this->load->helper('string');
		$this->file_config();


		$method 		= $this->input->post('method', true);
		$profesor_id 		= $this->input->post('profesor_id', true);
		$curso_id 		= $this->input->post('curso_id', true);
		$nombre_prueba 	= $this->input->post('nombre_prueba', true);
		$cantidad_banco_preguntas 	= $this->input->post('cantidad_banco_preguntas', true);
		$fecha_inicio 		= $this->convert_tgl($this->input->post('fecha_inicio', 	true));
		$fecha_terminacion	= $this->convert_tgl($this->input->post('fecha_terminacion', true));
		$tiempo			= $this->input->post('tiempo', true);
		$tipo			= $this->input->post('tipo', true);
		$banco_preguntas_text			= $this->input->post('banco_preguntas', true);
		$enlace			= $this->input->post('enlace', true);
		// $file_banco_preguntas			= $this->input->post('file_banco_preguntas', true);
		$token 			= strtoupper(random_string('alpha', 5));

		if ($this->form_validation->run() === FALSE) {
			$data['status'] = false;
			$data['errors'] = [
				'nombre_prueba' 	=> form_error('nombre_prueba'),
				'cantidad_banco_preguntas' 	=> form_error('cantidad_banco_preguntas'),
				'fecha_inicio' 	=> form_error('fecha_inicio'),
				'fecha_terminacion' 	=> form_error('fecha_terminacion'),
				'tiempo' 		=> form_error('tiempo'),
				'tipo' 		=> form_error('tipo'),
				'banco_preguntas' 		=> form_error('banco_preguntas'),
				'enlace' 		=> form_error('enlace'),
			];
		} else {
			// // Subir el archivo
			// if ($this->upload->do_upload('file_banco_preguntas')) {
			// 	$upload_data = $this->upload->data();
			// 	$file_banco_preguntas = $upload_data['file_name']; // Nombre del archivo subido
		
			// 	// Guardar el nombre del archivo en la base de datos
			// 	$input['file_banco_preguntas'] = $file_banco_preguntas;
				
			// 	// Continuar con la inserción en la base de datos
			// 	// ...
			// } else {
			// 	$error = $this->upload->display_errors();
			// 	echo $error;
			// 	echo "Hay un error";
			// 	// Manejar el error de carga de archivo
			// }

			$input = [
				'nombre_prueba' 	=> $nombre_prueba,
				'cantidad_banco_preguntas' 	=> $cantidad_banco_preguntas,
				'fecha_inicio' 	=> $fecha_inicio,
				'tarde' 	=> $fecha_terminacion,
				'tiempo' 		=> $tiempo,
				'tipo' 		=> $tipo,
				'banco_preguntas' 		=> $banco_preguntas_text,
				'enlace' 		=> $enlace,
			];

			

			if ($method === 'add') {
				$input['profesor_id']	= $profesor_id;
				$input['curso_id'] = $curso_id;
				$input['token']		= $token;
				$action = $this->master->create('m_prueba', $input);
			} else if ($method === 'edit') {
				$id_prueba = $this->input->post('id_prueba', true);
				$action = $this->master->update('m_prueba', $input, 'id_prueba', $id_prueba);
			}

			

			$data['status'] = $action ? TRUE : FALSE;

			
		}

		$this->output_json($data);
	}

	public function delete()
	{
		$this->akses_dosen();
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('m_prueba', $chk, 'id_prueba')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

	public function refresh_token($id)
	{
		$this->load->helper('string');
		$data['token'] = strtoupper(random_string('alpha', 5));
		$refresh = $this->master->update('m_prueba', $data, 'id_prueba', $id);
		$data['status'] = $refresh ? TRUE : FALSE;
		$this->output_json($data);
	}

	/**
	 * PARTE estudiante
	 */

	public function list_json()
	{
		$this->akses_estudiante();

		$list = $this->prueba->getListPrueba($this->mhs->id_estudiante, $this->mhs->kelas_id);
		$this->output_json($list, false);
	}

	public function list()
	{
		$this->akses_estudiante();

		$user = $this->ion_auth->user()->row();

		$data = [
			'user' 		=> $user,
			'titulo'		=> 'Exam',
			'subtitulo'	=> 'List Exam',
			'mhs' 		=> $this->prueba->getIdEstudiante($user->username),
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('prueba/list');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function token($id)
	{
		$this->akses_estudiante();
		$user = $this->ion_auth->user()->row();

		$data = [
			'user' 		=> $user,
			'titulo'		=> 'Exam',
			'subtitulo'	=> 'Token Exam',
			'mhs' 		=> $this->prueba->getIdEstudiante($user->username),
			'prueba'		=> $this->prueba->getPruebaById($id),
			'encrypted_id' => urlencode($this->encryption->encrypt($id))
		];
		$this->load->view('_templates/topnav/_header.php', $data);
		$this->load->view('prueba/token');
		$this->load->view('_templates/topnav/_footer.php');
	}

	public function cektoken()
	{
		$id = $this->input->post('id_prueba', true);
		$token = $this->input->post('token', true);
		$cek = $this->prueba->getPruebaById($id);

		$data['status'] = $token === $cek->token ? TRUE : FALSE;
		$this->output_json($data);
	}

	public function encrypt()
	{
		$id = $this->input->post('id', true);
		$key = urlencode($this->encryption->encrypt($id));
		// $decrypted = $this->encryption->decrypt(rawurldecode($key));
		$this->output_json(['key' => $key]);
	}

	public function index()
	{
		$this->akses_mahasiswa();
		$key = $this->input->get('key', true);
		$id  = $this->encryption->decrypt(rawurldecode($key));

		$ujian 		= $this->prueba->getUjianById($id);
		$soal 		= $this->prueba->getSoal($id);

		$mhs		= $this->mhs;
		$h_ujian 	= $this->prueba->HslUjian($id, $mhs->id_mahasiswa);

		$cek_sudah_ikut = $h_ujian->num_rows();

		if ($cek_sudah_ikut < 1) {
			$soal_urut_ok 	= array();
			$i = 0;
			foreach ($soal as $s) {
				$soal_per = new stdClass();
				$soal_per->id_soal 		= $s->id_soal;
				$soal_per->soal 		= $s->soal;
				$soal_per->file 		= $s->file;
				$soal_per->tipe_file 	= $s->tipe_file;
				$soal_per->opsi_a 		= $s->opsi_a;
				$soal_per->opsi_b 		= $s->opsi_b;
				$soal_per->opsi_c 		= $s->opsi_c;
				$soal_per->opsi_d 		= $s->opsi_d;
				$soal_per->opsi_e 		= $s->opsi_e;
				$soal_per->jawaban 		= $s->jawaban;
				$soal_urut_ok[$i] 		= $soal_per;
				$i++;
			}
			$soal_urut_ok 	= $soal_urut_ok;
			$list_id_soal	= "";
			$list_jw_soal 	= "";
			if (!empty($soal)) {
				foreach ($soal as $d) {
					$list_id_soal .= $d->id_soal . ",";
					$list_jw_soal .= $d->id_soal . "::N,";
				}
			}
			$list_id_soal 	= substr($list_id_soal, 0, -1);
			$list_jw_soal 	= substr($list_jw_soal, 0, -1);
			$waktu_selesai 	= date('Y-m-d H:i:s', strtotime("+{$ujian->waktu} minute"));
			$time_mulai		= date('Y-m-d H:i:s');

			$input = [
				'ujian_id' 		=> $id,
				'mahasiswa_id'	=> $mhs->id_mahasiswa,
				'list_soal'		=> $list_id_soal,
				'list_jawaban' 	=> $list_jw_soal,
				'jml_benar'		=> 0,
				'nilai'			=> 0,
				'nilai_bobot'	=> 0,
				'tgl_mulai'		=> $time_mulai,
				'tgl_selesai'	=> $waktu_selesai,
				'status'		=> 'Y'
			];
			$this->master->create('h_ujian', $input);

			// Setelah insert wajib refresh dulu
			redirect('ujian/?key=' . urlencode($key), 'location', 301);
		}

		$q_soal = $h_ujian->row();

		$urut_soal 		= explode(",", $q_soal->list_jawaban);
		$soal_urut_ok	= array();
		for ($i = 0; $i < sizeof($urut_soal); $i++) {
			$pc_urut_soal	= explode(":", $urut_soal[$i]);
			$pc_urut_soal1 	= empty($pc_urut_soal[1]) ? "''" : "'{$pc_urut_soal[1]}'";
			$ambil_soal 	= $this->prueba->ambilSoal($pc_urut_soal1, $pc_urut_soal[0]);
			$soal_urut_ok[] = $ambil_soal;
		}

		$detail_tes = $q_soal;
		$soal_urut_ok = $soal_urut_ok;

		$pc_list_jawaban = explode(",", $detail_tes->list_jawaban);
		$arr_jawab = array();
		foreach ($pc_list_jawaban as $v) {
			$pc_v 	= explode(":", $v);
			$idx 	= $pc_v[0];
			$val 	= $pc_v[1];
			$rg 	= $pc_v[2];

			$arr_jawab[$idx] = array("j" => $val, "r" => $rg);
		}

		$arr_opsi = array("a", "b", "c", "d", "e");
		$html = '';
		$no = 1;
		if (!empty($soal_urut_ok)) {
			foreach ($soal_urut_ok as $s) {
				$path = 'uploads/bank_soal/';
				$vrg = $arr_jawab[$s->id_soal]["r"] == "" ? "N" : $arr_jawab[$s->id_soal]["r"];
				$html .= '<input type="hidden" name="id_soal_' . $no . '" value="' . $s->id_soal . '">';
				$html .= '<input type="hidden" name="rg_' . $no . '" id="rg_' . $no . '" value="' . $vrg . '">';
				$html .= '<div class="step" id="widget_' . $no . '">';

				$html .= '<div class="text-center"><div class="w-25">' . tampil_media($path . $s->file) . '</div></div>' . $s->soal . '<div class="funkyradio">';
				for ($j = 0; $j < $this->config->item('jml_opsi'); $j++) {
					$opsi 			= "opsi_" . $arr_opsi[$j];
					$file 			= "file_" . $arr_opsi[$j];
					$checked 		= $arr_jawab[$s->id_soal]["j"] == strtoupper($arr_opsi[$j]) ? "checked" : "";
					$pilihan_opsi 	= !empty($s->$opsi) ? $s->$opsi : "";
					$tampil_media_opsi = (is_file(base_url() . $path . $s->$file) || $s->$file != "") ? tampil_media($path . $s->$file) : "";
					$html .= '<div class="funkyradio-success" onclick="return simpan_sementara();">
						<input type="radio" id="opsi_' . strtolower($arr_opsi[$j]) . '_' . $s->id_soal . '" name="opsi_' . $no . '" value="' . strtoupper($arr_opsi[$j]) . '" ' . $checked . '> <label for="opsi_' . strtolower($arr_opsi[$j]) . '_' . $s->id_soal . '"><div class="huruf_opsi">' . $arr_opsi[$j] . '</div> <p>' . $pilihan_opsi . '</p><div class="w-25">' . $tampil_media_opsi . '</div></label></div>';
				}
				$html .= '</div></div>';
				$no++;
			}
		}

		// Enkripsi Id Tes
		$id_tes = $this->encryption->encrypt($detail_tes->id);

		$data = [
			'user' 		=> $this->user,
			'mhs'		=> $this->mhs,
			'judul'		=> 'Exam',
			'subjudul'	=> 'Exam Sheet',
			'soal'		=> $detail_tes,
			'no' 		=> $no,
			'html' 		=> $html,
			'id_tes'	=> $id_tes
		];
		$this->load->view('_templates/topnav/_header.php', $data);
		$this->load->view('ujian/sheet');
		$this->load->view('_templates/topnav/_footer.php');
	}

	public function simpan_satu()
	{
		// Decrypt Id
		$id_tes = $this->input->post('id', true);
		$id_tes = $this->encryption->decrypt($id_tes);

		$input 	= $this->input->post(null, true);
		$list_jawaban 	= "";
		for ($i = 1; $i < $input['jml_soal']; $i++) {
			$_tjawab 	= "opsi_" . $i;
			$_tidsoal 	= "id_soal_" . $i;
			$_ragu 		= "rg_" . $i;
			$jawaban_ 	= empty($input[$_tjawab]) ? "" : $input[$_tjawab];
			$list_jawaban	.= "" . $input[$_tidsoal] . ":" . $jawaban_ . ":" . $input[$_ragu] . ",";
		}
		$list_jawaban	= substr($list_jawaban, 0, -1);
		$d_simpan = [
			'list_jawaban' => $list_jawaban
		];

		// Simpan jawaban
		$this->master->update('h_ujian', $d_simpan, 'id', $id_tes);
		$this->output_json(['status' => true]);
	}

	public function simpan_akhir()
	{
		// Decrypt Id
		$id_tes = $this->input->post('id', true);
		$id_tes = $this->encryption->decrypt($id_tes);

		// Get Jawaban
		$list_jawaban = $this->prueba->getJawaban($id_tes);

		// Pecah Jawaban
		$pc_jawaban = explode(",", $list_jawaban);

		$jumlah_benar 	= 0;
		$jumlah_salah 	= 0;
		$jumlah_ragu  	= 0;
		$nilai_bobot 	= 0;
		$total_bobot	= 0;
		$jumlah_soal	= sizeof($pc_jawaban);

		foreach ($pc_jawaban as $jwb) {
			$pc_dt 		= explode(":", $jwb);
			$id_soal 	= $pc_dt[0];
			$jawaban 	= $pc_dt[1];
			$ragu 		= $pc_dt[2];

			$cek_jwb 	= $this->soal->getSoalById($id_soal);
			$total_bobot = $total_bobot + $cek_jwb->bobot;

			$jawaban == $cek_jwb->jawaban ? $jumlah_benar++ : $jumlah_salah++;
		}

		$nilai = ($jumlah_benar / $jumlah_soal)  * 100;
		$nilai_bobot = ($total_bobot / $jumlah_soal)  * 100;

		$d_update = [
			'jml_benar'		=> $jumlah_benar,
			'nilai'			=> number_format(floor($nilai), 0),
			'nilai_bobot'	=> number_format(floor($nilai_bobot), 0),
			'status'		=> 'N'
		];

		$this->master->update('h_ujian', $d_update, 'id', $id_tes);
		$this->output_json(['status' => TRUE, 'data' => $d_update, 'id' => $id_tes]);
	}
}
