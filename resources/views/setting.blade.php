@extends('admin.layout.main')
@section('content')
<section class="page-content">
    <div class="wrapper">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class="page-header">
            <h1>Site Setting</h1>
            <hr />
        </div>
        @php
        //print_r($settings);
        @endphp
        <div class="item-wrap item-details">
            <form method="post" action="{{ route('savesettings') }}" id="AdminForm" class="formular" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-9 col-md-8 col-sm-8">
                        <fieldset class="border p-2">
                            <legend class="float-none w-auto p-2">General Setting</legend>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Site Title</label>
                                    <input type="text" class="form-control" name="site_title" value="{{ $settings['site_title'] ?? '' }}" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tagline</label>
                                    <input type="text" class="form-control" name="tagline" value="{{ $settings['tagline'] ?? '' }}" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <i class="fa-solid fa-circle-plus fa-lg" style="color: #0d6efd;" id="add-email"></i>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="email_field">
                                            @if (isset($settings['email']) && is_array($settings['email']))
                                            @foreach ($settings['email'] as $email)
                                            <tr id="email_row{{ $loop->iteration }}" class="email-added">
                                                <td>
                                                    <input type="email" name="email[]" placeholder="Email" class="form-control name_list" id="email_list" value="{{ $email }}" />
                                                </td>
                                                @if ($loop->iteration != 1)
                                                <td><button type="button" name="remove" id="{{ $loop->iteration }}" class="btn btn-danger email_btn_remove">X</button>
                                                </td>
                                                @else
                                                <td></td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td><input type="email" name="email[]" placeholder="Email" class="form-control name_list" id="email_list" onchange="" oninput="" required /></td>
                                                <td> </td>
                                            </tr>
                                            @endif
                                        </table>

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone No</label>
                                    <i class="fa-solid fa-circle-plus fa-lg" style="color: #0d6efd;" id="add-phone"></i>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="phone_field">
                                            @if (isset($settings['phone']) && is_array($settings['phone']))
                                            @foreach ($settings['phone'] as $phone)
                                            <tr id="phone_row{{ $loop->iteration }}" class="phone-added">
                                                <td>
                                                    <input type="text" name="phone[]" placeholder="Phone" class="form-control name_list" id="phone_list" value="{{ $phone }}" />
                                                </td>
                                                @if ($loop->iteration != 1)
                                                <td><button type="button" name="remove" id="{{ $loop->iteration }}" class="btn btn-danger phone_btn_remove">X</button>
                                                </td>
                                                @else
                                                <td></td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td><input type="text" name="phone[]" placeholder="Phone" class="form-control name_list" id="phone_list" onchange="" oninput="" required /></td>
                                                <td> </td>
                                            </tr>
                                            @endif
                                        </table>

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">International No</label>
                                    <i class="fa-solid fa-circle-plus fa-lg" style="color: #0d6efd;" id="add-int-phone"></i>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="int_phone_field">
                                            @if (isset($settings['int_phone']) && is_array($settings['int_phone']))
                                            @foreach ($settings['int_phone'] as $int_phone)
                                            <tr id="int_phone_row{{ $loop->iteration }}" class="int-phone-added">
                                                <td>
                                                    <input type="text" name="int_phone[]" placeholder="International Phone" class="form-control name_list" id="int_phone_list" value="{{ $int_phone }}" />
                                                </td>
                                                @if ($loop->iteration != 1)
                                                <td><button type="button" name="remove" id="{{ $loop->iteration }}" class="btn btn-danger int_phone_btn_remove">X</button>
                                                </td>
                                                @else
                                                <td></td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td><input type="text" name="int_phone[]" placeholder="International Phone" class="form-control name_list" id="int_phone_list" onchange="" oninput="" required /></td>
                                                <td> </td>
                                            </tr>
                                            @endif
                                        </table>

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Whatsapp No</label>
                                    <i class="fa-solid fa-circle-plus fa-lg" style="color: #0d6efd;" id="add-whatsapp"></i>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="whatsapp_field">
                                            @if (isset($settings['whatsapp']) && is_array($settings['whatsapp']))
                                            @foreach ($settings['whatsapp'] as $whatsapp)
                                            <tr id="whatsapp_row{{ $loop->iteration }}" class="whatsapp-added">
                                                <td>
                                                    <input type="text" name="whatsapp[]" placeholder="Whatsapp" class="form-control name_list" id="whatsapp_list" value="{{ $whatsapp }}" />
                                                </td>
                                                @if ($loop->iteration != 1)
                                                <td><button type="button" name="remove" id="{{ $loop->iteration }}" class="btn btn-danger whatsapp_btn_remove">X</button>
                                                </td>
                                                @else
                                                <td></td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td><input type="text" name="whatsapp[]" placeholder="Whatsapp" class="form-control name_list" id="whatsapp_list" onchange="" oninput="" required /></td>
                                                <td> </td>
                                            </tr>
                                            @endif
                                        </table>

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <i class="fa-solid fa-circle-plus fa-lg" style="color: #0d6efd;" id="add-address"></i>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="address_field">
                                            @if (isset($settings['address']) && is_array($settings['address']))
                                            @foreach ($settings['address'] as $address)
                                            <tr id="address_row{{ $loop->iteration }}" class="address-added">
                                                <td>
                                                    <textarea type="text" name="address[]" rows="6" class="form-control name_list ckeditor" id="address_list">{!! $address ?? '' !!}</textarea>
                                                </td>
                                                @if ($loop->iteration != 1)
                                                <td><button type="button" name="remove" id="{{ $loop->iteration }}" class="btn btn-danger address_btn_remove">X</button>
                                                </td>
                                                @else
                                                <td></td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td><input type="text" name="address[]" placeholder="Address" class="form-control name_list" id="address_list" onchange="" oninput="" required /></td>
                                                <td> </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">About Us</label>
                                    <td>
                                        <textarea type="text" name="about_us" rows="6" class="form-control name_list ckeditor" id="about_us">{!! $settings['about_us'] ?? '' !!}</textarea>
                                    </td>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Academy Busfam</label>
                                    <td>
                                        <textarea type="text" name="academy_busfam" rows="6" class="form-control name_list ckeditor" id="academy_busfam">{!! $settings['academy_busfam'] ?? '' !!}</textarea>
                                    </td>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border p-2">
                            <legend class="float-none w-auto p-2">SMTP Setting</legend>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Host</label>
                                    <input type="text" class="form-control" name="host" value="{{ $settings['host'] ?? '' }}" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Port</label>
                                    <input type="text" class="form-control" name="port" value="{{ $settings['port'] ?? '' }}" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="email" class="form-control" name="username" value="{{ $settings['username'] ?? '' }}" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="text" class="form-control" name="password" />
                                    <span>{{ $settings['password'] ?? '' }}</span>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border p-2">
                            <legend class="float-none w-auto p-2">Social Links
                                <i class="fa-solid fa-circle-plus fa-lg" style="color: #0d6efd;" id="add-social"></i>
                            </legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="social_field">
                                            <thead>
                                                <tr style="text-align: center">
                                                    <td><strong>Label</strong></td>
                                                    <td><strong>Url</strong></td>
                                                    <td><strong>Class </strong><br>(fa-brands fa-facebook-f)</td>
                                                    <td><strong>Color code</strong><br> (#3e5a99)</td>
                                                </tr>
                                            </thead>
                                            @if (isset($settings['social']) && is_array($settings['social']['social_name']))
                                            @foreach ($settings['social']['social_name'] as $index => $name)
                                            <tr id="social_row{{ $loop->iteration }}" class="social-added">
                                                <td><input type="text" class="text-input form-control" name="social[social_name][]" id="social_name" value="{{ $name }}"></td>
                                                <td>
                                                    <input type="text" name="social[social_url][]" placeholder="Enter url" class="form-control name_list " id="social_url" value="{{ $settings['social']['social_url'][$index] ?? '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" name="social[social_class][]" placeholder="Enter class" class="form-control name_list" id="social_class" value="{{ $settings['social']['social_class'][$index] ?? '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" name="social[social_color][]" placeholder="Enter color code" class="form-control name_list" id="social_color" value="{{ $settings['social']['social_color'][$index] ?? '' }}" />
                                                </td>
                                                @if ($loop->iteration != 1)
                                                <td><button type="button" name="remove" id="{{ $loop->iteration }}" class="btn btn-danger social_btn_remove">X</button>
                                                </td>
                                                @else
                                                <td></td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td><input type="text" class="text-input form-control" placeholder="Enter label" name="social[social_name][]" id="social_name" />
                                                </td>
                                                <td>
                                                    <input type="text" name="social[social_url][]" placeholder="Enter url" class="form-control name_list " id="social_url" />
                                                </td>
                                                <td>
                                                    <input type="text" name="social[social_class][]" placeholder="Enter class" class="form-control name_list" id="social_class" />
                                                </td>
                                                <td>
                                                    <input type="text" name="social[social_color][]" placeholder="Enter color code" class="form-control name_list" id="social_color" />
                                                </td>
                                                <td> </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border p-2">
                            <legend class="float-none w-auto p-2">Google Maps</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>map </label>
                                        <textarea type="text" id="noeditor" rows="6" class=" text-input form-control" name="map" id="inout-1">{{ $settings['map'] ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        {!! $settings['map'] ?? '' !!}

                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-lg-3 col-md-4 col-md-offset-0  col-sm-4 col-sm-offset-0">

                        <div class="right-box">
                            <h3>Publish</h3>
                            <div class="content-box content-box-img">
                                <div class="mb-2"><i class="fa-solid fa-calendar-days me-2"></i>@php print Carbon\Carbon::now()->format('jS F, Y G:iA'); @endphp
                                </div>
                                <hr />
                                <div><input type="submit" class="btn btn-primary" value="Publish"></div>
                            </div>
                        </div>
                        @php
                        $siteimg = App\Models\Media::find(json_decode($settings['site_logo']));
                        $siteimageUrl = $siteimg->url ?? 'https://via.placeholder.com/300x300/CCCCCC/000000/?text=busfam.com';

                        $favimg = App\Models\Media::find(json_decode($settings['site_fav_icon']));
                        $favimageUrl = $favimg->url ?? 'https://via.placeholder.com/300x300/CCCCCC/000000/?text=busfam.com';

                        //$ribbonsimg = App\Models\Media::find(json_decode($settings['site_ribbons_icon']));
                        $ribbonimageUrl = 'https://via.placeholder.com/300x300/CCCCCC/000000/?text=busfam.com';
                        @endphp
                        <div class="right-box">
                            <h3>Site Logo</h3>
                            <div class="content-box content-box-img">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <div class="site_logo-img position-relative mb-3">
                                            <input id="site_logo" name="site_logo" type="hidden" value="{{ $settings['site_logo'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group position-relative" id="viewImgDiv">
                                            <a data-bs-target="#galleryModal" data-bs-toggle="modal" class="" style="width:230px;" href="javascript:void(0);">
                                                <img id="site_logoPreview" onclick="ChangeGlobal('site_logo')" src="{{ asset($siteimageUrl) }}" alt="" width="100%">
                                            </a>
                                            <i class="fa-sharp fa-solid fa-circle-xmark fa-xl" onclick="removeImage('site_logo')"
                                                title="remove"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="right-box">
                            <h3>Site Favicon</h3>
                            <div class="content-box content-box-img">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <div class="site_fav_icon-img position-relative mb-3">
                                            <input id="site_fav_icon" name="site_fav_icon" type="hidden" value="{{ $settings['site_fav_icon'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group position-relative" id="viewImgDiv">
                                            <a data-bs-target="#galleryModal" data-bs-toggle="modal" class="" style="width:230px;" href="javascript:void(0);">
                                                <img id="site_fav_iconPreview" onclick="ChangeGlobal('site_fav_icon')" src="{{ asset($favimageUrl) }}" alt="" width="100%">
                                            </a>
                                            <i class="fa-sharp fa-solid fa-circle-xmark fa-xl" onclick="removeImage('site_fav_icon')"
                                                title="remove"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="right-box">
                            <h3>Site Ribbons</h3>                            
                            <div class="form-group">
                                <label for="add-recognisedBy" class="form-label">Recognised By</label>
                                <i class="fas fa-plus-circle fa-lg" style="color: #0d6efd; cursor: pointer;" id="add-recognisedBy"></i>
                            </div>                            
                            <div class="table-responsive">
                                <table class="table table-bordered" id="recognisedBy_field">
                                    @if (isset($settings['recognisedBy']) && is_array($settings['recognisedBy']))
                                    @foreach ($settings['recognisedBy'] as $recognisedBy)
                                   @php $ribbonsimg = App\Models\Media::find(json_decode($recognisedBy));
                                    $ribbonimageUrl = $ribbonsimg->url ?? 'https://via.placeholder.com/300x300/CCCCCC/000000/?text=busfam.com'; @endphp
                                    <tr id="recognisedBy_row{{ $loop->iteration }}" class="recognisedBy-added">
                                        <td>
                                            <!-- <input id="site_ribbons_icon" name="site_ribbons_icon" type="hidden" value="{{ $settings['site_ribbons_icon'] ?? '' }}"> -->
                                            <input type="hidden" name="recognisedBy[{{ $loop->iteration - 1 }}]" placeholder="Recognised By" class="form-control name_list" id="recognisedBy_list{{ $loop->iteration }}" value="{{ $recognisedBy }}" />
                                            <a data-bs-target="#galleryModal" data-bs-toggle="modal" class="" style="width:60px;" href="javascript:void(0);">
                                                <img id="recognisedBy_list{{ $loop->iteration }}Preview" onclick="ChangeGlobal('recognisedBy_list{{ $loop->iteration }}')" src="{{ asset($ribbonimageUrl)??'' }}" alt="img" width="30%">
                                            </a>
                                        </td>
                                       
                                        <td><button type="button" name="remove" id="{{ $loop->iteration }}" class="btn btn-danger recognisedBy_btn_remove">X</button>
                                        </td>
                                       
                                    </tr>
                                    @endforeach
                                    
                                    @endif
                                </table>
                            </div>
                            <!-- //2nd part -->
                            <div class="form-group">
                                <label for="add-membersOf" class="form-label">Proud Members Of</label>
                                <i class="fas fa-plus-circle fa-lg" style="color: #0d6efd; cursor: pointer;" id="add-membersOf"></i>
                            </div> 
                            <div class="table-responsive">
                                <table class="table table-bordered" id="membersOf_field">
                                    @if (isset($settings['membersOf']) && is_array($settings['membersOf']))
                                    @foreach ($settings['membersOf'] as $membersOf)
                                    @php $membersOfimg = App\Models\Media::find(json_decode($membersOf));
                                    $membersOfimgUrl = $membersOfimg->url ?? 'https://via.placeholder.com/300x300/CCCCCC/000000/?text=busfam.com'; @endphp
                                    <tr id="membersOf_row{{ $loop->iteration }}" class="membersOf-added">
                                        <td>
                                            <input type="hidden" name="membersOf[{{ $loop->iteration - 1 }}]" placeholder="Proud Members Of" class="form-control name_list" id="membersOf_list{{ $loop->iteration }}" value="{{ $membersOf }}" />
                                            <a data-bs-target="#galleryModal" data-bs-toggle="modal" class="" style="width:60px;" href="javascript:void(0);">
                                                <img id="membersOf_list{{ $loop->iteration }}Preview" onclick="ChangeGlobal('membersOf_list{{$loop->iteration }}')" src="{{ asset($membersOfimgUrl)??'' }}" alt="img" width="30%">
                                            </a>
                                        </td>
                                     
                                        <td><button type="button" name="remove" id="{{ $loop->iteration }}" class="btn btn-danger membersOf_btn_remove">X</button>
                                        </td>
                                       
                                    </tr>
                                    @endforeach
                                    
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@push('javascript')
<script>
    $(document).ready(function() {
        var i = $(".address-added").length;
        if (i == 0) {
            i = 1;
        }
        $('#add-address').click(function() {
            i++;
            $('#address_field').append(
                `<tr id="address_row${i}" class="address-added"><td>
      <textarea type="text" name="address[]" rows="6" class="form-control name_list" id="address_list" ></textarea></td>
                                             
               <td><button type="button" name="remove" id="${i}" class="btn btn-danger address_btn_remove">X</button></td></tr>`
            );
        });
        $(document).on('click', '.address_btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#address_row' + button_id + '').remove();
        });
    });
</script>
<script>
    $(document).ready(function() {
        var i = $(".whatsapp-added").length;
        if (i == 0) {
            i = 1;
        }
        $('#add-whatsapp').click(function() {
            i++;
            $('#whatsapp_field').append(
                `<tr id="whatsapp_row${i}" class="whatsapp-added"><td>
               
               <input type="text" name="whatsapp[]" placeholder="Whatsapp" class="form-control name_list"  id="whatsapp_list" /></td>
                                             
               <td><button type="button" name="remove" id="${i}" class="btn btn-danger whatsapp_btn_remove">X</button></td></tr>`
            );
        });
        $(document).on('click', '.whatsapp_btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#whatsapp_row' + button_id + '').remove();
        });
    });
