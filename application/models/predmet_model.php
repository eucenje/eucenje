<?php

/**
 * Predmet_Model
 * 
 * @package Predmets
 */
class Predmet_Model extends CI_Model {

    private $_table_name = 'predmeti';
    private $_db_fields = array(
        'predmetId',
        'predmetName',
        'predmetFakultetId',
        'predmetProfesorId',
        'predmetStatus'
    );
    private $_required_fields = array(
        'predmetName'
    );
    private $_predmetId;
    private $_predmetName;
    private $_predmetFakultetId;
    private $_predmetProfesor;
    private $_predmetStatus;

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

    /** Predmet Methods * */
    function AddPredmet($options = array()) {
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

    function UpdatePredmet($options = array()) {
        
        if (!$this->_required(array('predmetId'), $options)
        ) return false;

        foreach ($options as $option => $value) {
            if (in_array($option, $this->_db_fields)) {
                $this->db->set($option, $value);
            }
        }

        if (isset($options['predmetPassword'])) {
            if (!empty($options['predmetPassword']))
                $this->db->set('predmetPassword', md5($options['predmetPassword']));
            else
                unset($options['predmetPassword']);
        }

        $this->db->where('predmetId', $options['predmetId']);

        $this->db->update($this->_table_name);
        
        return $this->db->affected_rows();
    }

    /**
     * GetPredmets method returns a qualified list of predmeti from the predmeti table
     * 
     * Options: Values
     * ---------------
     * predmetId
     * predmetName
     * predmetPassword
     * predmetType
     * predmetStatus
     * 
     * limit			limit the returned records
     * offset			bypass this many records
     * sortBy			sort by this column
     * sortDirection	(asc, desc)
     * 
     * Returned Object (array of)
     * --------------------------
     * predmetId
     * predmetName
     * predmetPassword
     * predmetType
     * predmetStatus
     * 
     * @param array $options 
     * @return array of objects
     * 
     */
    function GetPredmeti($options = array()) {

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

        if (!isset($options['predmetStatus']))
            $this->db->where('predmetStatus !=', 'deleted');


       
        $query = $this->db->get();


        if (isset($options['count']))
            return $query->num_rows();
        
        if (isset($options['predmetId']) || isset($options['predmetName']) || isset($options['predmetUserId']))
            return $query->row(0);

        return $query->result();
    }

}
