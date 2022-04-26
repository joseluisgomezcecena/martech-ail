<?php

function addSop() 
{
    global $connection;

    if(isset($_POST['add_sop']))
    {
        $op_id      = $_GET['op_id'];
        $sop_id     = $_POST['sop_id'];
        $sop_name   = $_POST['sop_name'];
        
        $query = "INSERT INTO sop_operation (ops_id, sop_nombre) VALUES ('$op_id', '$sop_name')";
        $result = mysqli_query($connection, $query);
        if(!$result)
        {
            echo "Error al agregar SOP :(";
        }
    }
}