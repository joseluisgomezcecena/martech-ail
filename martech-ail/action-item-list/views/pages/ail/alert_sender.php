<?php
    require_once("db.php");

    error_reporting(E_ALL);
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    function scale1()
    {    
        global $connection;

        //MENSAJE AUTOMATICO
        $query_message = "SELECT * FROM automated_messages ORDER BY id DESC LIMIT 1";
        $run_query_message = mysqli_query($connection, $query_message);
        $row_message = mysqli_fetch_array($run_query_message);
        $msg = $row_message['message'];

        //first
        $today = date("Y-m-d");

        //$query = "SELECT * FROM incoming_log LEFT JOIN users ON incoming_log.responsible_dept_id = users.department_id WHERE out_quarantine = 0 AND received = 1 AND date_end < '$today' AND scale1 = 0 ;";
        //$query = "SELECT * FROM incoming_log LEFT JOIN users ON incoming_log.responsible_dept_id = users.department_id WHERE out_quarantine = 0 AND received = 0 AND date_end < '$today' AND incoming_log.scale1 = 0 AND users.scale1 = 1;";
        $query = "SELECT * FROM incoming_log WHERE out_quarantine = 0 AND received = 1 AND date_end < '$today' AND scale1 = 0 ;";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($result))
        {
            $user_query = "SELECT * FROM users WHERE department_id = {$row['responsible_dept_id']} AND scale1 = 1 ";
            $user_run = mysqli_query($connection, $user_query);
            while($user_row = mysqli_fetch_array($user_run))
            {
                $CC[] = $user_row['user_email'];
            }
            $email = "aavila@martechmedical.com";
            $title = "Late item Part: ".$row['part']." Lot: ".$row['lot'];
            $message = $msg."<br>"."<br>Late item Part: ".$row['part']."<br/>Lot: ".$row['lot']."<br>Responsible for material: ".$row['responsible']."<br>This is the first escalation alert";
            sendEmail($email, $title, $message, $CC);

            $update = "UPDATE incoming_log SET scale1 = 1 WHERE incoming_id = {$row['incoming_id']}";
            $run_update = mysqli_query($connection, $update);
            if(!$run_update)
            {
                echo "Error on run update";
            }
        }
    }




    function scale2()
    {    
        global $connection;

        //MENSAJE AUTOMATICO
        $query_message = "SELECT * FROM automated_messages ORDER BY id DESC LIMIT 1";
        $run_query_message = mysqli_query($connection, $query_message);
        $row_message = mysqli_fetch_array($run_query_message);
        $msg = $row_message['message'];

        
        //$today = date("Y-m-d");
        $date = date('Y-m-d', strtotime("+1 day"));


        //$query = "SELECT * FROM incoming_log LEFT JOIN users ON incoming_log.responsible_dept_id = users.department_id WHERE out_quarantine = 0 AND received = 1 AND date_end < '$today' AND scale1 = 0 ;";
        //$query = "SELECT * FROM incoming_log LEFT JOIN users ON incoming_log.responsible_dept_id = users.department_id WHERE out_quarantine = 0 AND received = 0 AND date_end < '$today' AND incoming_log.scale1 = 0 AND users.scale1 = 1;";
        $query = "SELECT * FROM incoming_log WHERE out_quarantine = 0 AND received = 1 AND date_end < '$date' AND scale2 = 0 ;";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($result))
        {
            $user_query = "SELECT * FROM users WHERE department_id = {$row['responsible_dept_id']} AND scale2 = 1 ";
            $user_run = mysqli_query($connection, $user_query);
            while($user_row = mysqli_fetch_array($user_run))
            {
                $CC[] = $user_row['user_email'];
            }
            $email = "aavila@martechmedical.com";
            $title = "Late item Part: ".$row['part']." Lot: ".$row['lot'];
            $message = $msg."<br>"."<br>Late item Part: ".$row['part']."<br/>Lot: ".$row['lot']."<br>Responsible for material: ".$row['responsible']."<br>This is the second escalation alert";
            sendEmail($email, $title, $message, $CC);

            $update = "UPDATE incoming_log SET scale2 = 1 WHERE incoming_id = {$row['incoming_id']}";
            $run_update = mysqli_query($connection, $update);
            if(!$run_update)
            {
                echo "Error on run update";
            }
        }
    }





    function scale3()
    {    
        global $connection;

        //MENSAJE AUTOMATICO
        $query_message = "SELECT * FROM automated_messages ORDER BY id DESC LIMIT 1";
        $run_query_message = mysqli_query($connection, $query_message);
        $row_message = mysqli_fetch_array($run_query_message);
        $msg = $row_message['message'];

        
        //$today = date("Y-m-d");
        $date = date('Y-m-d', strtotime("+2 day"));


        //$query = "SELECT * FROM incoming_log LEFT JOIN users ON incoming_log.responsible_dept_id = users.department_id WHERE out_quarantine = 0 AND received = 1 AND date_end < '$today' AND scale1 = 0 ;";
        //$query = "SELECT * FROM incoming_log LEFT JOIN users ON incoming_log.responsible_dept_id = users.department_id WHERE out_quarantine = 0 AND received = 0 AND date_end < '$today' AND incoming_log.scale1 = 0 AND users.scale1 = 1;";
        $query = "SELECT * FROM incoming_log WHERE out_quarantine = 0 AND received = 1 AND date_end < '$date' AND scale3 = 0 ;";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($result))
        {
            $user_query = "SELECT * FROM users WHERE department_id = {$row['responsible_dept_id']} AND scale3 = 1 ";
            $user_run = mysqli_query($connection, $user_query);
            while($user_row = mysqli_fetch_array($user_run))
            {
                $CC[] = $user_row['user_email'];
            }
            $email = "aavila@martechmedical.com";
            $title = "Late item Part: ".$row['part']." Lot: ".$row['lot'];
            $message = $msg."<br>"."<br>Late item Part: ".$row['part']."<br/>Lot: ".$row['lot']."<br>Responsible for material: ".$row['responsible']."<br>This is the third escalation alert";
            sendEmail($email, $title, $message, $CC);

            $update = "UPDATE incoming_log SET scale3 = 1 WHERE incoming_id = {$row['incoming_id']}";
            $run_update = mysqli_query($connection, $update);
            if(!$run_update)
            {
                echo "Error on run update";
            }
        }
    }






    function scale4()
    {    
        global $connection;

        //MENSAJE AUTOMATICO
        $query_message = "SELECT * FROM automated_messages ORDER BY id DESC LIMIT 1";
        $run_query_message = mysqli_query($connection, $query_message);
        $row_message = mysqli_fetch_array($run_query_message);
        $msg = $row_message['message'];

        
        //$today = date("Y-m-d");
        $date = date('Y-m-d', strtotime("+3 day"));


        //$query = "SELECT * FROM incoming_log LEFT JOIN users ON incoming_log.responsible_dept_id = users.department_id WHERE out_quarantine = 0 AND received = 1 AND date_end < '$today' AND scale1 = 0 ;";
        //$query = "SELECT * FROM incoming_log LEFT JOIN users ON incoming_log.responsible_dept_id = users.department_id WHERE out_quarantine = 0 AND received = 0 AND date_end < '$today' AND incoming_log.scale1 = 0 AND users.scale1 = 1;";
        $query = "SELECT * FROM incoming_log WHERE out_quarantine = 0 AND received = 1 AND date_end < '$date' AND scale4 = 0 ;";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($result))
        {
            $user_query = "SELECT * FROM users WHERE department_id = {$row['responsible_dept_id']} AND scale4 = 1 ";
            $user_run = mysqli_query($connection, $user_query);
            while($user_row = mysqli_fetch_array($user_run))
            {
                $CC[] = $user_row['user_email'];
            }
            $email = "aavila@martechmedical.com";
            $title = "Late item Part: ".$row['part']." Lot: ".$row['lot'];
            $message = $msg."<br>"."<br>Late item Part: ".$row['part']."<br/>Lot: ".$row['lot']."<br>Responsible for material: ".$row['responsible']."<br>This is the fourth escalation alert";
            sendEmail($email, $title, $message, $CC);

            $update = "UPDATE incoming_log SET scale4 = 1 WHERE incoming_id = {$row['incoming_id']}";
            $run_update = mysqli_query($connection, $update);
            if(!$run_update)
            {
                echo "Error on run update";
            }
        }
    }





    function scale5()
    {    
        global $connection;

        //MENSAJE AUTOMATICO
        $query_message = "SELECT * FROM automated_messages ORDER BY id DESC LIMIT 1";
        $run_query_message = mysqli_query($connection, $query_message);
        $row_message = mysqli_fetch_array($run_query_message);
        $msg = $row_message['message'];

        
        //$today = date("Y-m-d");
        $date = date('Y-m-d', strtotime("+4 day"));


        //$query = "SELECT * FROM incoming_log LEFT JOIN users ON incoming_log.responsible_dept_id = users.department_id WHERE out_quarantine = 0 AND received = 1 AND date_end < '$today' AND scale1 = 0 ;";
        //$query = "SELECT * FROM incoming_log LEFT JOIN users ON incoming_log.responsible_dept_id = users.department_id WHERE out_quarantine = 0 AND received = 0 AND date_end < '$today' AND incoming_log.scale1 = 0 AND users.scale1 = 1;";
        $query = "SELECT * FROM incoming_log WHERE out_quarantine = 0 AND received = 1 AND date_end < '$date' AND scale5 = 0 ;";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($result))
        {
            $user_query = "SELECT * FROM users WHERE department_id = {$row['responsible_dept_id']} AND scale5 = 1 ";
            $user_run = mysqli_query($connection, $user_query);
            while($user_row = mysqli_fetch_array($user_run))
            {
                $CC[] = $user_row['user_email'];
            }
            $email = "aavila@martechmedical.com";
            $title = "Late item Part: ".$row['part']." Lot: ".$row['lot'];
            $message = $msg."<br>"."<br>Late item Part: ".$row['part']."<br/>Lot: ".$row['lot']."<br>Responsible for material: ".$row['responsible']."<br>This is the fifth escalation alert";
            sendEmail($email, $title, $message, $CC);

            $update = "UPDATE incoming_log SET scale5 = 1 WHERE incoming_id = {$row['incoming_id']}";
            $run_update = mysqli_query($connection, $update);
            if(!$run_update)
            {
                echo "Error on run update";
            }
        }
    }







    function sendEmail($email, $title, $message, $CC = array())
    {
        global $connection;
        // Load Composer's autoloader
        require 'mail/vendor/autoload.php';

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try 
        {    
            //Server settings
            $mail->SMTPDebug  = 0;                                                // Enable verbose debug output con 2
            $mail->isSMTP();                                                      // Set mailer to use SMTP
            $mail->Host       = 'mail.martechsender.com;mail.martechsender.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                             // Enable SMTP authentication
            $mail->Username   = 'quarantine@martechsender.com';                      // SMTP username
            $mail->Password   = 'quarantine2020';                                 // SMTP password
            $mail->SMTPSecure = 'tls';                                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                              

            //Recipients
            $mail->setFrom('noreply@martechsender.com', 'Quarantine system');
            $mail->addAddress($email);                                            // Add a recipient
            //$mail->addCC($email);

            // Content
            $mail->isHTML(true);                                                 // Set email format to HTML
            $mail->Subject = $title;
            $mail->Body    = $message;

            if(count($CC) > 0)
            {
                foreach($CC as $user)
                {
                    $mail->addCC($user);
                }
            }
            
            /*
            if(count($attach) > 0)
            {
                foreach($attach as $file)
                {
                    try{
                        $mail->addAttachment("../".$file);
                    }
                    catch(Exception $e){
                        $mail->addAttachment($file);
                    }
                }
            }
            */
            
            
            $mail->send();
            
        } catch (Exception $e) 
        {   
            echo "Can't send the email.";
        }   
    }


    scale1();
    scale2();