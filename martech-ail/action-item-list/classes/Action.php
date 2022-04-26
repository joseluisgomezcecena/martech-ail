<?php

class Action
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();
    /**
     * @var array $project Collection of projects
     */
    public $project = array();

   
    public function __construct()
    {
        if (isset($_POST["add_action"])) {
            $this->addAction();
        }

        else if (isset($_POST["edit_action"])) {
            $this->editAction();
        }

        else if (isset($_POST["delete_project"])) {
            $this->deleteSite();
        }
    }

   
    private function addAction()
    {
        if (empty($_POST['action_name'])) 
        {
            $this->errors[] = "Empty Action Name, this field cannot be empty";
        }
        elseif (empty($_POST['action_description'])) 
        {
            $this->errors[] = "Empty Description, this field cannot be empty";
        }
        elseif (empty($_POST['action_owner'])) 
        {
            $this->errors[] = "Action must have an owner, please select one to continue.";
        }
        elseif (empty($_POST['action_department'])) 
        {
            $this->errors[] = "Action must have a responsible department, please select one to continue.";
        }
        elseif (empty($_POST['action_start_date'])) 
        {
            $this->errors[] = "Action must have a start date, please select one to continue.";
        }
        elseif (empty($_POST['action_promise_date'])) 
        {
            $this->errors[] = "Action must have a promise date, please select one to continue.";
        }
        /*
        elseif (empty($_POST['responsible'])) 
        {
            $this->errors[] = "Action must have a support personel.";
        }
        */
        elseif (empty($_POST['action_phase'])) 
        {
            $this->errors[] = "Action must be on a project phase, please select one to continue.";
        }
        /*
        elseif ($_POST['action_start_date'] > $_POST['action_start_date']) 
        {
            $this->errors[] = "Dates dont make sense, please chek that your start date is before your end date.";
        }
        */

        
        elseif (
            !empty($_POST['action_name'])
            && !empty($_POST['action_description'])
            && !empty($_POST['action_owner'])
            && !empty($_POST['action_start_date'])
            && !empty($_POST['action_promise_date'])
            && !empty($_POST['action_department'])
            //&& !empty($_POST['responsible'])
            && !empty($_POST['action_phase'])
            //&& ($_POST['action_start_date'] <= $_POST['action_promise_date'])
        ) 
        {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) 
            {
                $this->errors[] = $this->db_connection->error;
            }

            if (!$this->db_connection->connect_errno) 
            {
                $this->project[]     = $_GET['project_id'];     
                $action_project_id   = $_GET['project_id'];
                $action_name         = $this->db_connection->real_escape_string(strip_tags($_POST['action_name'], ENT_QUOTES));
                $action_description  = $this->db_connection->real_escape_string(strip_tags($_POST['action_description'], ENT_QUOTES));
                $action_owner        = $this->db_connection->real_escape_string(strip_tags($_POST['action_owner'], ENT_QUOTES));
                $action_start_date   = $this->db_connection->real_escape_string(strip_tags($_POST['action_start_date'], ENT_QUOTES));
                $action_promise_date = $this->db_connection->real_escape_string(strip_tags($_POST['action_promise_date'], ENT_QUOTES));
                $action_department   = $this->db_connection->real_escape_string(strip_tags($_POST['action_department'], ENT_QUOTES));
                $action_phase        = $this->db_connection->real_escape_string(strip_tags($_POST['action_phase'], ENT_QUOTES));
             

                $action_start_date =  strtotime($action_start_date);
                $action_start_date = date('Y-m-d', $action_start_date);

                $action_promise_date =  strtotime($action_promise_date);
                $action_promise_date = date('Y-m-d', $action_promise_date);
                
                $today = date("Y-m-d");



                $sql = "SELECT * FROM actions WHERE action_name = '" . $action_name . " AND action_project_id = $action_project_id';";
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) 
                {
                    $this->errors[] = "Sorry, that project is already registered, choose a different name.";
                }
                elseif($action_start_date > $action_promise_date)
                {
                    $this->errors[] = "Dates dont make sense, please chek that your start date is before your end date.";
                } 
                else 
                {
                    $sql = "INSERT INTO actions (action_phase, action_name, action_description,  action_start_date, action_promise_date, action_department, action_project_id)
                            VALUES ('" . $action_phase . "','" . $action_name . "', '" . $action_description . "', '" . $action_start_date . "', '" . $action_promise_date . "', '" . $action_department . "', '" . $action_project_id . "');";
                    $query_new_user_insert = $this->db_connection->query($sql);

                    if ($query_new_user_insert) 
                    {

                        //id of last inserted action
                        $last_action = $this->db_connection->insert_id;

                        $sql2 = "INSERT INTO action_responsible (a_action_id, a_responsible_user, 
                        a_responsible_main, a_responsible_added_by, a_responsible_date) 
                        VALUES ('" . $last_action . "', '" . $action_owner . "', 1, '" . $_SESSION['quatroapp_user_id'] . "', '" . $today . "')";
                        $query_new_user_insert = $this->db_connection->query($sql2);

                        if($query_new_user_insert)
                        {
                            if(!empty($_POST['responsible']))
                            {
                                foreach ($_POST['responsible'] as $responsible)
                                {

                                    if($responsible != $action_owner)
                                    {
                                        //echo $responsible;
                                        $sql3 = "INSERT INTO action_responsible (a_action_id, a_responsible_user, 
                                        a_responsible_main, a_responsible_added_by, a_responsible_date) 
                                        VALUES ('" . $last_action . "', '" . $responsible . "', 0, '" . $_SESSION['quatroapp_user_id'] . "', '" . $today . "')";
                                        $query_new_user_insert = $this->db_connection->query($sql3);
                                    }
                                }
                            }
                            
                            

                            $this->messages[] = "Action saved successfuly.";
                            
                        }
                        else 
                        {
                            $this->errors[] = "Sorry, registration of an owner failed. Please go back and try again.";
                        }
                        
                    } 
                    else 
                    {
                        $this->errors[] = "Sorry, registration failed. Please go back and try again.";
                    }
                }
            } 
            else 
            {
                $this->errors[] = "Sorry, no database connection.";
            }
        } 
        else 
        {
            $this->errors[] = "A validation error occurred.";
        }
    }





    private function editAction()
    {


        if (empty($_POST['action_name'])) 
        {
            $this->errors[] = "Empty Action Name, this field cannot be empty";
        }
        elseif (empty($_POST['action_description'])) 
        {
            $this->errors[] = "Empty Description, this field cannot be empty";
        }
        elseif (empty($_POST['action_owner'])) 
        {
            $this->errors[] = "Action must have an owner, please select one to continue.";
        }
        elseif (empty($_POST['action_department'])) 
        {
            $this->errors[] = "Action must have a responsible department, please select one to continue.";
        }
        elseif (empty($_POST['action_start_date'])) 
        {
            $this->errors[] = "Action must have a start date, please select one to continue.";
        }
        elseif (empty($_POST['action_promise_date'])) 
        {
            $this->errors[] = "Action must have a promise date, please select one to continue.";
        }
        /*
        elseif (empty($_POST['responsible'])) 
        {
            $this->errors[] = "Action must have a support personel.";
        }
        */
        elseif (empty($_POST['action_phase'])) 
        {
            $this->errors[] = "Action must be on a project phase, please select one to continue.";
        }
        /*
        elseif ($_POST['action_start_date'] > $_POST['action_start_date']) 
        {
            $this->errors[] = "Dates dont make sense, please chek that your start date is before your end date.";
        }
        */

        
        elseif (
            !empty($_POST['action_name'])
            && !empty($_POST['action_description'])
            && !empty($_POST['action_owner'])
            && !empty($_POST['action_start_date'])
            && !empty($_POST['action_promise_date'])
            && !empty($_POST['action_department'])
            //&& !empty($_POST['responsible'])
            && !empty($_POST['action_phase'])
            //&& ($_POST['action_start_date'] <= $_POST['action_promise_date'])
        ) 
        {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) 
            {
                $this->errors[] = $this->db_connection->error;
            }

            if (!$this->db_connection->connect_errno) 
            {
                $this->project[]     = $_GET['project_id'];     

                $action_id           = $_GET['action_id'];
                $action_name         = $this->db_connection->real_escape_string(strip_tags($_POST['action_name'], ENT_QUOTES));
                $action_description  = $this->db_connection->real_escape_string(strip_tags($_POST['action_description'], ENT_QUOTES));
                $action_owner        = $this->db_connection->real_escape_string(strip_tags($_POST['action_owner'], ENT_QUOTES));
                $action_start_date   = $this->db_connection->real_escape_string(strip_tags($_POST['action_start_date'], ENT_QUOTES));
                $action_promise_date = $this->db_connection->real_escape_string(strip_tags($_POST['action_promise_date'], ENT_QUOTES));
                $action_department   = $this->db_connection->real_escape_string(strip_tags($_POST['action_department'], ENT_QUOTES));
                $action_phase        = $this->db_connection->real_escape_string(strip_tags($_POST['action_phase'], ENT_QUOTES));
             

                $action_start_date =  strtotime($action_start_date);
                $action_start_date = date('Y-m-d', $action_start_date);

                $action_promise_date =  strtotime($action_promise_date);
                $action_promise_date = date('Y-m-d', $action_promise_date);
                
                $today = date("Y-m-d");



                $sql = "SELECT * FROM actions WHERE action_name = '" . $action_name . "' AND action_id != $action_id;";
                $query_check_user_name = $this->db_connection->query($sql);
                

                if ($query_check_user_name->num_rows == 1) 
                {
                    $this->errors[] = "Sorry, that action is already registered, choose a different name.";
                }
                elseif($action_start_date > $action_promise_date)
                {
                    $this->errors[] = "Dates dont make sense, please chek that your start date is before your end date.";
                } 
                else 
                {
                    $sql = "UPDATE actions SET action_phase = '" . $action_phase . "' , action_name = '" . $action_name . "', 
                    action_description = '" . $action_description . "' ,  action_start_date = '" . $action_start_date . "', 
                    action_promise_date = '" . $action_promise_date . "', action_department = '" . $action_department . "'  
                    WHERE action_id = $action_id";
                    $query_new_user_insert = $this->db_connection->query($sql);        

                    if ($query_new_user_insert) 
                    {
                        $delete = "DELETE FROM action_responsible WHERE a_action_id = $action_id";
                        $run_delete = $this->db_connection->query($delete);
                        //id of last inserted action
                        $last_action = $action_id;

                        $sql2 = "INSERT INTO action_responsible (a_action_id, a_responsible_user, 
                        a_responsible_main, a_responsible_added_by, a_responsible_date) 
                        VALUES ('" . $last_action . "', '" . $action_owner . "', 1, '" . $_SESSION['quatroapp_user_id'] . "', '" . $today . "')";
                        $query_new_user_insert = $this->db_connection->query($sql2);

                        if($query_new_user_insert)
                        {
                            if(!empty($_POST['responsible']))
                            {
                                foreach ($_POST['responsible'] as $responsible)
                                {
                                    if($responsible != $action_owner)
                                    {
                                        //echo $responsible;
                                        $sql3 = "INSERT INTO action_responsible (a_action_id, a_responsible_user, 
                                        a_responsible_main, a_responsible_added_by, a_responsible_date) 
                                        VALUES ('" . $last_action . "', '" . $responsible . "', 0, '" . $_SESSION['quatroapp_user_id'] . "', '" . $today . "')";
                                        $query_new_user_insert = $this->db_connection->query($sql3);
                                    }
                                }
                            }
                            
                            $this->messages[] = "Action updated successfuly.";
                        }
                        else 
                        {
                            $this->errors[] = "Sorry, registration of an owner failed. Please go back and try again.";
                        }
                        
                    } 
                    else 
                    {
                        $this->errors[] = "Sorry, update failed. Please go back and try again.";
                    }
                }
            } 
            else 
            {
                $this->errors[] = "Sorry, no database connection.";
            }
        } 
        else 
        {
            $this->errors[] = "A validation error occurred.";
        }
    }



    






    private function deleteSite()
    {
        $site_id = $_GET['site_id'];

        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) 
        {
            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) 
        {
            $site_name = $this->db_connection->real_escape_string(strip_tags($_POST['site_name'], ENT_QUOTES));
            
            
            $sql = "UPDATE andon_site SET site_active = 0 WHERE site_id = $site_id;";
            $query_new_user_insert = $this->db_connection->query($sql);

            if ($query_new_user_insert) 
            {
                header("Location: index.php?page=andon_sites");
                //$this->messages[] = "Site update successful.";
            } 
            else 
            {
                $this->errors[] = "Sorry, update failed. Please go back and try again.";
            }
            
        } 
        else 
        {
            $this->errors[] = "Sorry, no database connection.";
        } 
    }
}

