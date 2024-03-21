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
		$this->akses_profesor();

		$user = $this->ion_auth->user()->row();

		$data = [
			'user' 		=> $user,
			'titulo'		=> 'Exam',
			'subtitulo'	=> 'Edit Exam',
			'curso'	=> $this->banco_preguntas->getCursoProfesor($user->username),
			'profesor'		=> $this->prueba->getIdProfesor($user->username),
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
		$jml 	= $this->prueba->getCantidadBanco_preguntas($profesor->id_profesor)->numero_preguntas;
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
		$this->akses_profesor();
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

		$list = $this->prueba->getListPrueba($this->mhs->id_estudiante, $this->mhs->clase_id);
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
		$this->akses_estudiante();
		$key = $this->input->get('key', true);
		$id  = $this->encryption->decrypt(rawurldecode($key));

		$prueba 		= $this->prueba->getPruebaById($id);
		$banco_preguntas 		= $this->prueba->getBanco_preguntas($id);

		$mhs		= $this->mhs;
		$h_prueba	= $this->prueba->Resultado_examen($id, $mhs->id_estudiante);

		$cek_sudah_ikut = $h_prueba->num_rows();

		if ($cek_sudah_ikut < 1) {
			$banco_preguntas_urut_ok 	= array();
			$i = 0;
			foreach ($banco_preguntas as $s) {
				$banco_preguntas_per = new stdClass();
				$banco_preguntas_per->id_banco_preguntas 		= $s->id_banco_preguntas;
				$banco_preguntas_per->banco_preguntas 		= $s->banco_preguntas;
				$banco_preguntas_per->file 		= $s->file;
				$banco_preguntas_per->tipe_file 	= $s->tipe_file;
				$banco_preguntas_per->opsi_a 		= $s->opsi_a;
				$banco_preguntas_per->opsi_b 		= $s->opsi_b;
				$banco_preguntas_per->opsi_c 		= $s->opsi_c;
				$banco_preguntas_per->opsi_d 		= $s->opsi_d;
				$banco_preguntas_per->opsi_e 		= $s->opsi_e;
				$banco_preguntas_per->respuesta 		= $s->respuesta;
				$banco_preguntas_urut_ok[$i] 		= $banco_preguntas_per;
				$i++;
			}
			$banco_preguntas_urut_ok 	= $banco_preguntas_urut_ok;
			$list_id_banco_preguntas	= "";
			$list_jw_banco_preguntas 	= "";
			if (!empty($banco_preguntas)) {
				foreach ($banco_preguntas as $d) {
					$list_id_banco_preguntas .= $d->id_banco_preguntas . ",";
					$list_jw_banco_preguntas .= $d->id_banco_preguntas . "::N,";
				}
			}
			$list_id_banco_preguntas 	= substr($list_id_banco_preguntas, 0, -1);
			$list_jw_banco_preguntas 	= substr($list_jw_banco_preguntas, 0, -1);
			$tiempo_terminado 	= date('Y-m-d H:i:s', strtotime("+{$prueba->tiempo} minute"));
			$hora_inicio		= date('Y-m-d H:i:s');

			$input = [
				'prueba_id' 		=> $id,
				'estudiante_id'	=> $mhs->id_estudiante,
				'list_banco_preguntas'		=> $list_id_banco_preguntas,
				'list_respuesta' 	=> $list_jw_banco_preguntas,
				'cantidad_verdadera'		=> 0,
				'valor'			=> 0,
				'valor_peso'	=> 0,
				'fecha_inicio'		=> $hora_inicio,
				'fecha_terminacion'	=> $tiempo_terminado,
				'status'		=> 'Y'
			];
			$this->master->create('h_prueba', $input);

			// Setelah insert wajib refresh dulu
			redirect('prueba/?key=' . urlencode($key), 'location', 301);
		}

		$q_banco_preguntas = $h_prueba->row();

		$urut_banco_preguntas 		= explode(",", $q_banco_preguntas->list_respuesta);
		$banco_preguntas_urut_ok	= array();
		for ($i = 0; $i < sizeof($urut_banco_preguntas); $i++) {
			$pc_urut_banco_preguntas	= explode(":", $urut_banco_preguntas[$i]);
			$pc_urut_banco_preguntas1 	= empty($pc_urut_banco_preguntas[1]) ? "''" : "'{$pc_urut_banco_preguntas[1]}'";
			$ambil_banco_preguntas 	= $this->prueba->tomarBanco_preguntas($pc_urut_banco_preguntas1, $pc_urut_banco_preguntas[0]);
			$banco_preguntas_urut_ok[] = $ambil_banco_preguntas;
		}

		$detail_tes = $q_banco_preguntas;
		$banco_preguntas_urut_ok = $banco_preguntas_urut_ok;

		$pc_list_respuesta = explode(",", $detail_tes->list_respuesta);
		$arr_jawab = array();
		foreach ($pc_list_respuesta as $v) {
			$pc_v 	= explode(":", $v);
			$idx 	= $pc_v[0];
			$val 	= $pc_v[1];
			$rg 	= $pc_v[2];

			$arr_jawab[$idx] = array("j" => $val, "r" => $rg);
		}

		$arr_opsi = array("a", "b", "c", "d", "e");
		$html = '';
		$no = 1;
		if (!empty($banco_preguntas_urut_ok)) {
			foreach ($banco_preguntas_urut_ok as $s) {
				$path = 'uploads/banco_preguntas/';
				$vrg = $arr_jawab[$s->id_banco_preguntas]["r"] == "" ? "N" : $arr_jawab[$s->id_banco_preguntas]["r"];
				$html .= '<input type="hidden" name="id_banco_preguntas_' . $no . '" value="' . $s->id_banco_preguntas . '">';
				$html .= '<input type="hidden" name="rg_' . $no . '" id="rg_' . $no . '" value="' . $vrg . '">';
				$html .= '<div class="step" id="widget_' . $no . '">';

				$html .= '<div class="text-center"><div class="w-25">' . tampil_media($path . $s->file) . '</div></div>' . $s->banco_preguntas . '<div class="funkyradio">';
				for ($j = 0; $j < $this->config->item('jml_opsi'); $j++) {
					$opsi 			= "opsi_" . $arr_opsi[$j];
					$file 			= "file_" . $arr_opsi[$j];
					$checked 		= $arr_jawab[$s->id_banco_preguntas]["j"] == strtoupper($arr_opsi[$j]) ? "checked" : "";
					$pilihan_opsi 	= !empty($s->$opsi) ? $s->$opsi : "";
					$tampil_media_opsi = (is_file(base_url() . $path . $s->$file) || $s->$file != "") ? tampil_media($path . $s->$file) : "";
					$html .= '<div class="funkyradio-success" onclick="return simpan_sementara();">
						<input type="radio" id="opsi_' . strtolower($arr_opsi[$j]) . '_' . $s->id_banco_preguntas . '" name="opsi_' . $no . '" value="' . strtoupper($arr_opsi[$j]) . '" ' . $checked . '> <label for="opsi_' . strtolower($arr_opsi[$j]) . '_' . $s->id_banco_preguntas . '"><div class="huruf_opsi">' . $arr_opsi[$j] . '</div> <p>' . $pilihan_opsi . '</p><div class="w-25">' . $tampil_media_opsi . '</div></label></div>';
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
			'titulo'		=> 'Exam',
			'subtitulo'	=> 'Exam Sheet',
			'banco_preguntas'		=> $detail_tes,
			'no' 		=> $no,
			'html' 		=> $html,
			'id_tes'	=> $id_tes
		];
		$this->load->view('_templates/topnav/_header.php', $data);
		$this->load->view('prueba/sheet');
		$this->load->view('_templates/topnav/_footer.php');
	}

	public function simpan_satu()
	{
		// Decrypt Id
		$id_tes = $this->input->post('id', true);
		$id_tes = $this->encryption->decrypt($id_tes);

		$input 	= $this->input->post(null, true);
		$list_respuesta 	= "";
		for ($i = 1; $i < $input['numero_preguntas']; $i++) {
			$_tjawab 	= "opsi_" . $i;
			$_tidbanco_preguntas 	= "id_banco_preguntas_" . $i;
			$_duda 		= "rg_" . $i;
			$respuesta_ 	= empty($input[$_tjawab]) ? "" : $input[$_tjawab];
			$list_respuesta	.= "" . $input[$_tidbanco_preguntas] . ":" . $respuesta_ . ":" . $input[$_duda] . ",";
		}
		$list_respuesta	= substr($list_respuesta, 0, -1);
		$d_simpan = [
			'list_respuesta' => $list_respuesta
		];

		// Simpan respuesta
		$this->master->update('h_prueba', $d_simpan, 'id', $id_tes);
		$this->output_json(['status' => true]);
	}

	public function simpan_akhir()
	{
		// Decrypt Id
		$id_tes = $this->input->post('id', true);
		$id_tes = $this->encryption->decrypt($id_tes);

		// Get respuesta
		$list_respuesta = $this->prueba->getRespuesta($id_tes);

		// Pecah respuesta
		$pc_respuesta = explode(",", $list_respuesta);

		$cantidad_verdadera 	= 0;
		$cantidad_incorrecta 	= 0;
		$cantidad_duda  	= 0;
		$valor_peso	= 0;
		$total_peso	= 0;
		$cantidad_banco_preguntas	= sizeof($pc_respuesta);

		foreach ($pc_respuesta as $jwb) {
			$pc_dt 		= explode(":", $jwb);
			$id_banco_preguntas	= $pc_dt[0];
			$respuesta 	= $pc_dt[1];
			$duda		= $pc_dt[2];

			$cek_jwb 	= $this->banco_preguntas->getBanco_preguntasById($id_banco_preguntas);
			$total_peso = $total_peso + $cek_jwb->peso;

			$respuesta == $cek_jwb->respuesta ? $cantidad_verdadera++ : $cantidad_incorrecta++;
		}

		$valor = ($cantidad_verdadera / $cantidad_banco_preguntas)  * 100;
		$valor_peso= ($total_peso / $cantidad_banco_preguntas)  * 100;

		$d_update = [
			'cantidad_verdadera'		=> $cantidad_verdadera,
			'valor'			=> number_format(floor($valor), 0),
			'valor_peso'	=> number_format(floor($valor_peso), 0),
			'status'		=> 'N'
		];

		$this->master->update('h_prueba', $d_update, 'id', $id_tes);
		$this->output_json(['status' => TRUE, 'data' => $d_update, 'id' => $id_tes]);
	}
}
