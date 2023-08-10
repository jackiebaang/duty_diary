@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-4 col-12 p-5">
                @if ($profile->img == Null)
                    <img src="{{ asset('assets/images/user-placeholder.png') }}" alt="Profile Image Placeholder" class="rounded-circle img-fluid item-hover" id="editProfilePic" data-id="{{$profile->id}}">    
                @else
                <img src="{{ asset('storage/'.$profile->img) }}" alt="Profile Image Placeholder" class="rounded-circle img-fluid item-hover" id="editProfilePic" data-id="{{$profile->id}}">
                @endif
            </div>
            <div class="col-md-8 col-12">
                <div class="card d-flex border-0">
                    <div class="card-body">
                        <h1 class="mt-5 editName item-hover" id="editName">{{ $profile->name }}</h1>
                        <form action="{{ route('users.updateProfileName', $profile->id) }}" method="post" id="update-profile-name-form">
                            @csrf
                            <input type="text" name="name" id="name-input" class="form-control d-none" value="{{ $profile->name }}">
                            @method('PUT')
                        </form>
                        @if ($profile->role == 1)
                            <p class="badge badge-lg badge-primary">Administrator</p>
                        @elseif($profile->role == 2)
                            <p class="badge badge-lg badge-success">Supervisor</p>
                        @else
                            <p class="badge badge-lg badge-warning">Trainee</p>
                        @endif
                        <div class="d-flex mt-5">
                            @if ($profile->signature == Null)
                                <img src="{{ asset('assets/images/sign-placeholder.png') }}" alt="Profile Image Placeholder" class="rounded-circle img-fluid item-hover" id="editSignature" data-id="{{$profile->id}}">    
                            @else
                                <img src="{{ asset('storage/'.$profile->signature) }}" alt="Profile Image Placeholder" class="rounded-circle img-fluid item-hover" id="editSignature" data-id="{{$profile->id}}" width="50%">    
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.profile.partials._profile-pic-modal')
    @include('admin.profile.partials._signature-modal')
    @include('admin.profile.partials._scripts')
@endsection
