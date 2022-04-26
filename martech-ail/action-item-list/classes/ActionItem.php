<?php

class ActionItem
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
        //add actions
        if(isset($_POST["add_action"])) {
            $this->addAction();
        }

        //finish list
        else if (isset($_POST["edit_action"])) {
            $this->editAction();
        }
        
        else if (isset($_POST["edit_action"])) {
            $this->editAction();
        }

        //save meeting with save and finish button
        else if (isset($_POST["add_list"])) {
            $this->saveMeeting();
        }

        else if (isset($_POST["delete_action"])) {
            $this->deleteAction();
        }

        else if (isset($_POST["submit_update"])) {
            $this->updateAction();
        }

        else if (isset($_POST["complete_meeting"])) {
            $this->completeMeeting();
        }
    }

   
    private function addAction()
    {
        if (empty($_POST['meeting'])) 
        {
            $this->errors[] = "Empty Meeting Name, this field cannot be empty";
        }
        elseif (empty($_POST['department'])) 
        {
            $this->errors[] = "Empty Department, this field cannot be empty";
        }
        elseif (empty($_POST['meeting_date'])) 
        {
            $this->errors[] = "Meeting must have a date, please select one to continue.";
        }
        elseif (empty($_POST['action'])) 
        {
            $this->errors[] = "Action must have a name, please select one to continue.";
        }
        elseif (empty($_POST['owner'])) 
        {
            $this->errors[] = "Action must have an owner, please select one to continue.";
        }
        elseif (empty($_POST['ecd'])) 
        {
            $this->errors[] = "Action must have a promise date, please select one to continue.";
        }
      
        
        elseif (
            !empty($_POST['meeting'])
            && !empty($_POST['department'])
            && !empty($_POST['meeting_date'])
            && !empty($_POST['action'])
            && !empty($_POST['owner'])
            && !empty($_POST['ecd'])
        ) 
        {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) 
            {
                $this->errors[] = $this->db_connection->error;
            }

            if (!$this->db_connection->connect_errno) 
            {
                /*
                if(isset($_GET['meeting_id']))
                {
                    $this->project[]     = $_GET['meeting_id'];
                    $meeting_id          = $_GET['meeting_id'];
                }
                */   
                
                $meeting             = $this->db_connection->real_escape_string(strip_tags($_POST['meeting'], ENT_QUOTES));
                $department          = $this->db_connection->real_escape_string(strip_tags($_POST['department'], ENT_QUOTES));
                $meeting_date        = $this->db_connection->real_escape_string(strip_tags($_POST['meeting_date'], ENT_QUOTES));
                $action              = $this->db_connection->real_escape_string(strip_tags($_POST['action'], ENT_QUOTES));
                $owner               = $this->db_connection->real_escape_string(strip_tags($_POST['owner'], ENT_QUOTES));
                $ecd                 = $this->db_connection->real_escape_string(strip_tags($_POST['ecd'], ENT_QUOTES));
                $issue               = $this->db_connection->real_escape_string(strip_tags($_POST['issue'], ENT_QUOTES));
                
                if(isset($_POST['private']))
                {
                    $private            = $_POST['private'];
                    if($private == 'on')
                        $private = 1;
                    else
                        $private = 0;
                }
                else
                {
                    $private = 0;
                }

                $meeting_date =  strtotime($meeting_date);
                $meeting_date = date('Y-m-d', $meeting_date);

                $ecd =  strtotime($ecd);
                $ecd = date('Y-m-d', $ecd);
                
                $today = date("Y-m-d");


                if(isset($_GET['meeting_id']))
                {
                    $sql = "SELECT * FROM ail_meeting WHERE meeting_name = '" . $meeting . "' AND meeting_id != {$_GET['meeting_id']};";
                }
                else
                {
                    $sql = "SELECT * FROM ail_meeting WHERE meeting_name = '" . $meeting . "';";
                }
                
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) 
                {
                    $this->errors[] = "Sorry, that meeting is already registered, choose a different name.";
                }
                elseif($today > $ecd)
                {
                    $this->errors[] = "ECD or Promise date is before today, please check your dates.";
                } 
                else 
                {

                    if(isset($_GET['meeting_id']))
                    {
                        $meeting_id = $_GET['meeting_id'];

                        $sql_update = "UPDATE ail_meeting SET meeting_name = '" . $meeting . "', meeting_department = '" . $department . "',  meeting_date = '" . $meeting_date . "',   meeting_register = '" . $today . "' 
                        WHERE  meeting_id = $meeting_id";
                        $run_update = $this->db_connection->query($sql_update);
                        
                        $sql2 = "INSERT INTO ail_action (ail_action_name, ail_issue_name, ail_action_ecd, ail_owner,  ail_meeting_id, ail_action_date)
                        VALUES ('" . $action . "', '" . $issue . "','" . $ecd . "', '" . $owner . "', '" . $meeting_id . "', '".$today."');";

                        $query_new_action = $this->db_connection->query($sql2);
                        if($query_new_action)
                        {
                            $action_id = $this->db_connection->insert_id;

                            if(!empty($_POST['responsible']))
                            {
                                foreach ($_POST['responsible'] as $responsible)
                                {

                                    if($responsible != $owner)
                                    {
                                        //echo $responsible;
                                        $sql3 = "INSERT INTO ail_users (ail_meeting_id, ail_action_id, ail_user_id, ail_user_register) 
                                        VALUES ('" . $meeting_id . "', '" . $action_id . "', '".$responsible."', '" . $today . "')";
                                        $query_new_user_insert = $this->db_connection->query($sql3);
                                    }
                                }

                                
                            }

                            $this->project[]     = $_GET['meeting_id'];
                            $this->messages[]    = "Action saved successfuly.";

                        }
                        else
                        {
                            //$this->errors[] = "Sorry, meeting registration failed. Please go back and try again.";
                            echo $sql2;    
                        }


                    }
                    else
                    {

                        $sql1 = "INSERT INTO ail_meeting (meeting_name, meeting_department, meeting_date,  meeting_register, private, meeting_owner)
                        VALUES ('" . $meeting . "','" . $department . "', '" . $meeting_date . "', '" . $today . "', '".$private."', '{$_SESSION['quatroapp_user_id']}');";
                        
                        $query_new_meeting = $this->db_connection->query($sql1);

                        if($query_new_meeting) 
                        {
                            $meeting_id = $this->db_connection->insert_id;

                            $sql2 = "INSERT INTO ail_action (ail_action_name, ail_issue_name, ail_action_ecd, ail_owner,  ail_meeting_id, ail_action_date)
                            VALUES ('" . $action . "', '" . $issue . "', '" . $ecd . "', '" . $owner . "', '" . $meeting_id . "', '".$today."');";

                            $query_new_action = $this->db_connection->query($sql2);
                            if($query_new_action)
                            {
                                $action_id = $this->db_connection->insert_id;

                                if(!empty($_POST['responsible']))
                                {
                                    foreach ($_POST['responsible'] as $responsible)
                                    {
                                        if($responsible != $owner)
                                        {
                                            //echo $responsible;
                                            $sql3 = "INSERT INTO ail_users (ail_meeting_id, ail_action_id, ail_user_id, ail_user_register) 
                                            VALUES ('" . $meeting_id . "', '" . $action_id . "', '".$responsible."', '" . $today . "')";
                                            $query_new_user_insert = $this->db_connection->query($sql3);
                                        }
                                    }
                                    
                                    
                                }

                                $this->project[]     = $meeting_id;
                                $this->messages[] = "Action and Meeting saved successfuly.";

                            }
                            else
                            {
                                //$this->errors[] = "Sorry, meeting registration failed. Please go back and try again.";
                                echo $sql2;    
                            }

                        }
                        else
                        {
                            //$this->errors[] = "Sorry, meeting registration failed. Please go back and try again.";
                            echo $sql1;  
                            echo("<br>Error description: " . $this->db_connection->error);
 
                        }
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






    private function saveMeeting()
    {
        if (empty($_POST['meeting'])) 
        {
            $this->errors[] = "Empty Meeting Name, this field cannot be empty";
        }
        elseif (empty($_POST['department'])) 
        {
            $this->errors[] = "Empty Department, this field cannot be empty";
        }
        elseif (empty($_POST['meeting_date'])) 
        {
            $this->errors[] = "Meeting must have a date, please select one to continue.";
        }
        
      
        
        elseif (
            !empty($_POST['meeting'])
            && !empty($_POST['department'])
            && !empty($_POST['meeting_date'])
        ) 
        {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) 
            {
                $this->errors[] = $this->db_connection->error;
            }

            if (!$this->db_connection->connect_errno) 
            {
                
                
                $meeting             = $this->db_connection->real_escape_string(strip_tags($_POST['meeting'], ENT_QUOTES));
                $department          = $this->db_connection->real_escape_string(strip_tags($_POST['department'], ENT_QUOTES));
                $meeting_date        = $this->db_connection->real_escape_string(strip_tags($_POST['meeting_date'], ENT_QUOTES));
                
                
                if(isset($_POST['private']))
                {
                    $private            = $_POST['private'];
                    if($private == 'on')
                        $private = 1;
                    else
                        $private = 0;
                }
                else
                {
                    $private = 0;
                }

                $meeting_date =  strtotime($meeting_date);
                $meeting_date = date('Y-m-d', $meeting_date);

                
                $today = date("Y-m-d");


                if(isset($_GET['meeting_id']))
                {
                    $sql = "SELECT * FROM ail_meeting WHERE meeting_name = '" . $meeting . "' AND meeting_id != {$_GET['meeting_id']};";
                }
                else
                {
                    $sql = "SELECT * FROM ail_meeting WHERE meeting_name = '" . $meeting . "';";
                }
                
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) 
                {
                    $this->errors[] = "Sorry, that meeting is already registered, choose a different name.";
                }
                else 
                {

                    if(isset($_GET['meeting_id']))
                    {
                        $meeting_id = $_GET['meeting_id'];

                        $sql_update = "UPDATE ail_meeting SET meeting_name = '" . $meeting . "', meeting_department = '" . $department . "',  meeting_date = '" . $meeting_date . "',   meeting_register = '" . $today . "' 
                        WHERE  meeting_id = $meeting_id";
                        $run_update = $this->db_connection->query($sql_update);
                        
                        if($run_update){
                            $this->project[]     = $_GET['meeting_id'];
                            $this->messages[]    = "Action saved successfuly.";

                        }                                                    
                        else
                        {
                            //$this->errors[] = "Sorry, meeting registration failed. Please go back and try again.";
                            echo $sql_update;    
                        }


                    }
                    else
                    {
                        $sql1 = "INSERT INTO ail_meeting (meeting_name, meeting_department, meeting_date,  meeting_register, private, meeting_owner)
                        VALUES ('" . $meeting . "','" . $department . "', '" . $meeting_date . "', '" . $today . "', '".$private."', '{$_SESSION['quatroapp_user_id']}');";
                        
                        $query_new_meeting = $this->db_connection->query($sql1);

                        if($query_new_meeting) 
                        {
                            $meeting_id = $this->db_connection->insert_id;

                            

                                $this->project[]     = $meeting_id;
                                $this->messages[] = "Action and Meeting saved successfuly.";

                        


                        }
                        else
                        {
                            //$this->errors[] = "Sorry, meeting registration failed. Please go back and try again.";
                            echo $sql1;  
                            echo("<br>Error description: " . $this->db_connection->error);
 
                        }
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








    private function updateAction()
    {
        if (empty($_POST['update_text'])) 
        {
            $this->errors[] = "Empty text, please fill out form";
        }
        
        elseif (empty($_POST['action_id'])) 
        {
            $this->errors[] = "404 Error";
        }

        elseif (
            !empty($_POST['update_text'])
            && !empty($_POST['action_id'])
        ) 
        {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) 
            {
                $this->errors[] = $this->db_connection->error;
            }

            if (!$this->db_connection->connect_errno) 
            {
                $meeting_id              = $_GET['meeting_id'];
                $update_text             = $this->db_connection->real_escape_string(strip_tags($_POST['update_text'], ENT_QUOTES));
                $action_id               = $this->db_connection->real_escape_string(strip_tags($_POST['action_id'], ENT_QUOTES));
                $action_complete         = $this->db_connection->real_escape_string(strip_tags($_POST['action_complete'], ENT_QUOTES));
                $user                    = $_SESSION['quatroapp_user_id'];
                $today                   = date("Y-m-d");


            
                $sql1 = "INSERT INTO ail_updates (update_date, update_user, update_text, action_id)
                VALUES ('" . $today . "','" . $user . "', '" . $update_text . "', '".$action_id."');";
                
                $query_new_update = $this->db_connection->query($sql1);

                if($query_new_update) 
                {

                    if($action_complete == 1)
                    {
                        $sql2 = "UPDATE ail_action SET action_complete = 1 WHERE ail_action_id = $action_id";
                        $query_complete = $this->db_connection->query($sql2);
                    }

                    $this->project[]     = $meeting_id;
                    $this->messages[] = "Action update saved successfuly."; 
                }
                else
                {
                    //$this->errors[] = "Sorry, meeting registration failed. Please go back and try again.";
                    echo $sql1;  
                    echo("<br>Error description: " . $this->db_connection->error);

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
        
        if (empty($_POST['action'])) 
        {
            $this->errors[] = "Action must have a name, please select one to continue.";
        }
        elseif (empty($_POST['owner'])) 
        {
            $this->errors[] = "Action must have an owner, please select one to continue.";
        }
        elseif (empty($_POST['ecd'])) 
        {
            $this->errors[] = "Action must have a promise date, please select one to continue.";
        }
      
        
        elseif (
            !empty($_POST['action'])
            && !empty($_POST['owner'])
            && !empty($_POST['ecd'])
        ) 
        {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) 
            {
                $this->errors[] = $this->db_connection->error;
            }

            if (!$this->db_connection->connect_errno) 
            {
                $action_id           = $_POST['action_id'];
                $action              = $this->db_connection->real_escape_string(strip_tags($_POST['action'], ENT_QUOTES));
                $owner               = $this->db_connection->real_escape_string(strip_tags($_POST['owner'], ENT_QUOTES));
                $issue               = $this->db_connection->real_escape_string(strip_tags($_POST['issue'], ENT_QUOTES));
                $ecd                 = $this->db_connection->real_escape_string(strip_tags($_POST['ecd'], ENT_QUOTES));
                

                $ecd =  strtotime($ecd);
                $ecd = date('Y-m-d', $ecd);
                
                $today = date("Y-m-d");


                
                if($today > $ecd)
                {
                    $this->errors[] = "ECD or Promise date is before today, please check your dates.";
                } 
                else 
                {

                    if(isset($_GET['meeting_id']))
                    {
                        $meeting_id = $_GET['meeting_id'];
   
                        $sql2 = "UPDATE ail_action SET ail_issue_name = '".$issue."', ail_action_name = '" . $action . "', ail_action_ecd ='" . $ecd . "', ail_owner ='" . $owner . "',  ail_meeting_id = '" . $meeting_id . "', ail_action_date = '".$today."' WHERE ail_action_id = $action_id;";

                        $query_new_action = $this->db_connection->query($sql2);
                        if($query_new_action)
                        {
                            //$action_id = $this->db_connection->insert_id;

                            if(!empty($_POST['responsible']))
                            {
                                $delete_previous = "DELETE FROM ail_users WHERE ail_action_id = $action_id";
                                $run_delete = $this->db_connection->query($delete_previous);

                                foreach ($_POST['responsible'] as $responsible)
                                {

                                    if($responsible != $owner)
                                    {
                                        //echo $responsible;
                                        $sql3 = "INSERT INTO ail_users (ail_meeting_id, ail_action_id, ail_user_id, ail_user_register) 
                                        VALUES ('" . $meeting_id . "', '" . $action_id . "', '".$responsible."', '" . $today . "')";
                                        $query_new_user_insert = $this->db_connection->query($sql3);
                                    }
                                }

                                
                            }

                            $this->project[]     = $_GET['meeting_id'];
                            $this->messages[]    = "Action saved successfuly.";

                        }
                        else
                        {
                            //$this->errors[] = "Sorry, meeting registration failed. Please go back and try again.";
                            echo $sql2;    
                        }


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





    private function editActionb()
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



    






    private function deleteAction()
    {
        $action_id = $_POST['action_id'];

        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) 
        {
            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) 
        {
            
            
            $sql = "UPDATE ail_action SET action_active = 0 WHERE ail_action_id = $action_id;";
            $query_new_user_insert = $this->db_connection->query($sql);

            if ($query_new_user_insert) 
            {
                $this->project[]     = $_GET['meeting_id'];
                //header("Location: index.php?page=andon_sites");
                $this->messages[] = "Action deleted successfully.";
            } 
            else 
            {
                $this->errors[] = "Sorry, could not delete. Please go back and try again.";
            }
            
        } 
        else 
        {
            $this->errors[] = "Sorry, no database connection.";
        } 
    }











    private function completeMeeting()
    {
        $meeting_id = $_GET['meeting_id'];
        $total      = $_POST['total'];
        $completed  = $_POST['completed'];

        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) 
        {
            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) 
        {
            
            if($total == $completed)
            {

                $sql = "UPDATE ail_meeting SET meeting_complete = 1 WHERE meeting_id = $meeting_id;";
                $query_new_user_insert = $this->db_connection->query($sql);

                if ($query_new_user_insert) 
                {
                    $this->project[]     = $_GET['meeting_id'];
                    //header("Location: index.php?page=andon_sites");
                    $this->messages[] = "Meeting completed successfully, data is available in reports.";
                } 
                else 
                {
                    $this->errors[] = "Sorry, could not delete. Please go back and try again.";
                }

            }else
            {
                $this->errors[] = "Sorry, all actions must be completed first. Complete them and try again.";
            }
            
            
            
        } 
        else 
        {
            $this->errors[] = "Sorry, no database connection.";
        } 
    }








}

