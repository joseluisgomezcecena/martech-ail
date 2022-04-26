function showNum(data)
{
    $.ajax({
        data: data,
        type: "post",
        url: "functions/alerts/alerttext.php",
        complete: function(data) 
        {
            //console.log(data);
            //$("#alert-num").text(data.responseText);
        },
        success: function(data) {
            //console.log(data)
            $("#alert-text").html(data);
        },
    });
}

showNum();
