@extends('backend.app', ['title' => 'Cteate Category'])

@section('content')

<!--app-content open-->
<div class="app-content main-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <div class="page-header">
                <div>
                    <h1 class="page-title">Create Executive</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Executive</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>

            <div class="row" id="user-profile">
                <div class="col-lg-12">

                    <div class="tab-content">
                        <div class="tab-pane active show" id="editProfile">
                            <div class="card">
                                <div class="card-body border-0">
                                    <form class="form-horizontal" method="post" action="{{ route('admin.commitment_detail.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-4">

                                            <div class="col-lg-6">
                                                
                                            <div class="form-group">
                                                <label for="title" class="form-label">Commitment Details Title :</label>
                                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Title" id="" value="{{ old('title') }}">
                                                @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="commitment_id" class="form-label">Category:</label>
                                                    <select class="form-control @error('commitment_id') is-invalid @enderror" name="commitment_id" id="commitment_id">
                                                        <option value="">Select a Category ID</option>
                                                        @if(!empty($commitments) && $commitments->count() > 0)
                                                        @foreach($commitments as $item)
                                                        <option value="{{ $item->id }}" {{ old('item') == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                                        @endforeach
                                                        @endif
                                                        
                                                    </select>
                                                    @error('commitment_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            
                                            {{-- description --}}

                                            <div class="form-group mb-4">
                                                <label for="description" class="form-label">Description:</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Description" id="" rows="5">{{ old('description') }}</textarea>
                                                @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- sub des --}}

                                            <div class="form-group">
                                                <label for="image" class="form-label">Image:</label>
                                                <input type="file" class="dropify form-control @error('image') is-invalid @enderror" name="image" id="image">
                                                @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit">Submit</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- CONTAINER CLOSED -->
@endsection
@push('scripts')



@endpush