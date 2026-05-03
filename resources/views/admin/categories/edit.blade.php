@extends('adminlte::page')

@section('title', 'Edit Category')

@section('content_header')
    <h1>Edit Category</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Update Category</h3>
    </div>

    <form action="{{ url('/admin/categories/update/'.$category->id) }}" method="POST">
        @csrf

        <div class="card-body">

            <!-- Name -->
            <div class="form-group">
                <label>Category Name</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    value="{{ $category->name }}"
                    required
                >
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

               <div class="form-group">
                <label>Category Icon</label>
                 <select name="icon" id="category" class="form-control" required>
                        <option value="">-- Select Icon --</option>

                        <option value="fa-laptop-code" {{ isset($category) && $category->icon == 'fa-laptop-code' ? 'selected' : '' }}>
                            fa-laptop-code (IT / Software)
                        </option>

                        <option value="fa-code" {{ isset($category) && $category->icon == 'fa-code' ? 'selected' : '' }}>
                            fa-code (Developer)
                        </option>

                        <option value="fa-palette" {{ isset($category) && $category->icon == 'fa-palette' ? 'selected' : '' }}>
                            fa-palette (Web Designer)
                        </option>

                        <option value="fa-chart-line" {{ isset($category) && $category->icon == 'fa-chart-line' ? 'selected' : '' }}>
                            fa-chart-line (Data Analyst)
                        </option>

                        <option value="fa-bullhorn" {{ isset($category) && $category->icon == 'fa-bullhorn' ? 'selected' : '' }}>
                            fa-bullhorn (Marketing)
                        </option>

                        <option value="fa-sack-dollar" {{ isset($category) && $category->icon == 'fa-sack-dollar' ? 'selected' : '' }}>
                            fa-sack-dollar (Sales)
                        </option>

                        <option value="fa-users" {{ isset($category) && $category->icon == 'fa-users' ? 'selected' : '' }}>
                            fa-users (HR)
                        </option>

                        <option value="fa-building-columns" {{ isset($category) && $category->icon == 'fa-building-columns' ? 'selected' : '' }}>
                            fa-building-columns (Finance)
                        </option>

                        <option value="fa-file-invoice-dollar" {{ isset($category) && $category->icon == 'fa-file-invoice-dollar' ? 'selected' : '' }}>
                            fa-file-invoice-dollar (Accounting)
                        </option>

                        <option value="fa-headset" {{ isset($category) && $category->icon == 'fa-headset' ? 'selected' : '' }}>
                            fa-headset (Customer Support)
                        </option>

                        <option value="fa-pen-nib" {{ isset($category) && $category->icon == 'fa-pen-nib' ? 'selected' : '' }}>
                            fa-pen-nib (Content Writer)
                        </option>

                        <option value="fa-graduation-cap" {{ isset($category) && $category->icon == 'fa-graduation-cap' ? 'selected' : '' }}>
                            fa-graduation-cap (Education)
                        </option>

                        <option value="fa-hospital" {{ isset($category) && $category->icon == 'fa-hospital' ? 'selected' : '' }}>
                            fa-hospital (Healthcare)
                        </option>

                        <option value="fa-user-nurse" {{ isset($category) && $category->icon == 'fa-user-nurse' ? 'selected' : '' }}>
                            fa-user-nurse (Nurse)
                        </option>

                        <option value="fa-user-doctor" {{ isset($category) && $category->icon == 'fa-user-doctor' ? 'selected' : '' }}>
                            fa-user-doctor (Doctor)
                        </option>

                        <option value="fa-gears" {{ isset($category) && $category->icon == 'fa-gears' ? 'selected' : '' }}>
                            fa-gears (Engineering)
                        </option>

                        <option value="fa-helmet-safety" {{ isset($category) && $category->icon == 'fa-helmet-safety' ? 'selected' : '' }}>
                            fa-helmet-safety (Construction)
                        </option>

                        <option value="fa-truck" {{ isset($category) && $category->icon == 'fa-truck' ? 'selected' : '' }}>
                            fa-truck (Logistics)
                        </option>

                        <option value="fa-shield-halved" {{ isset($category) && $category->icon == 'fa-shield-halved' ? 'selected' : '' }}>
                            fa-shield-halved (Security)
                        </option>

                        <option value="fa-scale-balanced" {{ isset($category) && $category->icon == 'fa-scale-balanced' ? 'selected' : '' }}>
                            fa-scale-balanced (Legal)
                        </option>

                        <option value="fa-briefcase" {{ isset($category) && $category->icon == 'fa-briefcase' ? 'selected' : '' }}>
                            fa-briefcase (Admin / Office)
                        </option>

                        <option value="fa-globe" {{ isset($category) && $category->icon == 'fa-globe' ? 'selected' : '' }}>
                            fa-globe (Freelance)
                        </option>

                        <option value="fa-house-laptop" {{ isset($category) && $category->icon == 'fa-house-laptop' ? 'selected' : '' }}>
                            fa-house-laptop (Remote Jobs)
                        </option>

                    </select>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label>Description</label>
                <textarea 
                    name="description" 
                    class="form-control" 
                    rows="4"
                >{{ $category->description }}</textarea>

                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                Update Category
            </button>

            <a href="{{ url('/admin/categories') }}" class="btn btn-secondary">
                Back
            </a>
        </div>

    </form>
</div>

@stop