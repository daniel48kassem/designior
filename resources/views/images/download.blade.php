@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2>Download image</h2>
            </div>

            <div class="panel-body">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ url('resize-image/'.$image->id.'?width=1280&height=720') }}" class="btn btn-xs btn-info pull-right">
                            Download 1280*720
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
