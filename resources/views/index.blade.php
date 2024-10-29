@extends('layouts.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div class="page-header">
                    <h1>Dashboard</h1>
                </div>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
            </div>
            <div class="row boxs">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info card-img-holder">
                        <div class="inner">
                            <img src="{{ asset('img/circle-box.svg') }}" class="card-img-absolute">
                            <h3>150</h3>
                            <p>New Orders</p>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success card-img-holder">
                        <div class="inner">
                            <img src="{{ asset('img/circle-box.svg') }}" class="card-img-absolute">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>
                            <p>Bounce Rate</p>

                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning card-img-holder">
                        <div class="inner">
                            <img src="{{ asset('img/circle-box.svg') }}" class="card-img-absolute">
                            <h3>44</h3>
                            <p>User Registrations</p>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger card-img-holder">
                        <div class="inner">
                            <img src="{{ asset('img/circle-box.svg') }}" class="card-img-absolute">
                            <h3>65</h3>
                            <p>Unique Visitors</p>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="content-box intro-box mt-4">
            <h2>Welcome to Admin Panel</h2>
            <h3>We've assembled some links to get you started:</h3>
            <p>Get Started</p>
            <a href="setting.php" class="btn btn-primary">Change Your Setting</a>
        </div> --}}
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
