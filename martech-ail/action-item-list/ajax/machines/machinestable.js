$(document).ready(function() {


    $('#machinestable').DataTable({
        'scrollX': true,
        //'bSort': false,
        //'scrollCollapse': true,

        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'functions/machines/view_machines.php'
        },
        'columns': [
            { data: 'machine_id' },
            { data: 'machine_category' },
            { data: 'machine_name' },
            { data: 'machine_control_number' },
            { data: 'machine_site' },
            { data: 'machine_area' },
            { data: 'machine_actions' },
        ]
    });
});

