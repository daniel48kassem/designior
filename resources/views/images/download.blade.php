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
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('problems.edit', $problem->id) }}" class="btn btn-xs btn-info pull-right">
                            <button type="submit" class="btn btn-success">
                                Upload
                            </button>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
