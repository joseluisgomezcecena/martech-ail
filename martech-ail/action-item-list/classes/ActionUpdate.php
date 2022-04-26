<?php

class ActionUpdate
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
        if (isset($_POST["add_action_update"])) 
        {
            $this->addActionUpdate();
        }

        elseif (isset($_POST["progress_update"])) 
        {
            $this->progressUpdate();
        }

        elseif (isset($_POST["edit_update"])) 
        {
            $this->EditUpdate();
        }

    }

   
    private function addActionUpdate()
    {
        if (empty($_POST['action_update'])) 
        {
            $this->errors[] = "You must enter an update";
        }
        elseif (!empty($_POST['action_update']))          
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
                $action_update       = $this->db_connection->real_escape_string(strip_tags($_POST['action_update'], ENT_QUOTES));
                $this_user           = $_SESSION['quatroapp_user_id'];
                $today               = date("Y-m-d");

                $sql = "INSERT INTO action_updates (a_update_action_id, a_update_descr, a_update_user,  a_update_date)
                        VALUES ('" . $action_id . "','" . $action_update . "', '" . $this_user . "', '" . $today . "');";
                $query_new_user_insert = $this->db_connection->query($sql);

                if ($query_new_user_insert) 
                {    
                    $this->messages[] = "Update was saved successfuly.";   
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
        else 
        {
            $this->errors[] = "A validation error occurred.";
        }
    }








    




    private function progressUpdate()
    {
        if (empty($_POST['action_update'])) 
        {
            $this->errors[] = "You must enter an update";
        }
        elseif (empty($_POST['progress'])) 
        {
            $this->errors[] = "You must enter a value for progress";
        }
        

        elseif (!empty($_POST['action_update']) && !empty($_POST['progress']))          
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
                $action_update       = $this->db_connection->real_escape_string(strip_tags($_POST['action_update'], ENT_QUOTES));
                $this_user           = $_SESSION['quatroapp_user_id'];
                $progress            = $this->db_connection->real_escape_string(strip_tags($_POST['progress'], ENT_QUOTES));
                $today               = date("Y-m-d");

                if($progress == 100)
                {
                    $complete = 1;
                    $action_update = "ACTION COMPLETED! - $today: ".$action_update;
                    $action_end_date = date("Y-m-d");
                }
                else
                {
                    $complete = 0;
                    $action_update = "ACTION $progress% COMPLETE - $today: ".$action_update;
                    $action_end_date = "0000-00-00";
                }

                $sql = "INSERT INTO action_updates (a_update_action_id, a_update_descr, a_update_user,  a_update_date, a_update_percent)
                VALUES ('" . $action_id . "','" . $action_update . "', '" . $this_user . "', '" . $today . "', 1);";                
            
                $query_new_user_insert = $this->db_connection->query($sql);

                if ($query_new_user_insert) 
                {
                    if($complete == 1)
                    { 
                        $sql = "UPDATE actions SET action_complete = $complete, action_percent = $progress, action_complete = 1, action_end_date = '$action_end_date'  WHERE action_id = $action_id";
                    }
                    else
                    {
                        $sql = "UPDATE actions SET action_complete = $complete, action_percent = $progress, action_complete = 0, action_end_date = '$action_end_date' WHERE action_id = $action_id";
                    }
                    
                    
                    $query_new_user_insert = $this->db_connection->query($sql);

                    
                    $this->messages[] = "Progress update was saved successfuly.";   
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
        else 
        {
            $this->errors[] = "A validation error occurred.";
        }
    }
   












    private function EditUpdate()
    {
        if (empty($_POST['action_update'])) 
        {
            $this->errors[] = "You must enter an update";
        }
        elseif (empty($_POST['progress'])) 
        {
            $this->errors[] = "You must enter a value for progress";
        }
        

        elseif (!empty($_POST['action_update']) && !empty($_POST['progress']))          
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
                $action_update       = $this->db_connection->real_escape_string(strip_tags($_POST['action_update'], ENT_QUOTES));
                $this_user           = $_SESSION['quatroapp_user_id'];
                $progress            = $this->db_connection->real_escape_string(strip_tags($_POST['progress'], ENT_QUOTES));
                $today               = date("Y-m-d");

                if($progress == 100)
                {
                    $complete = 1;
                    $action_update = "ACTION COMPLETED! - $today: ".$action_update;
                    $action_end_date = date("Y-m-d");
                }
                else
                {
                    $complete = 0;
                    $action_update = "ACTION $progress% COMPLETE - $today: ".$action_update;
                    $action_end_date = "0000-00-00";
                }

                $sql = "INSERT INTO action_updates (a_update_action_id, a_update_descr, a_update_user,  a_update_date, a_update_percent)
                VALUES ('" . $action_id . "','" . $action_update . "', '" . $this_user . "', '" . $today . "', 1);";                
            
                $query_new_user_insert = $this->db_connection->query($sql);

                if ($query_new_user_insert) 
                {
                    if($complete == 1)
                    { 
                        $sql = "UPDATE actions SET action_complete = $complete, action_percent = $progress, action_complete = 1, action_end_date = '$action_end_date'  WHERE action_id = $action_id";
                    }
                    else
                    {
                        $sql = "UPDATE actions SET action_complete = $complete, action_percent = $progress, action_complete = 0, action_end_date = '$action_end_date' WHERE action_id = $action_id";
                    }
                    
                    
                    $query_new_user_insert = $this->db_connection->query($sql);

                    
                    $this->messages[] = "Progress update was saved successfuly.";   
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
        else 
        {
            $this->errors[] = "A validation error occurred.";
        }
    }
   


















}

