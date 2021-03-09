$(document).ready(function() {

    let domains = [];
    $.ajax({
        url:"/api/domain/"+id,
        method:"DELETE",
        success:function(data) {
            domains = data;
            console.log(domains);
        },
        error:function() {
            alert("Load logos error");
        }
    })



    /*$("#domain-table").on('click', '.delete', function(){
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
    });*/

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
