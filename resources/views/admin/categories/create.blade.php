@extends('adminlte::page')

@section('title', 'Add Category')

@section('content_header')
    <h1>Add Category</h1>
@stop

@section('content')

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    {{-- Card --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create New Category</h3>
        </div>

        <form action="{{ url('/admin/categories/store') }}" method="POST">
            @csrf

            <div class="card-body">

                <div class="form-group">
                    <label>Category Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control" 
                        placeholder="Enter category name"
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

                        <option value="fa-laptop-code">fa-laptop-code (IT / Software)</option>
                        <option value="fa-code">fa-code (Developer)</option>
                        <option value="fa-palette">fa-palette (Web Designer)</option>
                        <option value="fa-chart-line">fa-chart-line (Data Analyst)</option>
                        <option value="fa-bullhorn">fa-bullhorn (Marketing)</option>
                        <option value="fa-sack-dollar">fa-sack-dollar (Sales)</option>
                        <option value="fa-users">fa-users (HR)</option>
                        <option value="fa-building-columns">fa-building-columns (Finance)</option>
                        <option value="fa-file-invoice-dollar">fa-file-invoice-dollar (Accounting)</option>
                        <option value="fa-headset">fa-headset (Customer Support)</option>
                        <option value="fa-pen-nib">fa-pen-nib (Content Writer)</option>
                        <option value="fa-graduation-cap">fa-graduation-cap (Education)</option>
                        <option value="fa-hospital">fa-hospital (Healthcare)</option>
                        <option value="fa-user-nurse">fa-user-nurse (Nurse)</option>
                        <option value="fa-user-doctor">fa-user-doctor (Doctor)</option>
                        <option value="fa-gears">fa-gears (Engineering)</option>
                        <option value="fa-helmet-safety">fa-helmet-safety (Construction)</option>
                        <option value="fa-truck">fa-truck (Logistics)</option>
                        <option value="fa-shield-halved">fa-shield-halved (Security)</option>
                        <option value="fa-scale-balanced">fa-scale-balanced (Legal)</option>
                        <option value="fa-briefcase">fa-briefcase (Admin / Office)</option>
                        <option value="fa-globe">fa-globe (Freelance)</option>
                        <option value="fa-house-laptop">fa-house-laptop (Remote Jobs)</option>
                        <option value="fa-laptop-code">fa-laptop-code</option>
                        <option value="fa-code">fa-code</option>
                        <option value="fa-palette">fa-palette</option>
                        <option value="fa-chart-line">fa-chart-line</option>
                        <option value="fa-bullhorn">fa-bullhorn</option>
                        <option value="fa-sack-dollar">fa-sack-dollar</option>
                        <option value="fa-users">fa-users</option>
                        <option value="fa-building-columns">fa-building-columns</option>
                        <option value="fa-file-invoice-dollar">fa-file-invoice-dollar</option>
                        <option value="fa-headset">fa-headset</option>
                        <option value="fa-pen-nib">fa-pen-nib</option>
                        <option value="fa-graduation-cap">fa-graduation-cap</option>
                        <option value="fa-hospital">fa-hospital</option>
                        <option value="fa-user-nurse">fa-user-nurse</option>
                        <option value="fa-user-doctor">fa-user-doctor</option>
                        <option value="fa-gears">fa-gears</option>
                        <option value="fa-helmet-safety">fa-helmet-safety</option>
                        <option value="fa-truck">fa-truck</option>
                        <option value="fa-shield-halved">fa-shield-halved</option>
                        <option value="fa-scale-balanced">fa-scale-balanced</option>

                        <option value="fa-briefcase">fa-briefcase</option>
                        <option value="fa-globe">fa-globe</option>
                        <option value="fa-house-laptop">fa-house-laptop</option>
                        <option value="fa-building">fa-building</option>
                        <option value="fa-city">fa-city</option>
                        <option value="fa-industry">fa-industry</option>
                        <option value="fa-wrench">fa-wrench</option>
                        <option value="fa-screwdriver-wrench">fa-screwdriver-wrench</option>
                        <option value="fa-cogs">fa-cogs</option>
                        <option value="fa-microchip">fa-microchip</option>

                        <option value="fa-database">fa-database</option>
                        <option value="fa-server">fa-server</option>
                        <option value="fa-network-wired">fa-network-wired</option>
                        <option value="fa-cloud">fa-cloud</option>
                        <option value="fa-lock">fa-lock</option>
                        <option value="fa-unlock">fa-unlock</option>
                        <option value="fa-user">fa-user</option>
                        <option value="fa-user-tie">fa-user-tie</option>
                        <option value="fa-id-badge">fa-id-badge</option>
                        <option value="fa-id-card">fa-id-card</option>

                        <option value="fa-phone">fa-phone</option>
                        <option value="fa-envelope">fa-envelope</option>
                        <option value="fa-comments">fa-comments</option>
                        <option value="fa-comment-dots">fa-comment-dots</option>
                        <option value="fa-paper-plane">fa-paper-plane</option>
                        <option value="fa-bell">fa-bell</option>
                        <option value="fa-calendar">fa-calendar</option>
                        <option value="fa-clock">fa-clock</option>
                        <option value="fa-tasks">fa-tasks</option>
                        <option value="fa-list-check">fa-list-check</option>

                        <option value="fa-check">fa-check</option>
                        <option value="fa-xmark">fa-xmark</option>
                        <option value="fa-plus">fa-plus</option>
                        <option value="fa-minus">fa-minus</option>
                        <option value="fa-filter">fa-filter</option>
                        <option value="fa-search">fa-search</option>
                        <option value="fa-eye">fa-eye</option>
                        <option value="fa-eye-slash">fa-eye-slash</option>
                        <option value="fa-download">fa-download</option>
                        <option value="fa-upload">fa-upload</option>

                        <option value="fa-file">fa-file</option>
                        <option value="fa-file-alt">fa-file-alt</option>
                        <option value="fa-file-pdf">fa-file-pdf</option>
                        <option value="fa-file-word">fa-file-word</option>
                        <option value="fa-file-excel">fa-file-excel</option>
                        <option value="fa-image">fa-image</option>
                        <option value="fa-video">fa-video</option>
                        <option value="fa-music">fa-music</option>
                        <option value="fa-camera">fa-camera</option>
                        <option value="fa-print">fa-print</option>

                        <option value="fa-map">fa-map</option>
                        <option value="fa-map-marker-alt">fa-map-marker-alt</option>
                        <option value="fa-location-dot">fa-location-dot</option>
                        <option value="fa-route">fa-route</option>
                        <option value="fa-compass">fa-compass</option>
                        <option value="fa-plane">fa-plane</option>
                        <option value="fa-car">fa-car</option>
                        <option value="fa-bus">fa-bus</option>
                        <option value="fa-train">fa-train</option>
                        <option value="fa-ship">fa-ship</option>

                        <option value="fa-shopping-cart">fa-shopping-cart</option>
                        <option value="fa-bag-shopping">fa-bag-shopping</option>
                        <option value="fa-credit-card">fa-credit-card</option>
                        <option value="fa-wallet">fa-wallet</option>
                        <option value="fa-coins">fa-coins</option>
                        <option value="fa-hand-holding-dollar">fa-hand-holding-dollar</option>
                        <option value="fa-chart-pie">fa-chart-pie</option>
                        <option value="fa-chart-bar">fa-chart-bar</option>
                        <option value="fa-chart-area">fa-chart-area</option>
                        <option value="fa-percentage">fa-percentage</option>

                        <option value="fa-heart">fa-heart</option>
                        <option value="fa-star">fa-star</option>
                        <option value="fa-thumbs-up">fa-thumbs-up</option>
                        <option value="fa-thumbs-down">fa-thumbs-down</option>
                        <option value="fa-flag">fa-flag</option>
                        <option value="fa-bookmark">fa-bookmark</option>
                        <option value="fa-tag">fa-tag</option>
                        <option value="fa-tags">fa-tags</option>
                        <option value="fa-fire">fa-fire</option>
                        <option value="fa-bolt">fa-bolt</option>


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
                    rows="4" required
                    placeholder="Enter category description"
                ></textarea>

                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    Add Category
                </button>

                <a href="{{ url('/admin/categories') }}" class="btn btn-secondary">
                    Back
                </a>
            </div>

        </form>
    </div>

@stop