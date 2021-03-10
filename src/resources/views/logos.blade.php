@extends('layout.bootstrap')

@section('js_scripts')
    <script src="{{ asset('js/script.js') }}" ></script>
@endsection

@section('content')

    <!-- Modal -->
    <div id="domainModal" class="modal fade">
        <div class="modal-dialog">
            <form enctype="multipart/form-data" method="post" id="domainForm1" action="{{ route('parser_csv_upload') }}" >
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title"><i
                                class="fa fa-plus"></i> Upload Csv
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">

                            <label for="csv_file" class="control-label">Select csv file</label>
                            <input type="file" class="form-control-file"
                                   id="csv_file" name="csv_file" placeholder="Csv" required>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="save" id="save"
                               class="btn btn-info" value="Upload" />
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($errors->any())
        @foreach ($errors->all() as $error)
        <div class="row" style="margin-bottom: 50px; margin-top: 20px;">
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
        </div>
        @endforeach
    @endif

    <div class="row" style="margin-bottom: 50px; margin-top: 20px;">
        <div class="col-8">
            <a href="{{ route('home') }}" >
                <h2>Domains</h2>
            </a>
        </div>

        <div class="col-md-2" align="right">
            <button type="button" name="add" id="addDomain" class="btn btn-success">Load csv</button>
            <button type="button" onclick="location.href='{{ route('reset') }}'" class="btn btn-danger">Reset</button>
        </div>

        <div class="col-md-2" align="right">
            <span style="color: #2a9055">Parsed: <span id="parse_success">0</span></span> / <span style="color: #c51f1a"> Error: <span id="parse_error">0</span></span><br>
            Total: <span id="parse_total">0</span> / CSV: <span id="parse_csv">0</span>
        </div>
    </div>
    <div class="row" id="domains_list" style="">
        <!-- Ajax content here -->
    </div>


    {{--<div class="row" style="margin-bottom: 50px;">
        @if ($domainLogos ?? '')
            <div class="col-12">
                {{ $domains->links() }}
            </div>
            @foreach ($domainLogos as $domain => $logos)
                <div class="col-12"  style="margin-bottom: 50px;">
                    <h2><a target="_blank" href="http://{{ $domain }}">{{ $domain }}</a></h2>
                    @if ($logos)
                    <table  class="table table-striped" style="width:100%">
                        @foreach ($logos as $logo)
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="3">Original</th>
                            </tr>
                        </thead>
                        <tbody >
                            <tr>
                                <td colspan="3" style="align-content: center; background-color: #888888;">
                                    <h3>Type: {{ $logo['type'] }}</h3>
                                    <img src="{{ $logo['src'] }}" style="max-width: 1050px;">
                                </td>
                            </tr>
                        </tbody>
                        <thead class="thead-light">
                        <tr>
                            <th colspan="3">Converted</th>
                        </tr>
                        </thead>
                            <tr>
                                @foreach([0,128,255] as $color )
                                    <td style="background-color: white">
                                        <a href="{{ route('download_logo', ['url' => urlencode($logo['src']), 'color' => $color,  'name' => $domain ]) }}">
                                            <img src="{{ route('get_logo', ['url' => urlencode($logo['src']), 'color' => $color ]) }}" style="max-width: 350px; border: #c51f1a 1px solid;"><br>
                                        </a>
                                        <br>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                    @else
                        <div class="col-md-12">
                            <h3>No content</h3>
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="col-12">
                {{ $domains->links() }}
            </div>
        @else
            <div class="col-12">
                <h2>Load some csv data first!</h2>
            </div>
        @endif --}}


        <div style="display: none" class="">
            <div class="col-12"  style="margin-bottom: 50px;" id="item_blueprint">
                <h1><a class="domain_link" target="_blank" href=""></a></h1>
                <div class="image_table_cont">
                    <table  class="table table-striped image_table" style="width:100%">
                            <thead class="thead-dark">
                            <tr>
                                <th colspan="3">Original</th>
                            </tr>
                            </thead>
                            <tbody >
                            <tr>
                                <td colspan="3" style="align-content: center; background-color: #888888;">
                                    <h3>Type: <span class="logo_type"></span></h3>
                                    <img class="logo_src" src="" style="max-width: 1050px;">
                                </td>
                            </tr>
                            </tbody>
                            <thead class="thead-light">
                            <tr>
                                <th colspan="3">Converted</th>
                            </tr>
                            </thead>
                            <tr class="imageList">
                                <td style="background-color: white" id="logo_parsed_image_cont">
                                    <a class="logo_parsed_image_link" href="">
                                        <img class="logo_parsed_image_src" src="" style="max-width: 350px; border: #c51f1a 1px solid;"><br>
                                    </a>
                                    <br>
                                </td>
                            </tr>
                    </table>
                </div>
                <div class="col-md-12 no_images" style="display: none;">
                    <h3>No content</h3>
                </div>
            </div>
        </div>
</div>


@endsection
