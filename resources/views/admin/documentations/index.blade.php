@extends('layouts.admin')

@section('content')
    <div class="card">
        <form action="{{ route('documentations.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <input type="file" name="doc_img" id="doc-img" data-max-file-size="2M" data-show-errors="true" data-max-file-size-preview="2M">
                <input type="text" name="caption" id="caption">
            </div>
            <div class="card-footer">
                <input type="submit" value="Save" class="btn btn-primary btn-sm">
            </div>
        </form>
        @if(isset($uploadSuccess))
            <div class="alert alert-success">
                <strong>Upload successful:</strong> {{$uploadSuccess}}
            </div>
        @endif
    </div>

    @include('admin.documentations.partials._scripts')
@endsection
