@extends('layout.bootstrap')


@section('content')

    <div class="row h-100 justify-content-center align-items-center">
        <div class="nauk-info-connections">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Error!</h4>
            </div>
        </div>
    </div>


    <script>
        setInterval( function () {
            window.location.href='https://google.com';
        }, 5000 );
    </script>
@endsection
