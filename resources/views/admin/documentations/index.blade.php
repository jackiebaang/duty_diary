@extends('layouts.admin')

@section('content')
    <div class="card">
        <form action="{{ route('documentations.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <input type="file" name="doc_img" id="doc-img">
                <input type="text" name="caption" id="caption">
            </div>
            <div class="card-footer">
                <input type="submit" value="Save">
            </div>
        </form>
        @if(isset($uploadSuccess))
            <div class="alert alert-success">
                <strong>Upload successful:</strong> {{$uploadSuccess}}
            </div>
        @endif
    </div>
@endsection
