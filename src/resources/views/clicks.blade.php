@extends('layout.bootstrap')

@section('js_scripts')
    <script src="{{ asset('js/click.js') }}" ></script>
@endsection

@section('content')

    <!-- Modal -->
    <div id="domainModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="domainForm">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title"><i
                                class="fa fa-plus"></i> Add Domain
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">Name</label>

                            <input type="text" class="form-control"
                                   id="name" name="name" placeholder="Name" required>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="save" id="save"
                               class="btn btn-info" value="Save" />
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row" style="margin-bottom: 50px; margin-top: 20px;">
        <div class="col-12">
            <h2>Test Link:
                <a id="click_link" href="{{ route('record_click').'?param1='.random_int(1,1000).'&param2='.random_int(1,1000) }}" target="_blank">
                    Click
                </a>
            </h2>
        </div>
    </div>

    <script>
        setInterval( function () {
            $('#click_link').attr('href','{{ route('record_click') }}?param1='+ Math.floor(Math.random() * 1000) + '&param2=' + Math.floor(Math.random() * 1000));
        }, 1000 );
    </script>

    <div class="row" style="margin-bottom: 50px">
        <div class="col-12">
            <h2>Clicks</h2>
        </div>
        <div class="col-12">
            <table id="clicks-table" class="display dataTable table table-striped" style="width:100%">
                <thead class="thead-dark">
                <tr>
                    <th>Id</th>
                    <th>UA</th>
                    <th>IP</th>
                    <th>REF.</th>
                    <th>Param1</th>
                    <th>Param2</th>
                    <th>Error</th>
                    <th>BadDomain</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="row" >
        <div class="col-10">
            <h2>Domains</h2>
        </div>
        <div class="col-md-2" align="right">
            <button type="button" name="add" id="addDomain" class="btn btn-success">Add</button>
        </div>
    </div>
    <div class="row" style="margin-bottom: 50px;">
        <div class="col-12">
            <table id="domain-table" class="display dataTable table table-striped" style="width:100%">
                <thead class="thead-dark">
                <tr>
                    <th>Id</th>
                    <th>Domain</th>
                    <th class="dt-right">Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>



@endsection
