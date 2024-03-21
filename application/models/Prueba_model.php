<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prueba_model extends CI_Model {
    
    public function getDataPrueba($id)
    {
        $this->datatables->select('a.id_prueba, a.token, a.nombre_prueba, b.nombre_curso, a.cantidad_banco_preguntas, CONCAT(a.fecha_inicio, " <br/> (", a.tiempo, " Minute)") as tiempo, a.tipo');
        $this->datatables->from('m_prueba a');
        $this->datatables->join('curso b', 'a.curso_id = b.id_curso');
        if($id!==null){
            $this->datatables->where('profesor_id', $id);
        }
        return $this->datatables->generate();
    }
    
    public function getListPrueba($id, $clase)
    {
        $this->datatables->select("a.id_prueba, e.nombre_profesor, d.nombre_clase, a.nombre_prueba, b.nombre_curso, a.cantidad_banco_preguntas, CONCAT(a.fecha_inicio, ' <br/> (', a.tiempo, ' Minute)') as tiempo,  (SELECT COUNT(id) FROM h_prueba h WHERE h.estudiante_id = {$id} AND h.prueba_id = a.id_prueba) AS ada");
        $this->datatables->from('m_prueba a');
        $this->datatables->join('curso b', 'a.curso_id = b.id_curso');
        $this->datatables->join('clase_profesor c', "a.profesor_id = c.profesor_id");
        $this->datatables->join('clase d', 'c.clase_id = d.id_clase');
        $this->datatables->join('profesor e', 'e.id_profesor = c.profesor_id');
        $this->datatables->where('d.id_clase', $clase);
        return $this->datatables->generate();
    }

    public function getPruebaById($id)
    {
        $this->db->select('*');
        $this->db->from('m_prueba a');
        $this->db->join('profesor b', 'a.profesor_id=b.id_profesor');
        $this->db->join('curso c', 'a.curso_id=c.id_curso');
        $this->db->where('id_prueba', $id);
        return $this->db->get()->row();
    }

    public function getIdProfesor($nip)
    {
        $this->db->select('id_profesor, nombre_profesor')->from('profesor')->where('nip', $nip);
        return $this->db->get()->row();
    }

    public function getCantidadBanco_preguntas($profesor)
    {
        $this->db->select('COUNT(id_banco_preguntas) as numero_preguntas');
        $this->db->from('tb_banco_preguntas');
        $this->db->where('profesor_id', $profesor);
        return $this->db->get()->row();
    }

    public function getIdEstudiante($nim)
    {
        $this->db->select('*');
        $this->db->from('estudiante a');
        $this->db->join('clase b', 'a.clase_id=b.id_clase');
        $this->db->join('grupo c', 'b.grupo_id=c.id_grupo');
        $this->db->where('nim', $nim);
        return $this->db->get()->row();
    }

    public function Resultado_examen($id, $mhs)
    {
        $this->db->select('*, UNIX_TIMESTAMP(fecha_terminacion) as tiempo_terminado');
        $this->db->from('h_prueba');
        $this->db->where('prueba_id', $id);
        $this->db->where('estudiante_id', $mhs);
        return $this->db->get();
    }

    public function getBanco_preguntas($id)
    {
        $prueba = $this->getPruebaById($id);
        $order = $prueba->tipo==="Random" ? 'rand()' : 'id_banco_preguntas';

        $this->db->select('id_banco_preguntas, banco_preguntas, file, tipe_file, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e, respuesta');
        $this->db->from('tb_banco_preguntas');
        $this->db->where('profesor_id', $prueba->profesor_id);
        $this->db->where('curso_id', $prueba->curso_id);
        $this->db->order_by($order);
        $this->db->limit($prueba->cantidad_banco_preguntas);
        return $this->db->get()->result();
    }

    public function tomarBanco_preguntas($pc_urut_banco_preguntas1, $pc_urut_banco_preguntas_arr)
    {
        $this->db->select("*, {$pc_urut_banco_preguntas1} AS respuesta");
        $this->db->from('tb_banco_preguntas');
        $this->db->where('id_banco_preguntas', $pc_urut_banco_preguntas_arr);
        return $this->db->get()->row();
    }

    public function getRespuesta($id_tes)
    {
        $this->db->select('list_respuesta');
        $this->db->from('h_prueba');
        $this->db->where('id', $id_tes);
        return $this->db->get()->row()->list_respuesta;
    }

    public function getResultado_examen($nip = null)
    {
        $this->datatables->select('b.id_prueba, b.nombre_prueba, b.cantidad_banco_preguntas, CONCAT(b.tiempo, " Minute") as tiempo, b.fecha_inicio');
        $this->datatables->select('c.nombre_curso, d.nombre_profesor');
        $this->datatables->from('h_prueba a');
        $this->datatables->join('m_prueba b', 'a.prueba_id = b.id_prueba');
        $this->datatables->join('curso c', 'b.curso_id = c.id_curso');
        $this->datatables->join('profesor d', 'b.profesor_id = d.id_profesor');
        $this->datatables->group_by('b.id_prueba');
        if($nip !== null){
            $this->datatables->where('d.nip', $nip);
        }
        return $this->datatables->generate();
    }

    public function Resultado_examenById($id, $dt=false)
    {
        if($dt===false){
            $db = "db";
            $get = "get";
        }else{
            $db = "datatables";
            $get = "generate";
        }
        
        $this->$db->select('d.id, a.nombre, b.nombre_clase, c.nombre_grupo, d.jml_benar, d.valor');
        $this->$db->from('estudiante a');
        $this->$db->join('clase b', 'a.clase_id=b.id_clase');
        $this->$db->join('grupo c', 'b.grupo_id=c.id_grupo');
        $this->$db->join('h_prueba d', 'a.id_estudiante=d.estudiante_id');
        $this->$db->where(['d.prueba_id' => $id]);
        return $this->$db->$get();
    }

    public function revisionValor($id)
    {
        $this->db->select_min('valor', 'min_valor');
        $this->db->select_max('valor', 'max_valor');
        $this->db->select_avg('FORMAT(FLOOR(valor),0)', 'avg_valor');
        $this->db->where('prueba_id', $id);
        return $this->db->get('h_prueba')->row();
    }

}