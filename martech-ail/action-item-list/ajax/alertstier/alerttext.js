function showNum(data)
{
    $.ajax({
        data: data,
        type: "post",
        url: "functions/alertstier/alerttext.php",
        complete: function(data) 
        {
            //console.log(data);
            //$("#alert-num").text(data.responseText);
        },
        success: function(data) {
            //console.log(data)
            $("#alert-text2").html(data);
        },
    });
}

showNum();
