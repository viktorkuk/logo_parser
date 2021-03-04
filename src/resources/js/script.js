$(document).ready(function() {
    /*const clicksTable = $('#clicks-table').DataTable( {
        "ajax": {
            "url": "/api/clicks/",
            "dataSrc": ""
        },

        "columns": [
            { "data": "id" },
            { "data": "ua" },
            { "data": "ip" },
            { "data": "ref" },
            { "data": "param1" },
            { "data": "param2" },
            { "data": "error" },
            { "data": "bad_domain" }
        ]
    } );

    const domainTable = $('#domain-table').DataTable( {
        "ajax": {
            "url": "/api/domains/",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            {
                "data": null,
                "defaultContent": '<button type="button" name="delete" class="btn btn-danger btn-xs delete">Delete</button>',
                "className": 'dt-body-right',
                "orderable":false,
            },
        ],
    } );

    setInterval( function () {
        clicksTable.ajax.reload(null, false );
    }, 5000 );*/





    $("#domain-table").on('click', '.delete', function(){
        let id = domainTable.row( $(this).parents('tr') ).data().id;
        if(confirm("Are you sure you want to delete this domain?")) {
            $.ajax({
                url:"/api/domain/"+id,
                method:"DELETE",
                success:function(data) {
                    resetForm();
                    domainTable.ajax.reload(null, false );
                },
                error:function() {
                    resetForm();
                    alert( "Delete error" );
                }
            })
        } else {
            return false;
        }
    });

    $('#addDomain').click(function(){
        $('#domainModal').modal('show');
        $('#recordForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Domain");
        $('#action').val('addRecord');
        $('#save').val('Add');
    });

    $("#domainModal").on('submit','#domainForm', function(event){
        event.preventDefault();
        $('#save').attr('disabled','disabled');
        let formData = $(this).serialize();
        $.ajax({
            url:"/api/domain",
            method:"POST",
            data:formData,
            success:function(data){
                resetForm();
                domainTable.ajax.reload(null, false );
            },
            error:function() {
                resetForm();
                alert( "Add error" );
            }
        })
    });

    const resetForm = function (){
        $('#domainForm')[0].reset();
        $('#domainModal').modal('hide');
        $('#save').attr('disabled', false);
    }

} );