</script>
<script>
    $(document).ready(function() {
        var i = $(".social-added").length;
        if (i == 0) {
            i = 1;
        }
        $('#add-social').click(function() {
            i++;
            $('#social_field').append(
                `<tr id="social_row${i}" class="social-added">
               <td><input type="text" name="social[social_name][]"  placeholder="Enter label"       class="form-control name_list" id="social_name" /></td>
               <td><input type="text" name="social[social_url][]"   placeholder="Enter url"        class="form-control name_list" id="social_url" /></td>
               <td><input type="text" name="social[social_class][]" placeholder="Enter class"      class="form-control name_list" id="social_class" /></td>
               <td><input type="text" name="social[social_color][]" placeholder="Enter color code" class="form-control name_list" id="social_color" /></td>    
               <td><button type="button" name="remove" id="${i}" class="btn btn-danger social_btn_remove">X</button></td>
            </tr>`
            );
        });
        $(document).on('click', '.social_btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#social_row' + button_id + '').remove();
        });
    });
</script>
<script>
    $(document).ready(function() {
        var i = $(".phone-added").length;
        if (i == 0) {
            i = 1;
        }
        $('#add-phone').click(function() {
            i++;
            $('#phone_field').append(
                `<tr id="phone_row${i}" class="phone-added"><td>
               
               <input type="text" name="phone[]" placeholder="Phone" class="form-control name_list"  id="phone_list" /></td>
                                             
               <td><button type="button" name="remove" id="${i}" class="btn btn-danger phone_btn_remove">X</button></td></tr>`
            );
        });
        $(document).on('click', '.phone_btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#phone_row' + button_id + '').remove();
        });
    });
