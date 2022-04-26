function showGraph()
        {
            
            {

                var action = getUrlParameter('action_id');
                $.post("functions/charts/tier_actions.php?action_id="+action,
                function (data)
                {
                    console.log(data);
                    var name = [];
                    var marks = [];

                    for (var i in data) {
                        name.push(data[i].user_name);
                        marks.push(data[i].cuenta);
                    }

                    var chartdata = {
                        labels: name,
                        scaleBeginAtZero : true,
                        ticks: { min: 0 },
                        datasets: [
                            {
                                label: 'Updates By User',
                                backgroundColor: '#03b7ff',
                                borderColor: '#000',
                                hoverBackgroundColor: '#0093f5',
                                hoverBorderColor: '#666666',
                                data: marks
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas2");

                    var barGraph = new Chart(graphTarget, {
                        type: 'pie',
                        data: chartdata,
                       
                    });
                });
            }
        }


        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;
        
            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');
        
                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        };
        
        //
        //alert(action);
       

        
        showGraph();
