<?php

function removeSop() 
{
    global $connection;

    if(isset($_POST['remove_sop']))
    {
        $op_id      = $_GET['op_id'];
        $so_id     = $_POST['so_id'];
        //$sop_name   = $_POST['sop_name'];
        
        $query = "DELETE FROM  sop_operation WHERE so_id = $so_id";
        $result = mysqli_query($connection, $query);
        if(!$result)
        {
            echo "Error al eliminar SOP :(";
        }
    }
}