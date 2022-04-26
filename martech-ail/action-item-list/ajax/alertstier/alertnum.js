function showNum(data)
{
    $.ajax({
        data: data,
        type: "post",
        url: "functions/alertstier/alertnum.php",
        complete: function(data) 
        {
            //console.log(data);
            //$("#alert-num").text(data.responseText);
        },
        success: function(data) {
            //console.log(data)
            $("#alert-num2").text(data);
        },
    });
}

showNum();
