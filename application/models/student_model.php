<?php

/**
 * Student_Model
 * 
 * @package Students
 */
class Student_Model extends CI_Model {

    private $_table_name = 'students';
    private $_db_fields = array(
        'studentId',
        'studentFirstName',
        'studentLastName',
        'studentUserId',
        'studentEmail',
        'studentStatus'
    );
    private $_required_fields = array(
        'studentFirstName',
        'studentLastName',
        'studentUserId'
    );
    private $_studentId;
    private $_studentFirstName;
    private $_studentLastName;
    private $_studentUserId;
    private $_studentEmail;
    private $_studentStatus;

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

    /** Student Methods * */
    function AddStudent($options = array()) {
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

    function UpdateStudent($options = array()) {
        
        if (!$this->_required(array('studentId'), $options)
        ) return false;

        foreach ($options as $option => $value) {
            if (in_array($option, $this->_db_fields)) {
                $this->db->set($option, $value);
            }
        }

        if (isset($options['studentPassword'])) {
            if (!empty($options['studentPassword']))
                $this->db->set('studentPassword', md5($options['studentPassword']));
            else
                unset($options['studentPassword']);
        }

        $this->db->where('studentId', $options['studentId']);

        $this->db->update($this->_table_name);
        
        return $this->db->affected_rows();
    }

    /**
     * GetStudents method returns a qualified list of students from the students table
     * 
     * Options: Values
     * ---------------
     * studentId
     * studentName
     * studentPassword
     * studentType
     * studentStatus
     * 
     * limit			limit the returned records
     * offset			bypass this many records
     * sortBy			sort by this column
     * sortDirection	(asc, desc)
     * 
     * Returned Object (array of)
     * --------------------------
     * studentId
     * studentName
     * studentPassword
     * studentType
     * studentStatus
     * 
     * @param array $options 
     * @return array of objects
     * 
     */
    function GetStudents($options = array()) {

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

        if (!isset($options['studentStatus']))
            $this->db->where('studentStatus !=', 'deleted');


        $this->db->join('users', 'users.userId = ' . $this->_table_name . '.studentUserId');
        $query = $this->db->get();


        if (isset($options['count']))
            return $query->num_rows();
        
        if (isset($options['studentId']) || isset($options['studentName']) || isset($options['studentUserId']))
            return $query->row(0);

        return $query->result();
    }

}
