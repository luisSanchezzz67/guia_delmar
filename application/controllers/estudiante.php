<?php
defined('BASEPATH') or exit('No se permite el acceso directo al script');

class Estudiante extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		} else if (!$this->ion_auth->is_admin()) {
			show_error('Solo los Administradores están autorizados a acceder a esta página, <a href="' . base_url('dashboard') . '">Volver al menú</a>', 403, 'Acceso Prohibido');
		}
		$this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
		$this->load->model('Master_model', 'master');
		$this->form_validation->set_error_delimiters('', '');
	}

	public function output_json($data, $encode = true)
	{
		if ($encode) $data = json_encode($data);
		$this->output->set_content_type('application/json')->set_output($data);
	}

	public function index()
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'titulo'	=> 'Estudiantes',
			'subtitulo' => 'Datos de Estudiante'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('direccion/estudiante/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->master->getDataEstudiante(), false);
	}

	public function add()
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'titulo'	=> 'Estudiante',
			'subtitulo' => 'Agregar Datos de Estudiante'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('direccion/estudiante/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit($id)
	{
		$mhs = $this->master->getEstudianteById($id);
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'titulo'		=> 'Estudiante',
			'subtitulo'	=> 'Editar Datos de Estudiante',
			'grupo'	=> $this->master->getGrupo(),
			'clase'		=> $this->master->getClaseByGrupo($mhs->grupo_id),
			'estudiante' => $mhs
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('direccion/estudiante/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function validasi_estudiante($method)
	{
		//$this->validasi_profesor($method);
		$id_estudiante 	= $this->input->post('id_estudiante', true);
		$nim 			= $this->input->post('nim', true);
		$email 			= $this->input->post('email', true);
		//$emailProfesor 			= $this->input->post('emailProfesor', true); 
		if ($method == 'add') {
			$u_nim = '|is_unique[estudiante.nim]';
			$u_email = '|is_unique[estudiante.email]';
			$u_emailProfesor = '|is_unique[profesor.email]';
		//	$u_email_profesor = '|is_unique[profesor.email]';
		} else {
			$dbdata 	= $this->master->getEstudianteById($id_estudiante);
			$u_nim		= $dbdata->nim === $nim ? "" : "|is_unique[estudiante.nim]";
			$u_email	= $dbdata->email === $email ? "" : "|is_unique[estudiante.email]";
			//$u_emailProfesor	= $dbdata->emailProfesor === $emailProfesor ? "" : "|is_unique[profesor.email]";
		}
		$this->form_validation->set_rules('nim', 'NIM', 'required|numeric|trim|min_length[8]|max_length[12]' . $u_nim);
		$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim|min_length[3]|max_length[50]');
<<<<<<< HEAD
		$this->form_validation->set_rules('email', 'Correo', 'required|trim|valid_email' . $u_email . $u_emailProfesor); //. $u_email_profesor
		$this->form_validation->set_rules('genero', 'Género', 'required');
		$this->form_validation->set_rules('grupo', 'Grupo', 'required');
=======
		$this->form_validation->set_rules('email', 'Correo', 'required|trim|valid_email' . $u_email);
		$this->form_validation->set_rules('genero', 'Género', 'required');
		$this->form_validation->set_rules('grupo', 'Departamento', 'required');
>>>>>>> 0e5f70f971dcee42c3ff1ec837154ba13602edf4
		$this->form_validation->set_rules('clase', 'Clase', 'required');

		$this->form_validation->set_message('required', 'Kolom {field} wajib diisi');
	}

	public function save()
	{
		$method = $this->input->post('method', true);
		$this->validasi_estudiante($method);

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> false,
				'errors'	=> [
					'nim' => form_error('nim'),
					'nombre' => form_error('nombre'),
					'email' => form_error('email'),
					'genero' => form_error('genero'),
					'grupo' => form_error('grupo'),
					'clase' => form_error('clase'),
				]
			];
			$this->output_json($data);
		} else {
			$input = [
				'nim' 			=> $this->input->post('nim', true),
				'email' 		=> $this->input->post('email', true),
				'nombre' 			=> $this->input->post('nombre', true),
				'genero' => $this->input->post('genero', true),
				'clase_id' 		=> $this->input->post('clase', true),
			];
			if ($method === 'add') {
				$action = $this->master->create('estudiante', $input);
			} else if ($method === 'edit') {
				$id = $this->input->post('id_estudiante', true);
				$action = $this->master->update('estudiante', $input, 'id_estudiante', $id);
			}

			if ($action) {
				$this->output_json(['status' => true]);
			} else {
				$this->output_json(['status' => false]);
			}
		}
	}

	public function delete()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('estudiante', $chk, 'id_estudiante')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

	public function create_user()
	{
		$id = $this->input->get('id', true);
		$data = $this->master->getEstudianteById($id);
		$nombre = explode(' ', $data->nombre);
		$first_name = $nombre[0];
		$last_name = end($nombre);

		$username = $data->nim;
		$password = $data->nim;
		$email = $data->email;
		$additional_data = [
			'first_name'	=> $first_name,
			'last_name'		=> $last_name
		];
		$group = array('3'); // Sets user to profesor.

		if ($this->ion_auth->username_check($username)) {
			$data = [
				'status' => false,
				'msg'	 => 'Nombre de usuario no disponible (ya utilizado).'
			];
		} else if ($this->ion_auth->email_check($email)) {
			$data = [
				'status' => false,
				'msg'	 => 'El correo electrónico no está disponible (ya está en uso).'
			];
		} else {
			$this->ion_auth->register($username, $password, $email, $additional_data, $group);
			$data = [
				'status'	=> true,
				'msg'	 => 'Usuario creado con éxito. NIP se utiliza como contraseña al iniciar sesión.'
			];
		}
		$this->output_json($data);
	}

	public function import($import_data = null)
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Estudiante',
			'subjudul' => 'Importar Datos de Estudiante',
			'kelas' => $this->master->getAllKelas()
		];
		if ($import_data != null) $data['import'] = $import_data;

		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('master/mahasiswa/import');
		$this->load->view('_templates/dashboard/_footer');
	}
	public function preview()
	{
		$config['upload_path']		= './uploads/import/';
		$config['allowed_types']	= 'xls|xlsx|csv';
		$config['max_size']			= 2048;
		$config['encrypt_name']		= true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('upload_file')) {
			$error = $this->upload->display_errors();
			echo $error;
			die;
		} else {
			$file = $this->upload->data('full_path');
			$ext = $this->upload->data('file_ext');

			switch ($ext) {
				case '.xlsx':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					break;
				case '.xls':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
					break;
				case '.csv':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
					break;
				default:
					echo "unknown file ext";
					die;
			}

			$spreadsheet = $reader->load($file);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			$data = [];
			for ($i = 1; $i < count($sheetData); $i++) {
				$data[] = [
					'nim' => $sheetData[$i][0],
					'nombre' => $sheetData[$i][1],
					'email' => $sheetData[$i][2],
					'genero' => $sheetData[$i][3],
					'clase_id' => $sheetData[$i][4]
				];
			}

			unlink($file);

			$this->import($data);
		}
	}

	public function do_import()
	{
		$input = json_decode($this->input->post('data', true));
		$data = [];
		foreach ($input as $d) {
			$data[] = [
				'nim' => $d->nim,
				'nama' => $d->nama,
				'email' => $d->email,
				'genero' => $d->genero,
				'kelas_id' => $d->kelas_id
			];
		}

		$save = $this->master->create('mahasiswa', $data, true);
		if ($save) {
			redirect('mahasiswa');
		} else {
			redirect('mahasiswa/import');
		}
	}
}
