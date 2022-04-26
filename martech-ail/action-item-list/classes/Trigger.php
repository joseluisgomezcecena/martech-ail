<?php

class Trigger
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
        if (isset($_POST["add_trigger"])) {
            $this->addTrigger();
        }

    }

   
    private function addTrigger()
    {
        if (empty($_POST['tier_id'])) 
        {
            $this->errors[] = "Choose a tier first";
        }
        elseif (empty($_POST['issue'])) 
        {
            $this->errors[] = "Fill the issue field";
        }
        elseif (!empty($_POST['tier_id']) && !empty($_POST['issue'])) 
        {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) 
            {
                $this->errors[] = $this->db_connection->error;
            }

            if (!$this->db_connection->connect_errno) 
            {
                
                $tier_id            = $this->db_connection->real_escape_string(strip_tags($_POST['tier_id'], ENT_QUOTES));
                $tier_area          = $this->db_connection->real_escape_string(strip_tags($_POST['tier_area_id'], ENT_QUOTES));
                $issue              = $this->db_connection->real_escape_string(strip_tags($_POST['issue'], ENT_QUOTES));
                $key_indicator_id   = $this->db_connection->real_escape_string(strip_tags($_POST['key_indicator_id'], ENT_QUOTES));
             


              
                $sql = "INSERT INTO tier_triggers (trigger_issue, trigger_tier_id, trigger_area_id, key_indicator_id)
                        VALUES ('" . $issue . "', '" . $tier_id . "', '" . $tier_area . "', '" . $key_indicator_id . "');";
                $query_new_user_insert = $this->db_connection->query($sql);

                if ($query_new_user_insert) 
                {

                    
                    $this->messages[] = "Trigger sent successfully, currently evaluating.";
                        
                    
                } 
                else 
                {
                    $this->errors[] = "Sorry, registration failed. Please go back and try again.";
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

