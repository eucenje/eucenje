<?php

/**
 * Admin_Model
 * 
 * @package Admins
 */
class Admin_Model extends CI_Model {

    private $_table_name = 'admins';
    private $_db_fields = array(
        'adminId',
        'adminFirstName',
        'adminLastName',
        'adminUserId',
        'adminEmail',
        'adminStatus'
    );
    private $_required_fields = array(
        'adminFirstName',
        'adminLastName',
        'adminUserId'
    );
    private $_adminId;
    private $_adminFirstName;
    private $_adminLastName;
    private $_adminUserId;
    private $_adminEmail;
    private $_adminStatus;

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

    /** Admin Methods * */
    function AddAdmin($options = array()) {
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

    function UpdateAdmin($options = array()) {
        
        if (!$this->_required(array('adminId'), $options)
        ) return false;

        foreach ($options as $option => $value) {
            if (in_array($option, $this->_db_fields)) {
                $this->db->set($option, $value);
            }
        }

        if (isset($options['adminPassword'])) {
            if (!empty($options['adminPassword']))
                $this->db->set('adminPassword', md5($options['adminPassword']));
            else
                unset($options['adminPassword']);
        }

        $this->db->where('adminId', $options['adminId']);

        $this->db->update($this->_table_name);
        
        return $this->db->affected_rows();
    }

    /**
     * GetAdmins method returns a qualified list of admins from the admins table
     * 
     * Options: Values
     * ---------------
     * adminId
     * adminName
     * adminPassword
     * adminType
     * adminStatus
     * 
     * limit			limit the returned records
     * offset			bypass this many records
     * sortBy			sort by this column
     * sortDirection	(asc, desc)
     * 
     * Returned Object (array of)
     * --------------------------
     * adminId
     * adminName
     * adminPassword
     * adminType
     * adminStatus
     * 
     * @param array $options 
     * @return array of objects
     * 
     */
    function GetAdmins($options = array()) {

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

        if (!isset($options['adminStatus']))
            $this->db->where('adminStatus !=', 'deleted');


        $this->db->join('users', 'users.userId = ' . $this->_table_name . '.adminUserId');
        $query = $this->db->get();


        if (isset($options['count']))
            return $query->num_rows();
        
        if (isset($options['adminId']) || isset($options['adminName']) || isset($options['adminUserId']))
            return $query->row(0);

        return $query->result();
    }

}
