function showGraph()
        {
            var project = getUrlParameter('tier_id');   
            var area    = getUrlParameter('area_id');
            $.ajax({
                url:"functions/charts/tier.php?tier_id="+project+"&area_id="+area,
                method:"GET",
                success:function(data)  {
                console.log(data);
                var malenum =[];
                var femalenum =[];
                
                

                malenum.push(data[0]);
                femalenum.push(data[1]);

                
                
                var ctx = document.getElementById("myChartTier");
                var myChart = new Chart(ctx, {
                  type: 'pie',
                  data: {
                      labels: ["Pending","Completed"],
                    datasets: [{
                        label: 'Completed Percentage',
                        data: [malenum,femalenum],
                        backgroundColor: [
                            '#fc4d32',
                            '#32b9fc'
                            
                        ],
                        hoverBackgroundColor: [
                            '#c20808',
                            '#0093f5'
                            
                        ],

                        borderColor: [
                            '#fc4d32',
                            '#32b9fc'
                        ],
                        borderWidth: 1
                    }]
                },
                
                });
                
                },
                error:function(data){
                    console.log(data);
                }
                });
            
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
