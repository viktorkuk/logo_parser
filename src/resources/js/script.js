$(document).ready(function() {

    //let domains = [];
    const imageRenderColors = [0,128,255];
    const arrayChank = 10;

    loadDomains();
    updateStat();

    function loadDomains() {
        $.ajax({
            url: "/api/domains",
            method: "GET",
            success: function (data) {
                loadLogos(data);
                console.log(data);
            },
            error: function () {
                alert("Load logos error");
            }
        });
    }

    function updateStat() {
        $.ajax({
            url:"/api/stat",
            method: "GET",
            success:function(data) {
                for (const [key, metric] of Object.entries(data)) {
                    console.log(`${key}: ${metric}`);
                    $('#parse_' + key).html(metric);
                }
            }
        })
    }

    function loadLogos(data) {
        data.forEach(function (domain, key) {
            $.ajax({
                url:"/api/logos/" + encodeURI(domain),
                method: "GET",
                success:function(images) {
                    console.log(domain, images);
                    renderResults(domain, images);
                    updateStat();
                },
                error:function() {
                    console.log("Load logos error for: ".domain);
                }
            })
        });

    }

    function renderResults(domain, images) {

        let clone = $('#item_blueprint').clone();
        let itemId = "#item_" + domain;
        clone.attr('id', itemId);
        clone.find('.domain_link').attr('href', 'http://'+domain).html(domain);
        clone.find('.image_table_cont').html('');
        if (images.length) {
            images.forEach(function (item, key) {
                let table = $('#item_blueprint .image_table').clone();
                table.find('.logo_type').html(item.type);
                table.find('.logo_src').attr('src', item.src);


                table.find('.imageList').html('');

                imageRenderColors.forEach(function (color) {
                    let renderCont = $('#item_blueprint #logo_parsed_image_cont').clone();
                    renderCont.attr('id','');
                    renderCont.find('.logo_parsed_image_link').attr('href', '/download_logo?url=' + item.src + '&color=' + color + '&name=' + domain);
                    renderCont.find('.logo_parsed_image_src').attr('src', '/get_logo?url=' + item.src + '&color=' + color);
                    table.find('.imageList').append(renderCont);
                })

                clone.find('.image_table_cont').append(table);
            });
        } else {
            clone.find('.image_table_cont').hide();
            clone.find('.no_images').show();
        }

        $('#domains_list').append(clone).fadeIn(1000);
        //$(itemId)
    }

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
