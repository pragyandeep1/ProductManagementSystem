@extends('layouts.app')
@section('content')
    @php
        $current_date_time = \Carbon\Carbon::now()->setTimeZone('Asia/Kolkata');
    @endphp
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="page-header">
                        <h3>Site Setting</h3>
                    </div>
                </div>

                <div class="col-md-5">

                </div>

            </div>

            <div class="row g-2">
                <div class="col-md-6 col-lg-8">
                    <div class="sticky">
                        <h2><strong>General Settings</strong></h2>
                        <div class="whitebox mb-3">
                            <div class="item_name">
                                <form action="item-editor.php" method="post">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Site Title</label>
                                            <input type="text" class="form-control" name="" id="">
                                        </div>
                                        <div class="col-12">
                                            <label>Tagline</label>
                                            <input type="text" class="form-control" name="" id="">
                                        </div>
                                        {{-- <div class="col-6">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="" id="">
                                        </div>
                                        <div class="col-6">
                                            <label>Phone No.</label>
                                            <input type="text" class="form-control" name="" id="">
                                        </div>
                                        <div class="col-12">
                                            <label>Whatsapp No.</label>
                                            <input type="text" class="form-control" name="" id="">
                                        </div> --}}
                                    </div>




                                </form>
                            </div>
                        </div>
                        {{-- <h2><strong>SMTP Setting</strong></h2>
                        <div class="whitebox mb-3">
                            <div class="item_name">
                                <form action="item-editor.php" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Host</label>
                                            <input type="text" class="form-control" name="" id="">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Port</label>
                                            <input type="text" class="form-control" name="" id="">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Username</label>
                                            <input type="email" class="form-control" name="" id="">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Password</label>
                                            <input type="text" class="form-control" name="" id="">
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="additem">
                        <h3>Publish</h3>
                        <div class="additem_body">
                            <div class="mb-3"><i
                                    class="fa-solid fa-calendar-days me-2"></i>{{ $current_date_time->format('jS F, Y h:i A') }}
                            </div>
                            {{-- <div class="mb-3 ">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Status:</option>
                                    <option value="1">Active</option>
                                    <option value="2">Disable</option>
                                </select>
                            </div> --}}

                            <input type="submit" class="btn btn-primary" value="Publish">
                        </div>
                    </div>

                    {{-- <div class="additem">
                        <h3>Categories</h3>
                        <div class="additem_body">
                            <select class="form-control multiple-select">
                                <option value="CA">One</option>
                                <option value="NV">Two</option>
                                <option value="OR">Three</option>
                                <option value="WA">Four</option>
                            </select>
                        </div>
                    </div> --}}

                    <div class="additem">
                        <h3>Site Logo</h3>
                        <div class="additem_body">
                            <div class="img_holder">
                                <img src="img/thumb-1.webp" alt="" class="img-fluid">
                            </div>
                            <div class="remove_button">
                                <a href="#" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="additem">
                        <h3>Site Favicon</h3>
                        <div class="additem_body">
                            <div class="img_holder">
                                <img src="img/thumb-1.webp" alt="" class="img-fluid">
                            </div>
                            <div class="remove_button">
                                <a href="#" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <!-- End of Main Content -->
@endsection
