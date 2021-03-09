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
        </div>

        <div class="col-md-2" align="right">
            @if ($domains ?? '')
                <span style="color: #2a9055">Parsed: {{ $parseSuccess }}</span> / <span style="color: #c51f1a"> Error: {{ $parseError }}</span><br>
                Total: {{ $domains->total() }}
            @endif
        </div>
    </div>
    <div class="row" style="margin-bottom: 50px;">
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
        @endif


</div>


@endsection
