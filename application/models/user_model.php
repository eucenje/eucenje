<?php

/**
 * User_Model
 * 
 * @package Users
 */
class User_Model extends CI_Model {

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

    /** User Methods * */

    /**
     * AddUser method creates a record in the users table
     * 
     * Option: Values
     * --------------
     * userName
     * userPassword
     * userType
     * userStatus
     * 
     * @param array $options
     * @result int insert_id()
     */
    function AddUser($options = array()) {
        // required values
        if (!$this->_required(
                        array('userName', 'userPassword'), $options)
        )
            return false;

           
        $options = $this->_default(array('userStatus' => 'active'), $options);
        $options['userPassword'] = md5($options['userPassword']);
        
        $this->db->set('userName', $options['userName']);
        $this->db->set('userPassword', $options['userPassword']);
        $this->db->set('userType', $options['userType']);
        if(isset($options['userStatus']))
            $this->db->set('userStatus', $options['userStatus']);
        
        $this->db->insert('users');

        return $this->db->insert_id();
    }

    /**
     * UpdateUser method updates a record in the users table
     * 
     * Option: Values
     * --------------
     * userId			required
     * userName 
     * userPassword
     * userType
     * userStatus
     * 
     * @param array $options
     * @return int affected_rows()
     */
    function UpdateUser($options = array()) {
//        die(print_r($options));
        // required values
        if (!$this->_required(
                        array('userId'), $options)
        ) return false;


        if (isset($options['userName']))
            $this->db->set('userName', $options['userName']);

        if (isset($options['userPassword'])) {
            if (!empty($options['userPassword']))
                $this->db->set('userPassword', md5($options['userPassword']));
            else
                unset($options['userPassword']);
        }
        if (isset($options['userType']))
            $this->db->set('userType', $options['userType']);

        if (isset($options['userStatus']))
            $this->db->set('userStatus', $options['userStatus']);

        $this->db->where('userId', $options['userId']);

        $this->db->update('users');
//        die(print_r($this->db->last_query()));
        return $this->db->affected_rows();
    }

    /**
     * GetUsers method returns a qualified list of users from the users table
     * 
     * Options: Values
     * ---------------
     * userId
     * userName
     * userPassword
     * userType
     * userStatus
     * 
     * limit			limit the returned records
     * offset			bypass this many records
     * sortBy			sort by this column
     * sortDirection	(asc, desc)
     * 
     * Returned Object (array of)
     * --------------------------
     * userId
     * userName
     * userPassword
     * userType
     * userStatus
     * 
     * @param array $options 
     * @return array of objects
     * 
     */
    function GetUsers($options = array()) {
        // Qualification
        if (isset($options['userId']))
            $this->db->where('userId', $options['userId']);
        if (isset($options['userName']))
            $this->db->where('userName', $options['userName']);
        if (isset($options['userPassword']))
            $this->db->where('userPassword', $options['userPassword']);
        if (isset($options['userStatus'])){
            if (is_array($options['userStatus'])) {
                $c = 0;
                foreach ($options['userStatus'] as $type) {
                    if ($c == 0)
                        $this->db->where('userStatus', $type);
                    else
                        $this->db->or_where('userStatus', $type);
                    $c++;
                }
            } else
                 $this->db->where('userStatus', $options['userStatus']);
        }
           
        if (isset($options['userType'])) {
            if (is_array($options['userType'])) {
                $c = 0;
                foreach ($options['userType'] as $type) {
                    if ($c == 0)
                        $this->db->where('userType', $type);
                    else
                        $this->db->or_where('userType', $type);
                    $c++;
                }
            } else
                $this->db->where('userType', $options['userType']);
        }

        // limit / offset
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        // sort
        if (isset($options['sortBy']) && isset($options['sortDirection']))
            $this->db->order_by($options['sortBy'], $options['sortDirection']);

        if (!isset($options['userStatus']))
            $this->db->where('userStatus !=', 'deleted');

        $query = $this->db->get("users");

        if (isset($options['count']))
            return $query->num_rows();

        if (isset($options['userId']) || isset($options['userName']))
            return $query->row(0);

        return $query->result();
    }

    /** authentication methods * */

    /**
     * The login method adds user information from the database to session data.
     * 
     * Option: Values
     * --------------
     * userName
     * userPassword
     *
     * @param array $options
     * @return object result()
     */
    function Login($options = array()) {
        // required values
        if (!$this->_required(
                        array('userName', 'userPassword'), $options)
        )
            return false;

        $user = $this->GetUsers(array('userName' => $options['userName'], 'userPassword' => md5($options['userPassword'])));
        if (!$user)
            return false;
        
        if($user->userStatus != 'active'){
              $this->session->set_flashdata('flashError', 'Your account is suspended.');
            return false;
        }


        $this->session->set_userdata('userName', $user->userName);
        $this->session->set_userdata('userId', $user->userId);
        $this->session->set_userdata('userType', $user->userType);
        $this->session->set_userdata('userLoggedIn', TRUE);
        return true;
    }

    /**
     * The secure method checks a user's session against the passed parameters to determine if the user has
     * access to a specific area.
     * 
     * Option: Values
     * --------------
     * userType
     * 
     * @param array @options
     * @return bool 
     */
    function Secure($options = array()) {
//        die(print_r($options));
        // required values
        if (!$this->_required(
                        array('userType'), $options)
        )
            return false;

        $userType = $this->session->userdata('userType');

        if (is_array($options['userType'])) {
            
            foreach ($options['userType'] as $optionUserType) {
                if ($optionUserType == $userType){
                   
                    return true;
                }
            }
        }
        else {
            if ($userType == $options['userType'])
                return true;
        }

        return false;
    }

    /**
     * Redirect user by level
      Options: Values
      --------------
      userType

      @param array @options

     * */
    function redirect_by_level() {
        $userType = isset($this->session->userdata['userType']) ? $this->session->userdata['userType'] : '';

        switch ($userType) {
            case 'admin':
                redirect('admin/dashboard');
                break;
            case 'profesor':
                redirect('profesor/dashboard');
                break;
            case 'student':
                redirect('student/dashboard');
            default:
                redirect('login');
        }
    }
    
    public function oldPassword($options){
        if (!$this->_required(
                        array('userId', 'oldPassword'), $options)
        )
            return false;
      
        $user = $this->GetUsers(array('userId' => $options['userId'], 'userPassword' => md5($options['oldPassword'])));
        if($user){
            return true;
        } else return false;
        
    }

}

?>
