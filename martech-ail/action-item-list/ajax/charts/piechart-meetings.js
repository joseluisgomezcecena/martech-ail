function get_graph() {
    var ctx = document.getElementById('myChartMeeting').getContext("2d");
    var meeting = getUrlParameter('meeting_id');   
    const url = "http://mxmtsvrandon1/tracker/martech-ail/action-item-list/functions/charts/meetings.php?meeting_id="+meeting;

    $.ajax({
        type: 'GET',
        url: url,
        success: function (html) {
            let aux = JSON.parse(html);
            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['In process', 'Completed'],
                    datasets: [{
                        label: 'Completed Percentage',
                        data: aux,
                        backgroundColor: ['#26A69A', '#6200EA'],
                    }],
                },
            });
        },
        error: function (error) {
            console.log(error);
        }
    });
}

get_graph();