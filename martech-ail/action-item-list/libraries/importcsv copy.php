<?php
function importCsv()
{
    global $connection;

    if(isset($_POST["submit_file"]))
    {
        $date = date("y/m/d");

        echo count($_FILES['file']['name']);

        if( count($_FILES['file']['name']) > 0 ) //If user insert a file we have to upload it
        {
            for( $index = 0; $index < count($_FILES['file']['name']); $index++ )
            {
                $count = 0;

                $file = $_FILES["file"]["tmp_name"][$index];                

                $file_open = fopen($file,"r");

                while(($csv = fgetcsv($file_open, 2000, ",")) !== false)
                {
                    //$file_clean = $_FILES["file"]["name"][$index];
                    $file_clean = $_FILES["file"]["name"][$index];
                    $file_clean = pathinfo($file_clean, PATHINFO_FILENAME);

                    

                    if($count == 0)
                    {
                        $query_insert_name  = "INSERT INTO name_file(name_file) VALUES('$file_clean')";
                        $result_insert_name = $connection->query($query_insert_name);

                        if($result_insert_name)
                            $id = $connection->insert_id;

                        $count++;
                        continue;
                    }

                    $num_empleado    = mysqli_real_escape_string($connection,$csv[0]);
                    $nombre          = mysqli_real_escape_string($connection,$csv[1]);
                    $departamento    = mysqli_real_escape_string($connection,$csv[2]);
                    $turno           = mysqli_real_escape_string($connection,$csv[3]);
                    $rev             = mysqli_real_escape_string($connection,$csv[4]);
                    $rev_level       = mysqli_real_escape_string($connection,$csv[5]);
                    $date            = mysqli_real_escape_string($connection,$csv[6]);

                    
                    if($num_empleado != "")
                    {
                        $search = "SELECT * FROM file WHERE num_empleado = $num_empleado AND name_id = $id"; 
                        $run_search = mysqli_query($connection, $search);

                        if($run_search)
                        {
                            if(mysqli_num_rows($run_search) == 0)
                            {
                                $query = "INSERT INTO `file`(`num_empleado`, `nombre`, `departamento`, `turno`, `rev`, `rev_level`, `date`, name_id) 
                                        VALUES('$num_empleado','$nombre','$departamento','$turno','$rev','$rev_level','$date', $id);";

                                $result = mysqli_query($connection, $query);

                                if(!$result)
                                {
                                    echo "Error: " .$connection->error;
                                    echo "<br>Query: " .$query . "<br>";
                                }
                            }
                        }
                        else
                        {
                            echo "Error: " . $connection->error;
                            echo "<br>Query: " . $run_search . "<br>";
                        }

                        $count++;
                    }
                }
            }    
        }
    }

}