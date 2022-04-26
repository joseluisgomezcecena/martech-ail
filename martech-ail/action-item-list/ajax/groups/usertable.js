$(document).ready(function() {


    $('#app_groups').DataTable({
        'scrollX': true,
        //'bSort': false,
        //'scrollCollapse': true,

        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'functions/groups/view_groups.php'
        },
        'columns': [
            { data: 'group_id' },
            { data: 'group_name' },
            { data: 'group_count' },
        ]
    });
});

