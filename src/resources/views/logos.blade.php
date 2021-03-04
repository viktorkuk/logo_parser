@extends('layout.bootstrap')

@section('js_scripts')
    <script src="{{ asset('js/click.js') }}" ></script>
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
        <div class="col-10">
            <h2>Domains</h2>
        </div>
        <div class="col-md-2" align="right">
            <button type="button" name="add" id="addDomain" class="btn btn-success">Load csv</button>
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
                    <table  class="table table-striped" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Original</th>
                                <th>Converted</th>
                            </tr>
                        </thead>
                        <tbody >
                                @foreach ($logos as $logo)
                                <tr>
                                    <td style="background-color: #7c8386;" >
                                        <img src="{{ $logo }}" style="max-width: 400px;">
                                    </td>
                                    <td style="background-color: white">
                                        @foreach([0,128,255] as $color )
                                            <a href="{{ route('download_logo', ['url' => urlencode($logo), 'color' => $color,  'name' => $domain ]) }}">
                                                <img src="{{ route('get_logo', ['url' => urlencode($logo), 'color' => $color ]) }}" style="max-width: 400px;"><br>
                                            </a>
                                            <br>
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
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
