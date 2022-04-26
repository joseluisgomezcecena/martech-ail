function showNum(data)
{
    $.ajax({
        data: data,
        type: "post",
        url: "functions/alerts/alertnum.php",
        complete: function(data) 
        {
            //console.log(data);
            //$("#alert-num").text(data.responseText);
        },
        success: function(data) {
            //console.log(data)
            $("#alert-num").text(data);
        },
    });
}

showNum();
