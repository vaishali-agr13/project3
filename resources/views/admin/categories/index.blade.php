@extends('adminlte::page')

@section('title', 'Category List')

@section('content_header')
    <h1>Category List</h1>
@stop

@section('content')

{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

            <form method="GET" action="{{ url()->current() }}" class="mb-3">
                <div class="row align-items-center">

                    {{-- 🔍 Search --}}
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control"
                            placeholder="Search by name"
                            value="{{ request('name') }}">
                    </div>

                    {{-- 🔘 Buttons --}}
                    <div class="col-md-4 d-flex">
                        <button type="submit" class="btn btn-primary mr-2">
                            Filter
                        </button>

                        <a href="{{ url()->current() }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Categories</h3>

        <div class="card-tools">
            <a href="{{ url('/admin/categories/create') }}" class="btn btn-primary btn-sm">
                + Add Category
            </a>
        </div>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Job Category</th>
                    <th>Job Description</th>
                    <th width="150">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $key => $cat)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $cat->name }}</td>
                        <td>{!! \Illuminate\Support\Str::limit($cat->description, 10, '...') !!}</td>
                        <td>
                        <a href="{{ url('/admin/categories/edit/'.$cat->id) }}" class="btn btn-sm btn-success">
                            Edit
                        </a>                            
                        <form action="{{ url('/admin/categories/delete/'.$cat->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No Categories Found</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

@stop

@section('js')
<script>
    setTimeout(function () {
        let alert = document.querySelector('.alert');
        if (alert) {
            alert.style.transition = "opacity 0.5s";
            alert.style.opacity = "0";

            setTimeout(() => {
                alert.remove();
            }, 500);
        }
    }, 3000);
</script>
@stop