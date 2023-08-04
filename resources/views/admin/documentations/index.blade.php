@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8 col-12">
                    <h3>Documentations</h3>
                </div>
                <div class="col-md-4 col-12">
                    <button class="btn btn-primary btn-sm btn-block" data-bs-toggle="modal" data-bs-target="#newDocumentation">
                        New Documentation
                    </button>
                </div>
            </div>     
        </div>
        
            <div class="card-body row">
                @if(isset($docs) && $docs->count() > 0)
                    @foreach ($docs as $doc)
                        <div class="col-md-3 col-sm-4 col-12 shadow-sm position-static mt-3">
                            <a href="{{ asset('storage/uploads/images/'.$doc->image) }}" data-lightbox="lightbox-img" data-title="{{ $doc->caption }}" data-alt="{{ $doc->caption }}">
                                <img src="{{ asset('storage/uploads/images/'.$doc->image) }}" alt="{{ $doc->caption }}" class="img-fluid">
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-danger">Sorry, there are no files or documentations at the moment</div>
                @endif
            </div>
        
        {{-- @if(isset($uploadSuccess))
            <div class="alert alert-success">
                <strong>Upload successful:</strong> {{$uploadSuccess}}
            </div>
        @endif --}}
    </div>
    
    @include('admin.documentations.partials._modal')
@endsection
