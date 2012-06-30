<?php

/**
 * Fakultet_Model
 * 
 * @package Fakultets
 */
class Fakultet_Model extends CI_Model {

    private $_table_name = 'fakulteti';
    private $_db_fields = array(
        'fakultetId',
        'fakultetName',
        'fakultetType',
        'fakultetYears',
        'fakultetStatus'
    );
    private $_required_fields = array(
        'fakultetName'
    );
    private $_fakultetId;
    private $_fakultetName;
    private $_fakultetType;
    private $_fakultetYears;
    private $_fakultetStatus;

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

    /** Fakultet Methods * */
    function AddFakultet($options = array()) {
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

    function UpdateFakultet($options = array()) {
        
        if (!$this->_required(array('fakultetId'), $options)
        ) return false;

        foreach ($options as $option => $value) {
            if (in_array($option, $this->_db_fields)) {
                $this->db->set($option, $value);
            }
        }

        if (isset($options['fakultetPassword'])) {
            if (!empty($options['fakultetPassword']))
                $this->db->set('fakultetPassword', md5($options['fakultetPassword']));
            else
                unset($options['fakultetPassword']);
        }

        $this->db->where('fakultetId', $options['fakultetId']);

        $this->db->update($this->_table_name);
        
        return $this->db->affected_rows();
    }

    /**
     * GetFakultets method returns a qualified list of fakulteti from the fakulteti table
     * 
     * Options: Values
     * ---------------
     * fakultetId
     * fakultetName
     * fakultetPassword
     * fakultetType
     * fakultetStatus
     * 
     * limit			limit the returned records
     * offset			bypass this many records
     * sortBy			sort by this column
     * sortDirection	(asc, desc)
     * 
     * Returned Object (array of)
     * --------------------------
     * fakultetId
     * fakultetName
     * fakultetPassword
     * fakultetType
     * fakultetStatus
     * 
     * @param array $options 
     * @return array of objects
     * 
     */
    function GetFakulteti($options = array()) {

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

        if (!isset($options['fakultetStatus']))
            $this->db->where('fakultetStatus !=', 'deleted');


       
        $query = $this->db->get();


        if (isset($options['count']))
            return $query->num_rows();
        
        if (isset($options['fakultetId']) || isset($options['fakultetName']) || isset($options['fakultetUserId']))
            return $query->row(0);

        return $query->result();
    }

}
