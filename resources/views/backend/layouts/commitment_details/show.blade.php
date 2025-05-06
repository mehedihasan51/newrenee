@extends('backend.app', ['title' => 'Show Post'])

@section('content')

<!--app-content open-->
<div class="app-content main-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <div class="page-header">
                <div>
                    <h1 class="page-title">Commitment Details</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Commitment_Details</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card post-sales-main">
                        <div class="card-header border-bottom">
                            <h3 class="card-title mb-0">{{ Str::limit($CommitmentDetail->title, 50) }}</h3>
                            <div class="card-options">
                                <a href="javascript:window.history.back()" class="btn btn-sm btn-primary">Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Title</th>
                                    <td>{{ $CommitmentDetail->title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Commitment</th>
                                    <td> <a href="{{ route('admin.commitment_detail.show', $CommitmentDetail->commitment->id) }}">{{ $CommitmentDetail->commitment->name }}</a></td>
                                </tr>
                                <tr>
                                    <th>Images</th>
                                    <td>
                                        @if($post->images)
                                        @foreach ($post->images as $image)
                                        <a href="{{ asset($image->path ?? 'default/logo.png') }}" target="_blank"><img src="{{ asset($image->path ?? 'default/logo.png') }}" class="img-fluid" alt="post image" width="50" height="50"></a>
                                        @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Content</th>
                                    <td>{!! $CommitmentDetail->content ?? 'N/A' !!}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $CommitmentDetail->created_at ? $CommitmentDetail->created_at : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $CommitmentDetail->updated_at ? $CommitmentDetail->updated_at : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Action</th>
                                    <td>
                                        <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                                        <a href="{{ route('admin.post.destroy', $post->id) }}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div><!-- COL END -->
            </div>

        </div>
    </div>
</div>
<!-- CONTAINER CLOSED -->
@endsection
@push('scripts')

@endpush