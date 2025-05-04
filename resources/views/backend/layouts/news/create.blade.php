@extends('backend.app', ['title' => 'Cteate Category'])

@section('content')

<!--app-content open-->
<div class="app-content main-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <div class="page-header">
                <div>
                    <h1 class="page-title">News</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">News</a></li>
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
                                    <form class="form-horizontal" method="post" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-4">
                                            
                                            {{-- title --}}
                                            <div class="col-lg-6">
                                               
                                            <div class="form-group">
                                                <label for="username" class="form-label">Name :</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" id="" value="{{ old('name') }}">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            </div>

                                            <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="title" class="form-label">Title:</label>
                                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Title" id="" value="{{ old('title') }}">
                                                @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            </div>


                                            <div class="col-lg-6">
                                            <div class="form-group mt-3">
                                                <label for="news_type" class="form-label">News Type:</label>
                                                <select name="news_type" class="form-control @error('news_type') is-invalid @enderror" id="news_type">
                                                    <option value="">--Select News Type--</option>
                                                    <option value="normal" {{ old('news_type') == 'normal' ? 'selected' : '' }}>Normal</option>
                                                    <option value="live" {{ old('news_type') == 'live' ? 'selected' : '' }}>Live</option>
                                                </select>
                                                @error('news_type')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            </div>


                                            <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="username" class="form-label">Sub Title :</label>
                                                <input type="text" class="form-control @error('sub_title') is-invalid @enderror" name="sub_title" placeholder="Sub Title" id="" value="{{ old('sub_title') }}">
                                                @error('sub_title')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="description" class="form-label">Description:</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Description" id="" rows="5">{{ old('description') }}</textarea>
                                                @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

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