</script>
<script>
    $(document).ready(function() {
        var i = $(".int-phone-added").length;
        if (i == 0) {
            i = 1;
        }
        $('#add-int-phone').click(function() {
            i++;
            $('#int_phone_field').append(
                `<tr id="int_phone_row${i}" class="int-phone-added"><td>
               
               <input type="text" name="int_phone[]" placeholder="International Phone" class="form-control name_list"  id="int_phone_list" /></td>
                                             
               <td><button type="button" name="remove" id="${i}" class="btn btn-danger int_phone_btn_remove">X</button></td></tr>`
            );
        });
        $(document).on('click', '.int_phone_btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#int_phone_row' + button_id + '').remove();
        });
    });
</script>
<script>
    $(document).ready(function() {
        var i = $(".email-added").length;
        if (i == 0) {
            i = 1;
        }
        $('#add-email').click(function() {
            i++;
            $('#email_field').append(
                `<tr id="email_row${i}" class="email-added"><td>
               
               <input type="email" name="email[]" placeholder="Email" class="form-control name_list"  id="email_list" /></td>
                                             
               <td><button type="button" name="remove" id="${i}" class="btn btn-danger email_btn_remove">X</button></td></tr>`
            );
        });
        $(document).on('click', '.email_btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#email_row' + button_id + '').remove();
        });
    });
