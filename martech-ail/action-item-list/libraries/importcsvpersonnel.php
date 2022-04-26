<?php
function importCsvPersonnel()
{
    global $connection;

    if(isset($_POST["submit_file"]))
    {


        $delete = "DELETE FROM personnel";
        $run_delete = mysqli_query($connection,$delete);
        
        $count = 0;

        if( count($_FILES['file']['name']) > 0 ) //If user insert a file we have to upload it
        {
            for( $index = 0; $index < count($_FILES['file']['name']); $index++ )
            {
                

                $file = $_FILES["file"]["tmp_name"][$index];                

                $file_open = fopen($file,"r");

                while(($csv = fgetcsv($file_open, 2000, ",")) !== false)
                {
                    //$file_clean = $_FILES["file"]["name"][$index];
                    $file_clean = $_FILES["file"]["name"][$index];
                    $file_clean = pathinfo($file_clean, PATHINFO_FILENAME);

                    

                    $p_numero               = mysqli_real_escape_string($connection,$csv[0]);
                    $p_nombre               = mysqli_real_escape_string($connection,$csv[1]);
                    $p_departamento         = mysqli_real_escape_string($connection,$csv[2]);
                    $p_supervisor           = mysqli_real_escape_string($connection,$csv[3]);
                    $p_planta               = mysqli_real_escape_string($connection,$csv[4]);
                    $p_puesto               = mysqli_real_escape_string($connection,$csv[5]);
                                        
                    if($count > 0 && $p_numero != "") 
                    {
                        $query = "INSERT INTO personnel (`p_numero`, `p_nombre`, `p_departamento`, `p_supervisor`, `p_planta`, `p_puesto`)   
                        VALUES('$p_numero','$p_nombre','$p_departamento','$p_supervisor','$p_planta','$p_puesto');";

                        $result = mysqli_query($connection, $query);

                        if(!$result)
                        {
                            
                            echo "Error: " .$connection->error;
                            echo "<br>Query: " .$query . "<br>";
                        }  
                    

                    }
                    $count ++;
                    
                }
            }    
        }
    }

}