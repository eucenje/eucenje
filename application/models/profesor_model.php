<?php

/**
 * Profesor_Model
 * 
 * @package Profesors
 */
class Profesor_Model extends CI_Model {

    private $_table_name = 'profesors';
    private $_db_fields = array(
        'profesorId',
        'profesorFirstName',
        'profesorLastName',
        'profesorUserId',
        'profesorEmail',
        'profesorStatus'
    );
    private $_required_fields = array(
        'profesorFirstName',
        'profesorLastName',
        'profesorUserId'
    );
    private $_profesorId;
    private $_profesorFirstName;
    private $_profesorLastName;
    private $_profesorUserId;
    private $_profesorEmail;
    private $_profesorStatus;

    /** Utility Methods * */
    function _required($required, $data) {
        foreach ($required as $field)
            if (!isset($data[$field]))
                return false;

        return true;
    }

    function _default($defaults, $options) {
        return array_merge($defaults, $options);
    }

    /** Profesor Methods * */
    function AddProfesor($options = array()) {
        // required values
        if (!$this->_required($this->_required_fields, $options)
        )
            return false;

        foreach ($options as $option => $value) {
            if (in_array($option, $this->_db_fields)) {
                $this->db->set($option, $value);
            }
        }

        $this->db->insert($this->_table_name);

        return $this->db->insert_id();
    }

    function UpdateProfesor($options = array()) {
        
        if (!$this->_required(array('profesorId'), $options)
        ) return false;

        foreach ($options as $option => $value) {
            if (in_array($option, $this->_db_fields)) {
                $this->db->set($option, $value);
            }
        }

        if (isset($options['profesorPassword'])) {
            if (!empty($options['profesorPassword']))
                $this->db->set('profesorPassword', md5($options['profesorPassword']));
            else
                unset($options['profesorPassword']);
        }

        $this->db->where('profesorId', $options['profesorId']);

        $this->db->update($this->_table_name);
        
        return $this->db->affected_rows();
    }

    /**
     * GetProfesors method returns a qualified list of profesors from the profesors table
     * 
     * Options: Values
     * ---------------
     * profesorId
     * profesorName
     * profesorPassword
     * profesorType
     * profesorStatus
     * 
     * limit			limit the returned records
     * offset			bypass this many records
     * sortBy			sort by this column
     * sortDirection	(asc, desc)
     * 
     * Returned Object (array of)
     * --------------------------
     * profesorId
     * profesorName
     * profesorPassword
     * profesorType
     * profesorStatus
     * 
     * @param array $options 
     * @return array of objects
     * 
     */
    function GetProfesors($options = array()) {

        $this->db->select('*');
        $this->db->from($this->_table_name);

//        die(print_r($options));
        // Qualification
        foreach ($options as $option => $value) {
            if (in_array($option, $this->_db_fields)) {
               
                if (is_array($value)) {
                    $c = 0;
                    foreach ($value as $type) {
                        if ($c == 0)
                            $this->db->where($option, $type);
                        else
                            $this->db->or_where($option, $type);
                        $c++;
                    }
                    $this->db->where($option, $value);
                } else
                    $this->db->where($option, $value);
                 
            }
        }

        
        // limit / offset
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']) && !empty($options['limit']))
            $this->db->limit($options['limit']);

        // sort
        if (isset($options['sortBy']) && isset($options['sortDirection']))
            $this->db->order_by($options['sortBy'], $options['sortDirection']);

        if (!isset($options['profesorStatus']))
            $this->db->where('profesorStatus !=', 'deleted');


        $this->db->join('users', 'users.userId = ' . $this->_table_name . '.profesorUserId');
        $query = $this->db->get();


        if (isset($options['count']))
            return $query->num_rows();
        
        if (isset($options['profesorId']) || isset($options['profesorName']) || isset($options['profesorUserId']))
            return $query->row(0);

        return $query->result();
    }

}