</script>
<script>
    $(document).ready(function() {
        var i = $(".recognisedBy-added").length;
        if (i == 0) {
            i = 1;
        }
        $('#add-recognisedBy').click(function() {
            i++;
            $('#recognisedBy_field').append(
                `<tr id="recognisedBy_row${i}" class="recognisedBy-added"><td>
                <input type="hidden" name="recognisedBy[${i-1}]" placeholder="Recognised By" class="form-control name_list" id="recognisedBy_list${i}" />
                <a data-bs-target="#galleryModal" data-bs-toggle="modal" class="" style="width:60px;" href="javascript:void(0);">
                <img id="recognisedBy_list${i}Preview" onclick="ChangeGlobal('recognisedBy_list${i}')" src="https://via.placeholder.com/300x300/CCCCCC/000000/?text=busfam.com" alt="img" width="30%">
                </a>                                            
               <td><button type="button" name="remove" id="${i}" class="btn btn-danger recognisedBy_btn_remove">X</button></td></tr>`
            );
        });
        $(document).on('click', '.recognisedBy_btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#recognisedBy_row' + button_id + '').remove();
        });
    });
</script>
<script>
    $(document).ready(function() {
        var i = $(".membersOf-added").length;
        if (i == 0) {
            i = 1;
        }
        $('#add-membersOf').click(function() {
            i++;
            $('#membersOf_field').append(
                `<tr id="membersOf_row${i}" class="membersOf-added"><td>
                    <input type="hidden" name="membersOf[${i-1}]" placeholder="Members Of" class="form-control name_list" id="membersOf_list${i}" />
                <a data-bs-target="#galleryModal" data-bs-toggle="modal" class="" style="width:60px;" href="javascript:void(0);">
                <img id="membersOf_list${i}Preview" onclick="ChangeGlobal('membersOf_list${i}')" src="https://via.placeholder.com/300x300/CCCCCC/000000/?text=busfam.com" alt="img" width="30%">
                </a> </td>                                             
               <td><button type="button" name="remove" id="${i}" class="btn btn-danger membersOf_btn_remove">X</button></td></tr>`
            );
        });
        $(document).on('click', '.membersOf_btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#membersOf_row' + button_id + '').remove();
        });
    });
</script>

@endpush