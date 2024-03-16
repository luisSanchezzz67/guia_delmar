<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_model extends CI_Model
{
    public function __construct()
    {
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }

    public function create($table, $data, $batch = false)
    {
        if ($batch === false) {
            $insert = $this->db->insert($table, $data);
        } else {
            $insert = $this->db->insert_batch($table, $data);
        }
        return $insert;
    }

    public function update($table, $data, $pk, $id = null, $batch = false)
    {
        if ($batch === false) {
            $insert = $this->db->update($table, $data, array($pk => $id));
        } else {
            $insert = $this->db->update_batch($table, $data, $pk);
        }
        return $insert;
    }

    public function delete($table, $data, $pk)
    {
        $this->db->where_in($pk, $data);
        return $this->db->delete($table);
    }

    /**
     * Data Clases
     */

    public function getDataClase()
    {
        $this->datatables->select('id_clase, nombre_clase, id_grupo, nombre_grupo');
        $this->datatables->from('clase');
        $this->datatables->join('grupo', 'id_grupo=grupo_id','');
        $this->datatables->add_column('bulk_select', '<div class="text-center"><input type="checkbox" class="check" name="checked[]" value="$1"/></div>', 'id_clase, nombre_clase, id_grupo, nombre_grupo');
        return $this->datatables->generate();
    }

    public function getClaseById($id)
    {
        $this->db->where_in('id_clase', $id);
        $this->db->order_by('nombre_clase');
        $query = $this->db->get('clase')->result();
        return $query;
    }

    /**
     * Data grupo
     */

    public function getDataGrupo()
    {
        $this->datatables->select('id_grupo, nombre_grupo');
        $this->datatables->from('grupo');
        $this->datatables->add_column('bulk_select', '<div class="text-center"><input type="checkbox" class="check" name="checked[]" value="$1"/></div>', 'id_grupo, nombre_grupo');
        return $this->datatables->generate();
    }

    public function getgrupoById($id)
    {
        $this->db->where_in('id_grupo', $id);
        $this->db->order_by('nombre_grupo');
        $query = $this->db->get('grupo')->result();
        return $query;
    }

    /**
     * Data Estudiante
     */

    public function getDataEstudiante()
    {
        $this->datatables->select('a.id_estudiante, a.nombre, a.nim, a.email, b.nombre_clase, c.nombre_grupo');
        $this->datatables->select('(SELECT COUNT(id) FROM users WHERE username = a.nim OR email = a.email) AS ada');
        $this->datatables->from('estudiante a');
        $this->datatables->join('clase b', 'a.clase_id=b.id_clase');
        $this->datatables->join('grupo c', 'b.grupo_id=c.id_grupo');
        return $this->datatables->generate();
    }

    public function getEstudianteById($id)
    {
        $this->db->select('*');
        $this->db->from('estudiante');
        $this->db->join('clase', 'clase_id=id_clase');
        $this->db->join('grupo', 'grupo_id=id_grupo');
        $this->db->where(['id_estudiante' => $id]);
        return $this->db->get()->row();
    }

    public function getGrupo()
    {
        $this->db->select('id_grupo, nombre_grupo');
        $this->db->from('clase');
        $this->db->join('grupo', 'grupo_id=id_grupo');
        $this->db->order_by('nombre_grupo', 'ASC');
        $this->db->group_by('id_grupo');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllGrupo($id = null)
    {
        if ($id === null) {
            $this->db->order_by('nombre_grupo', 'ASC');
            return $this->db->get('grupo')->result();
        } else {
            $this->db->select('grupo_id');
            $this->db->from('grupo_curso');
            $this->db->where('curso_id', $id);
            $grupo = $this->db->get()->result();
            $id_grupo = [];
            foreach ($grupo as $j) {
                $id_grupo[] = $j->grupo_id;
            }
            if ($id_grupo === []) {
                $id_grupo = null;
            }
            
            $this->db->select('*');
            $this->db->from('grupo');
            $this->db->where_not_in('id_grupo', $id_grupo);
            $curso = $this->db->get()->result();
            return $curso;
        }
    }

    public function getClaseByGrupo($id)
    {
        $query = $this->db->get_where('clase', array('grupo_id'=>$id));
        return $query->result();
    }

    /**
     * Data Profesor
     */

    public function getDataProfesor()
    {
        $this->datatables->select('a.id_profesor,a.nip, a.nombre_profesor, a.email, a.curso_id, b.nombre_curso, (SELECT COUNT(id) FROM users WHERE username = a.nip OR email = a.email) AS ada');
        $this->datatables->from('profesor a');
        $this->datatables->join('curso b', 'a.curso_id=b.id_curso');
        return $this->datatables->generate();
    }

    public function getProfesorById($id)
    {
        $query = $this->db->get_where('profesor', array('id_profesor'=>$id));
        return $query->row();
    }

    /**
     * Data Cursos
     */

    public function getDataCurso()
    {
        $this->datatables->select('id_curso, nombre_curso');
        $this->datatables->from('curso');
        return $this->datatables->generate();
    }

    public function getAllCurso()
    {
        return $this->db->get('curso')->result();
    }

    public function getCursoById($id, $single = false)
    {
        if ($single === false) {
            $this->db->where_in('id_curso', $id);
            $this->db->order_by('nombre_curso');
            $query = $this->db->get('curso')->result();
        } else {
            $query = $this->db->get_where('curso', array('id_curso'=>$id))->row();
        }
        return $query;
    }

    /**
     * Data Kelas Dosen
     */

    public function getKelasDosen()
    {
        $this->datatables->select('kelas_dosen.id, dosen.id_dosen, dosen.nip, dosen.nama_dosen, GROUP_CONCAT(kelas.nama_kelas) as kelas');
        $this->datatables->from('kelas_dosen');
        $this->datatables->join('kelas', 'kelas_id=id_kelas');
        $this->datatables->join('dosen', 'dosen_id=id_dosen');
        $this->datatables->group_by('dosen.nama_dosen');
        return $this->datatables->generate();
    }

    public function getAllDosen($id = null)
    {
        $this->db->select('dosen_id');
        $this->db->from('kelas_dosen');
        if ($id !== null) {
            $this->db->where_not_in('dosen_id', [$id]);
        }
        $dosen = $this->db->get()->result();
        $id_dosen = [];
        foreach ($dosen as $d) {
            $id_dosen[] = $d->dosen_id;
        }
        if ($id_dosen === []) {
            $id_dosen = null;
        }

        $this->db->select('id_dosen, nip, nama_dosen');
        $this->db->from('dosen');
        $this->db->where_not_in('id_dosen', $id_dosen);
        return $this->db->get()->result();
    }

    
    public function getAllKelas()
    {
        $this->db->select('id_kelas, nama_kelas, nama_jurusan');
        $this->db->from('kelas');
        $this->db->join('jurusan', 'jurusan_id=id_jurusan');
        $this->db->order_by('nama_kelas');
        return $this->db->get()->result();
    }
    
    public function getKelasByDosen($id)
    {
        $this->db->select('kelas.id_kelas');
        $this->db->from('kelas_dosen');
        $this->db->join('kelas', 'kelas_dosen.kelas_id=kelas.id_kelas');
        $this->db->where('dosen_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }
    /**
     * Data Jurusan Matkul
     */

    public function getJurusanMatkul()
    {
        $this->datatables->select('jurusan_matkul.id, matkul.id_matkul, matkul.nama_matkul, jurusan.id_jurusan, GROUP_CONCAT(jurusan.nama_jurusan) as nama_jurusan');
        $this->datatables->from('jurusan_matkul');
        $this->datatables->join('matkul', 'matkul_id=id_matkul');
        $this->datatables->join('jurusan', 'jurusan_id=id_jurusan');
        $this->datatables->group_by('matkul.nama_matkul');
        return $this->datatables->generate();
    }

    public function getMatkul($id = null)
    {
        $this->db->select('matkul_id');
        $this->db->from('jurusan_matkul');
        if ($id !== null) {
            $this->db->where_not_in('matkul_id', [$id]);
        }
        $matkul = $this->db->get()->result();
        $id_matkul = [];
        foreach ($matkul as $d) {
            $id_matkul[] = $d->matkul_id;
        }
        if ($id_matkul === []) {
            $id_matkul = null;
        }

        $this->db->select('id_matkul, nama_matkul');
        $this->db->from('matkul');
        $this->db->where_not_in('id_matkul', $id_matkul);
        return $this->db->get()->result();
    }

    public function getJurusanByIdMatkul($id)
    {
        $this->db->select('jurusan.id_jurusan');
        $this->db->from('jurusan_matkul');
        $this->db->join('jurusan', 'jurusan_matkul.jurusan_id=jurusan.id_jurusan');
        $this->db->where('matkul_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }
}
