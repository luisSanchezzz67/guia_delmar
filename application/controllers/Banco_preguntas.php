<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banco_preguntas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        } else if (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('Lecturer')) {
            show_error('Only Administrators and lecturers are authorized to access this page, <a href="' . base_url('dashboard') . '">Back to main menu</a>', 403, 'Forbidden Access');
        }
        $this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
        $this->load->helper('my'); // Load Library Ignited-Datatables
        $this->load->model('Master_model', 'master');
        $this->load->model('Banco_preguntas_model', 'banco_preguntas');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function index()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user' => $user,
            'titulo'    => 'Pregunta',
            'subtitulo' => 'Banco de Preguntas'
        ];

        if ($this->ion_auth->is_admin()) {
            //Jika admin maka tampilkan semua matkul
            $data['curso'] = $this->master->getAllCurso();
        } else {
            //Jika bukan maka Curso dipilih otomatis sesuai Curso profesor
            $data['curso'] = $this->banco_preguntas->getCursoProfesor($user->username);
        }

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('banco_preguntas/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function detail($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'titulo'        => 'Preguntas',
            'subtitulo'  => 'Editar Preguntas',
            'banco_preguntas'      => $this->banco_preguntas->getBanco_preguntasById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('banco_preguntas/detail');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function add()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'titulo'        => 'Preguntas',
            'subtitulo'  => 'Crear Preguntas'
        ];

        if ($this->ion_auth->is_admin()) {
            //Jika admin maka tampilkan semua curso
            $data['profesor'] = $this->banco_preguntas->getAllProfesor();
        } else {
            //Jika bukan maka curso dipilih otomatis sesuai curso Profesor
            $data['profesor'] = $this->banco_preguntas->getCursoProfesor($user->username);
        }

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('banco_preguntas/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function edit($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'titulo'        => 'Preguntas',
            'subtitulo'  => 'Editar Preguntas',
            'banco_preguntas'      => $this->banco_preguntas->getBanco_preguntasById($id),
        ];

        if ($this->ion_auth->is_admin()) {
            //Jika admin maka tampilkan semua curso
            $data['profesor'] = $this->banco_preguntas->getAllProfesor();
        } else {
            //Jika bukan maka curso dipilih otomatis sesuai curso profesor
            $data['profesor'] = $this->banco_preguntas->getCursoProfesor($user->username);
        }

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('banco_preguntas/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function data($id = null, $profesor = null)
    {
        $this->output_json($this->banco_preguntas->getDataBanco_preguntas($id, $profesor), false);
    }

    public function validasi()
    {
        if ($this->ion_auth->is_admin()) {
            $this->form_validation->set_rules('profesor_id', 'Lecturer', 'required');
        }
        // $this->form_validation->set_rules('soal', 'Soal', 'required');
        // $this->form_validation->set_rules('jawaban_a', 'Jawaban A', 'required');
        // $this->form_validation->set_rules('jawaban_b', 'Jawaban B', 'required');
        // $this->form_validation->set_rules('jawaban_c', 'Jawaban C', 'required');
        // $this->form_validation->set_rules('jawaban_d', 'Jawaban D', 'required');
        // $this->form_validation->set_rules('jawaban_e', 'Jawaban E', 'required');
        $this->form_validation->set_rules('respuesta', 'Answer key', 'required');
        $this->form_validation->set_rules('peso', 'Question Weight', 'required|max_length[2]');
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

        $method = $this->input->post('method', true);
        $this->validasi();
        $this->file_config();


        if ($this->form_validation->run() === FALSE) {
            $method === 'add' ? $this->add() : $this->edit();
        } else {
            $data = [
                'banco_preguntas'      => $this->input->post('banco_preguntas', true),
                'respuesta'   => $this->input->post('respuesta', true),
                'peso'     => $this->input->post('peso', true),
            ];

            $abjad = ['a', 'b', 'c', 'd', 'e'];

            // Inputan Opsi
            foreach ($abjad as $abj) {
                $data['opsi_' . $abj]    = $this->input->post('respuesta_' . $abj, true);
            }

            $i = 0;
            foreach ($_FILES as $key => $val) {
                $img_src = FCPATH . 'uploads/banco_preguntas/';
                $getbanco_preguntas = $this->banco_preguntas->getBanco_preguntasById($this->input->post('id_banco_preguntas', true));

                $error = '';
                if ($key === 'file_banco_preguntas') {
                    if (!empty($_FILES['file_banco_preguntas']['tmp_name'])) {
                        if (!$this->upload->do_upload('file_banco_preguntas')) {
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File Ques. Error'); 
                            exit();
                        } else {
                            if ($method === 'edit') {
                                if (!unlink($img_src . $getbanco_preguntas->file)) {
                                    show_error('Error when deleting image <br/>' . var_dump($getbanco_preguntas), 500, 'Image Editing Error');
                                    exit();
                                }
                            }
                            $data['file'] = $this->upload->data('file_name');
                            $data['tipe_file'] = $this->upload->data('file_type');
                        }
                    }
                } else {
                    $file_abj = 'file_' . $abjad[$i];
                    if (!empty($_FILES[$file_abj]['tmp_name'])) {

                        if (!$this->upload->do_upload($file_abj)) {
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'Option Files ' . strtoupper($abjad[$i]) . ' Error');
                            exit();
                        } else {
                            if ($method === 'edit') {
                                if (!empty($getbanco_preguntas->$file_abj) && !unlink($img_src . $getbanco_preguntas->$file_abj)) {
                                    show_error('Error when deleting image', 500, 'Image Editing Error');
                                    exit();
                                }
                            }
                            $data[$file_abj] = $this->upload->data('file_name');
                        }
                    }
                    $i++;
                }
            }

            if ($this->ion_auth->is_admin()) {
                $pecah = $this->input->post('profesor_id', true);
                $pecah = explode(':', $pecah);
                $data['profesor_id'] = $pecah[0];
                $data['curso_id'] = end($pecah);
            } else {
                $data['profesor_id'] = $this->input->post('profesor_id', true);
                $data['curso_id'] = $this->input->post('curso_id', true);
            }

            if ($method === 'add') {
                //push array
                $data['created_on'] = time();
                $data['updated_on'] = time();
                //insert data
                $this->master->create('tb_banco_preguntas', $data);
            } else if ($method === 'edit') {
                //push array
                $data['updated_on'] = time();
                //update data
                $id_banco_preguntas = $this->input->post('id_banco_preguntas', true);
                $this->master->update('tb_banco_preguntas', $data, 'id_banco_preguntas', $id_banco_preguntas);
                redirect('banco_preguntas/detail/' . $id_banco_preguntas);
            } else {
                show_error('Method unknown', 404);
            }
            redirect('banco_preguntas');
        }
    }

    public function delete()
    {
        $chk = $this->input->post('checked', true);

        // Delete File
        foreach ($chk as $id) {
            $abjad = ['a', 'b', 'c', 'd', 'e'];
            $path = FCPATH . 'uploads/banco_preguntas/';
            $soal = $this->banco_preguntas->getSoalById($id);
            // Hapus File Soal
            if (!empty($soal->file)) {
                if (file_exists($path . $soal->file)) {
                    unlink($path . $soal->file);
                }
            }
            //Hapus File Opsi
            $i = 0; //index
            foreach ($abjad as $abj) {
                $file_opsi = 'file_' . $abj;
                if (!empty($soal->$file_opsi)) {
                    if (file_exists($path . $soal->$file_opsi)) {
                        unlink($path . $soal->$file_opsi);
                    }
                }
            }
        }

        if (!$chk) {
            $this->output_json(['status' => false]);
        } else {
            if ($this->master->delete('tb_soal', $chk, 'id_soal')) {
                $this->output_json(['status' => true, 'total' => count($chk)]);
            }
        }
    }
}
