@extends('theme.layout.master')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">

@endpush
@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">CMS </h2>
    </div>


@endsection
@section('content')
    <section class="cms_sec">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="shadow_box_wrapper">
                        <div class="cms_tabs_wrapper">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if(session('key') == null || session('key') == 'home') active @endif" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Home</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if(session('key') == 'about') active @endif" id="about-tab" data-bs-toggle="tab" data-bs-target="#about-tab-pane" type="button" role="tab" aria-controls="about-tab-pane" aria-selected="false">About Us</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if(session('key') == 'service') active @endif" id="services-tab" data-bs-toggle="tab" data-bs-target="#services-tab-pane" type="button" role="tab" aria-controls="services-tab-pane" aria-selected="false">Services</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if(session('key') == 'blog') active @endif" id="blogs-tab" data-bs-toggle="tab" data-bs-target="#blogs-tab-pane" type="button" role="tab" aria-controls="blogs-tab-pane" aria-selected="false">Blogs</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if(session('key') == 'contact') active @endif" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Contact Us</button>
                                </li>
                            </ul>
                        </div>
                        <div class="cms_tabs_discription_wrapper">
                            <div class="tab-content" id="myTabContent">

                                <div class="tab-pane fade @if(session('key') == null || session('key') == 'home') active show @endif" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                    <form method="post" action="{{ route('cms_home') }}" class="form-horizontal" id="validateHome" enctype="multipart/form-data">
                                        @csrf
                                        <div class="cms_whole_wrapper">
                                            <div class="section_one_wrapper">
                                                <h2>Section 01: Main Hero</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea name="section_one_heading" id="section_one_heading" class="form-control summer_note">{{$cmsHome->section_one_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Description</label>
                                                            <textarea rows="5" name="section_one_description" id="section_one_description" class="form-control summer_note">{{$cmsHome->section_one_description??''}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="section_one_wrapper">
                                                <h2>Section 02</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="section_two_heading" id="section_two_heading" class="form-control summer_note">{{$cmsHome->section_two_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper">
                                                            <div class="txt_field">
                                                                <label>Image</label>
                                                                <div class="image-input @if($cmsHome->section_two_image_one) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsHome->section_two_image_one ?? 'default_image.jpg'}}" alt="Business Card Front">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="section_two_image_one" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                                          <i class="fa-solid fa-trash"></i>
                                                                    </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                            <div class="txt_field">
                                                                <label>Image</label>
                                                                <div class="image-input @if($cmsHome->section_two_image_two) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsHome->section_two_image_two ?? 'default_image.jpg'}}" alt="Business Card Front">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="section_two_image_two" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                                          <i class="fa-solid fa-trash"></i>
                                                                    </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h2>Sub Section 01</h2>
                                                <div class="row custom_row append_sec_cms">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="two_sub_section_one_heading" id="two_sub_section_one_heading" class="form-control summer_note">{{$cmsHome->two_sub_section_one_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper cms_icon_wrapper">
                                                            <div class="txt_field">
                                                                <label>Icon</label>
                                                                <div class="image-input @if($cmsHome->two_sub_section_one_icon) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsHome->two_sub_section_one_icon ?? 'cms_profile_icon.svg'}}" alt="Business Card Front">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="two_sub_section_one_icon" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 more_cms_wrapper">
                                                        @php
                                                            $titles = json_decode($cmsHome->two_sub_section_one_title, true);
                                                        @endphp
                                                        @foreach($titles as $title)
                                                        <div class="txt_field ">



                                                            <label>Title</label>
                                                            <div class="add_more_cms_wrapper">
                                                                @if(!$loop->first)
                                                                    <button type="button" class="cross_append_functionality"> <i class="fa fa-remove"></i></button>
                                                                @endif
                                                                <input type="text" name="two_sub_section_one_title[]" class="form-control" value="{{$title??''}}">
                                                                @if($loop->first)
                                                                <button type="button" class="btn_sky_blue btn_global add_more_cms">Add more <i class="fa-solid fa-plus"></i></button>
                                                                @endif

                                                            </div>

                                                        </div>
                                                        @endforeach
                                                        <div class="append_more_cms_wrapper"></div>
                                                    </div>
                                                </div>
                                                <h2>Sub Section 02</h2>
                                                <div class="row custom_row append_sec_cms">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="two_sub_section_two_heading" id="two_sub_section_two_heading" class="form-control summer_note">{{$cmsHome->two_sub_section_two_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper cms_icon_wrapper">
                                                            <div class="txt_field">
                                                                <label>Icon</label>
                                                                <div class="image-input @if($cmsHome->two_sub_section_two_icon) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsHome->two_sub_section_two_icon ?? 'cms_profile_icon.svg'}}" alt="Business Card Front">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="two_sub_section_two_icon" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 more_cms_wrapper">
                                                        @php
                                                            $titles = json_decode($cmsHome->two_sub_section_two_title, true);
                                                        @endphp

                                                        @foreach($titles as $title)
                                                        <div class="txt_field ">

                                                            <label>Title</label>
                                                            <div class="add_more_cms_wrapper">
                                                                @if(!$loop->first)
                                                                    <button type="button" class="cross_append_functionality"> <i class="fa fa-remove"></i></button>
                                                                @endif
                                                                <input type="text" name="two_sub_section_two_title[]" class="form-control" value="{{$title??''}}">

                                                                @if($loop->first)
                                                                        <button type="button" class="btn_sky_blue btn_global add_more_cms">Add more <i class="fa-solid fa-plus"></i></button>
                                                                @endif
                                                            </div>

                                                        </div>
                                                        @endforeach
                                                        <div class="append_more_cms_wrapper"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--section 3--}}
                                            <div class="section_one_wrapper">
                                                <h2>Section 03</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="section_three_heading" id="section_three_heading" class="form-control summer_note">{{$cmsHome->section_three_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Description</label>
                                                            <textarea rows="5" name="section_three_description" id="section_three_description" class="form-control summer_note">{{$cmsHome->section_three_description??''}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
{{--                                                <h2>Sub Section 01</h2>--}}
{{--                                                <div class="row custom_row">--}}
{{--                                                    <div class="col-md-12">--}}
{{--                                                        <div class="txt_field">--}}
{{--                                                            <label>Heading</label>--}}
{{--                                                            <input type="text" name="three_sub_section_one_heading" class="form-control" value="{{$cmsHome->three_sub_section_one_heading??''}}">--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-md-12">--}}
{{--                                                        <div class="txt_field">--}}
{{--                                                            <label>Description</label>--}}
{{--                                                            <textarea rows="5" name="three_sub_section_one_description" class="form-control" placeholder="">{{$cmsHome->three_sub_section_one_description??''}}</textarea>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-md-12">--}}
{{--                                                        <div class="cms_img_wrapper">--}}
{{--                                                            <div class="txt_field">--}}
{{--                                                                <label>Image</label>--}}
{{--                                                                <div class="image-input @if($cmsHome->three_sub_section_one_image) image-input-circle @endif" data-kt-image-input="true">--}}
{{--                                                                    <!--begin::Image preview wrapper-->--}}
{{--                                                                    <div class="image-input-wrapper">--}}
{{--                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsHome->three_sub_section_one_image ?? 'service_img1.png'}}" alt="Business Card Front">--}}
{{--                                                                    </div>--}}
{{--                                                                    <!--end::Image preview wrapper-->--}}

{{--                                                                    <!--begin::Edit button-->--}}
{{--                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"--}}
{{--                                                                           data-kt-image-input-action="change"--}}
{{--                                                                           data-bs-toggle="tooltip"--}}
{{--                                                                           data-bs-dismiss="click"--}}
{{--                                                                           title="Change avatar">--}}
{{--                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>--}}

{{--                                                                        <!--begin::Inputs-->--}}
{{--                                                                        <input type="file" name="three_sub_section_one_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>--}}
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
{{--                                                                        <!--end::Inputs-->--}}
{{--                                                                    </label>--}}
{{--                                                                    <!--end::Edit button-->--}}

{{--                                                                    <!--begin::Cancel button-->--}}
{{--                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"--}}
{{--                                                                          data-kt-image-input-action="cancel"--}}
{{--                                                                          data-bs-toggle="tooltip"--}}
{{--                                                                          data-bs-dismiss="click"--}}
{{--                                                                          title="Cancel avatar">--}}
{{--                                                                          <i class="fa-solid fa-trash"></i>--}}
{{--                                                                    </span>--}}
{{--                                                                    <!--end::Cancel button-->--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-md-12 ">--}}
{{--                                                        <div class="txt_field ">--}}
{{--                                                            <label>Facebook Link</label>--}}
{{--                                                            <input type="text" name="three_sub_section_one_link" class="form-control" value="{{$cmsHome->three_sub_section_one_link??''}}">--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                            </div>
                                            <div class="cms_submit_btn_wrapper">
                                                <button type="submit" class="btn_global btn_sky_blue">Save Changes</button>

                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade @if(session('key') == 'about') active show @endif" id="about-tab-pane" role="tabpanel" aria-labelledby="about-tab" tabindex="0">
                                    <form method="post" action="{{ route('cms_about') }}" class="form-horizontal" id="validateAboutUs" enctype="multipart/form-data">
                                        @csrf
                                        <div class="cms_whole_wrapper">
                                            <div class="section_one_wrapper">
                                                <h2>Section 01: About Us</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="section_one_heading" id="section_one_heading" class="form-control summer_note">{{$cmsAbout->section_one_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Description</label>
                                                            <textarea rows="5" name="section_one_description" id="section_one_description" class="form-control summer_note" placeholder="">{{$cmsAbout->section_one_description??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper">
                                                            <div class="txt_field">
                                                                <label>Image</label>
                                                                <div class="image-input @if($cmsAbout && $cmsAbout->section_one_image) image-input-circle @endif" data-kt-image-input="true">

                                                                <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsAbout->section_one_image ?? 'about_us_hero_img.png'}}">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="section_one_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="section_one_wrapper">
                                                <h2>Section 02</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="section_two_heading" id="section_two_heading" class="form-control summer_note">{{$cmsAbout->section_two_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h2>Sub Section 01</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="two_sub_section_one_heading" id="two_sub_section_one_heading" class="form-control summer_note">{{$cmsAbout->two_sub_section_one_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Title</label>
                                                            <input type="text" name="two_sub_section_one_title" class="form-control" value="{{$cmsAbout->two_sub_section_one_title??''}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Description</label>
                                                            <textarea rows="5" name="two_sub_section_one_description" id="two_sub_section_one_description" class="form-control summer_note" placeholder="">{{$cmsAbout->two_sub_section_one_description??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper">
                                                            <div class="txt_field">
                                                                <label>Image</label>
                                                                <div class="image-input @if(optional($cmsAbout)->two_sub_section_one_image) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsAbout->two_sub_section_one_image ?? 'service_img1.png'}}">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="two_sub_section_one_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="txt_field">
                                                            <label class="">Facebook Link</label>
                                                            <input type="text" name="two_sub_section_one_link_one" class="form-control" value="{{$cmsAbout->two_sub_section_one_link_one??''}}">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="txt_field">
                                                            <label class="">LinkedIn Link</label>
                                                            <input type="text" name="two_sub_section_one_link_two" class="form-control" value="{{$cmsAbout->two_sub_section_one_link_two??''}}">
                                                        </div>

                                                    </div>
                                                </div>
                                                <h2>Sub Section 02</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="two_sub_section_two_heading" id="two_sub_section_two_heading" class="form-control summer_note">{{$cmsAbout->two_sub_section_two_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Title</label>
                                                            <input type="text" name="two_sub_section_two_title" class="form-control" value="{{$cmsAbout->two_sub_section_two_title??''}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Description</label>
                                                            <textarea rows="5" name="two_sub_section_two_description" id="two_sub_section_two_description" class="form-control summer_note" placeholder="">{{$cmsAbout->two_sub_section_two_description??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper">
                                                            <div class="txt_field">
                                                                <label>Image</label>
                                                                <div class="image-input @if(optional($cmsAbout)->two_sub_section_two_image) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsAbout->two_sub_section_two_image??'service_img1.png'}}">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="two_sub_section_two_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="txt_field">
                                                            <label class="">Facebook Link</label>
                                                            <input type="text" name="two_sub_section_two_link_one" class="form-control" value="{{$cmsAbout->two_sub_section_two_link_one??''}}">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="txt_field">
                                                            <label class="">LinkedIn Link</label>
                                                            <input type="text" name="two_sub_section_two_link_two" class="form-control" value="{{$cmsAbout->two_sub_section_two_link_two??''}}">
                                                        </div>

                                                    </div>
                                                </div>
                                                <h2>Sub Section 03</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="two_sub_section_three_heading" id="two_sub_section_three_heading" class="form-control summer_note">{{$cmsAbout->two_sub_section_three_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Title</label>
                                                            <input type="text" name="two_sub_section_three_title" class="form-control" value="{{$cmsAbout->two_sub_section_three_title??''}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Description</label>
                                                            <textarea rows="5" name="two_sub_section_three_description" id="two_sub_section_three_description" class="form-control summer_note" placeholder="">{{$cmsAbout->two_sub_section_three_description??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper">
                                                            <div class="txt_field">
                                                                <label>Image</label>
                                                                <div class="image-input @if(optional($cmsAbout)->two_sub_section_three_image) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsAbout->two_sub_section_three_image ?? 'service_img1.png'}}">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="two_sub_section_three_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="txt_field">
                                                            <label class="">Facebook Link</label>
                                                            <input type="text" name="two_sub_section_three_link_one" class="form-control" value="{{$cmsAbout->two_sub_section_three_link_one??''}}">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="txt_field">
                                                            <label class="">LinkedIn Link</label>
                                                            <input type="text" name="two_sub_section_three_link_two" class="form-control" value="{{$cmsAbout->two_sub_section_three_link_two??''}}">
                                                        </div>

                                                    </div>
                                                </div>
                                                <h2>Sub Section 04</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="two_sub_section_four_heading" id="two_sub_section_four_heading" class="form-control summer_note">{{$cmsAbout->two_sub_section_four_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Title</label>
                                                            <input type="text" name="two_sub_section_four_title" class="form-control" value="{{$cmsAbout->two_sub_section_four_title??''}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Description</label>
                                                            <textarea rows="5"  class="form-control summer_note" name="two_sub_section_four_description" id="two_sub_section_four_description" placeholder="">{{$cmsAbout->two_sub_section_four_description??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper">
                                                            <div class="txt_field">
                                                                <label>Image</label>
                                                                <div class="image-input @if(optional($cmsAbout)->two_sub_section_four_image) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsAbout->two_sub_section_four_image??'service_img1.png'}}">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="two_sub_section_four_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="txt_field">
                                                            <label class="">Facebook Link</label>
                                                            <input type="text" name="two_sub_section_four_link_one" class="form-control" value="{{$cmsAbout->two_sub_section_four_link_one??''}}">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="txt_field">
                                                            <label class="">LinkedIn Link</label>
                                                            <input type="text" name="two_sub_section_four_link_two" class="form-control" value="{{$cmsAbout->two_sub_section_four_link_two??''}}">
                                                        </div>

                                                    </div>
                                                </div>
                                                <h2>Sub Section 05</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="two_sub_section_five_heading" id="two_sub_section_five_heading" class="form-control summer_note">{{$cmsAbout->two_sub_section_five_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Title</label>
                                                            <input type="text" name="two_sub_section_five_title" class="form-control" value="{{$cmsAbout->two_sub_section_five_title??''}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Description</label>
                                                            <textarea rows="5" name="two_sub_section_five_description" id="two_sub_section_five_description" class="form-control summer_note" placeholder="">{{$cmsAbout->two_sub_section_five_description??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper">
                                                            <div class="txt_field">
                                                                <label>Image</label>
                                                                <div class="image-input @if(optional($cmsAbout)->two_sub_section_five_image) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsAbout->two_sub_section_five_image??'service_img1.png'}}">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="two_sub_section_five_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="txt_field">
                                                            <label class="">Facebook Link</label>
                                                            <input type="text" name="two_sub_section_five_link_one" class="form-control" value="{{$cmsAbout->two_sub_section_five_link_one??''}}">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="txt_field">
                                                            <label class="">LinkedIn Link</label>
                                                            <input type="text" name="two_sub_section_five_link_two" class="form-control" value="{{$cmsAbout->two_sub_section_five_link_two??''}}">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cms_submit_btn_wrapper">
                                                <button type="button" class="btn_global btn_grey">Cancel<i class="fa-solid fa-xmark"></i></button>
                                                <button type="submit" class="btn_global btn_sky_blue">Save Changes</button>

                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <div class="tab-pane fade @if(session('key') == 'service') active show @endif" id="services-tab-pane" role="tabpanel" aria-labelledby="services-tab" tabindex="0">
                                    <form method="post" action="{{ route('cms_service') }}" class="form-horizontal" id="validateAboutUs" enctype="multipart/form-data">
                                        @csrf
                                        <div class="cms_whole_wrapper">
                                            <div class="section_one_wrapper">
                                                <h2>Section 01: Services</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="section_one_heading" class="form-control summer_note">{{$cmsService->section_one_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Description</label>
                                                            <textarea rows="5" name="section_one_description" class="form-control summer_note" placeholder="">{{$cmsService->section_one_description??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper">
                                                            <div class="txt_field">
                                                                <label>Image</label>
                                                                <div class="image-input @if(optional($cmsService)->section_one_image) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsService->section_one_image??'about_us_hero_img.png'}}">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="section_one_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="section_one_wrapper">
                                                <h2>Section 02: Services</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="section_two_heading" class="form-control summer_note">{{$cmsService->section_two_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Description</label>
                                                            <textarea rows="5" name="section_two_description" class="form-control summer_note" placeholder="">{{$cmsService->section_two_description??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper">
                                                            <div class="txt_field">
                                                                <label>Image</label>
                                                                <div class="image-input @if(optional($cmsService)->section_two_image) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsService->section_two_image??'about_us_hero_img.png'}}">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="section_two_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cms_submit_btn_wrapper">
                                                <button type="button" class="btn_global btn_grey">Cancel<i class="fa-solid fa-xmark"></i></button>
                                                <button type="submit" class="btn_global btn_sky_blue">Save Changes</button>

                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <div class="tab-pane fade @if(session('key') == 'blog') active show @endif" id="blogs-tab-pane" role="tabpanel" aria-labelledby="blogs-tab" tabindex="0">
                                    <form method="post" action="{{ route('cms_blog') }}" class="form-horizontal" id="validateBlog" enctype="multipart/form-data">
                                        @csrf
                                        <div class="cms_whole_wrapper append_cms_blogs_wrapper">
                                            <div class="blogs_append_wrapper">
                                                @if(!empty($cmsBlog) && $cmsBlog->count() > 0)
                                                    @foreach ($cmsBlog as $index => $blog)
                                                        <div class="section_blog_wrapper section_one_wrapper section_one_wrapper_blog_remove">
                                                            <input type="hidden" name="blogs[{{ $index + 1 }}][id]" value="{{ $blog->id }}">
                                                            @if($index > 0)
                                                            <a class="cross_append_functionality_blogs" href="javascript:void(0)">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </a>
                                                            @endif
                                                            <h2>Blog {{ $index + 1 }}</h2>
                                                            <div class="row custom_row">
                                                                <div class="col-md-12">
                                                                    <div class="txt_field">
                                                                        <label>Heading</label>
                                                                        <input type="text" name="blogs[{{ $index + 1 }}][heading]" required class="form-control" value="{{ $blog->heading }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="txt_field">
                                                                        <label>Description</label>
                                                                        <textarea rows="5" name="blogs[{{ $index + 1 }}][description]" required class="form-control">{{ $blog->description }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="blog_images_wrapper">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="cms_img_wrapper">
                                                                                    @foreach($blog->blogImage as $key => $image)
                                                                                    <div class="txt_field">
{{--                                                                                        <input type="hidden" name="blogs[{{ $key + 1 }}][image][][id]" value="{{ $image->id }}">--}}
{{--                                                                                        <input type="hidden" name="blogs[{{ $key + 1 }}][image][][path]" value="{{ $image->image }}">                                                                                        <div class="custom_justify">--}}
                                                                                        <div class="custom_justify">
                                                                                            <label>Image</label>
{{--                                                                                            @if($key > 0)--}}
                                                                                            <button type="button" class="btn_remove_image_container"><i class="fa-solid fa-minus"></i></button>
{{--                                                                                            @endif--}}
                                                                                        </div>

                                                                                        <div class="image-input image-input-circle" data-kt-image-input="true">
                                                                                            <div class="image-input-wrapper">
                                                                                                <img class="input_image_field" src="{{ $image->image ? asset('website/' . $image->image) : asset('website/assets/images/service_img1.png') }}">
                                                                                            </div>
                                                                                            <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                                                   data-kt-image-input-action="change">
                                                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                                                                <input type="file"  name="blogs[{{ $index + 1 }}][image][]" accept=".png, .jpg, .jpeg, .webp" class="myinput custom_file_input"/>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <button type="button" class="btn_global btn_dark_blue add_more_images" data-index="{{$index+1}}">Add Image</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="section_blog_wrapper section_one_wrapper">
                                                        <h2>Blog 1</h2>
                                                        <div class="row custom_row">
                                                            <div class="col-md-12">
                                                                <div class="txt_field">
                                                                    <label>Heading</label>
                                                                    <input type="text" name="blogs[1][heading]" class="form-control" required placeholder="Enter heading">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="txt_field">
                                                                    <label>Description</label>
                                                                    <textarea rows="5" name="blogs[1][description]" class="form-control" required placeholder="Enter description"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="blog_images_wrapper">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="cms_img_wrapper">
                                                                                <div class="txt_field">
                                                                                    <label>Image</label>
                                                                                    <div class="image-input image-input-circle" data-kt-image-input="true">
                                                                                        <div class="image-input-wrapper">
                                                                                            <img class="input_image_field" src="{{asset('website/assets/images/service_img1.png')}}">
                                                                                        </div>
                                                                                        <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                                               data-kt-image-input-action="change">
                                                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                                                            <input type="file" name="blogs[1][image][]" accept=".png, .jpg, .jpeg, .webp" class="myinput custom_file_input"/>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <button type="button" class="btn_global btn_dark_blue add_more_images" data-index="1">Add Image</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="add_more_cms_bogs_btn_wrapper">
                                                <button type="button" class="btn_global btn_sky_blue add_more_cms_blogs">Add more <i class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="cms_submit_btn_wrapper">
                                            <button type="button" class="btn_global btn_grey">Cancel <i class="fa-solid fa-xmark"></i></button>
                                            <button type="submit" class="btn_global btn_sky_blue">Save Changes</button>
                                        </div>
                                    </form>
                                </div>


                                <div class="tab-pane fade @if(session('key') == 'contact') active show @endif" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                                    <form method="post" action="{{ route('cms_contact') }}" class="form-horizontal" id="validateContact" enctype="multipart/form-data">
                                        @csrf
                                        <div class="cms_whole_wrapper">
                                            <div class="section_one_wrapper">
                                                <h2>Section 01: Contact Us</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea name="section_one_heading" id="section_one_heading" class="form-control summer_note">{{$cmsContact->section_one_heading ?? ''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Description</label>
                                                            <textarea rows="5" name="section_one_description" class="form-control summer_note" placeholder="">{{$cmsContact->section_one_description??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper cms_icon_wrapper">
                                                            <div class="txt_field">
                                                                <label>Icon</label>
                                                                <div class="image-input @if(optional($cmsContact)->section_one_icon) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsContact->section_one_icon??'cms_profile_icon.svg'}}">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="section_one_icon" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h2>Section 02</h2>
                                                <div class="row custom_row">
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Heading</label>
                                                            <textarea type="text" name="section_two_heading" class="form-control summer_note">{{$cmsContact->section_two_heading??''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="txt_field">
                                                            <label>Phone</label>
                                                            <input type="text" id="phoneInput" name="section_two_phone" class="form-control"
                                                                   value="{{$cmsContact->section_two_phone??''}}" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="cms_img_wrapper cms_icon_wrapper">
                                                            <div class="txt_field">
                                                                <label>Icon</label>
                                                                <div class="image-input @if(optional($cmsContact)->section_two_icon) image-input-circle @endif" data-kt-image-input="true">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper">
                                                                        <img class="input_image_field" src="{{ asset('website') }}/{{$cmsContact->section_two_icon??'cms_profile_icon.svg'}}">
                                                                    </div>
                                                                    <!--end::Image preview wrapper-->

                                                                    <!--begin::Edit button-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                                           data-kt-image-input-action="change"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-dismiss="click"
                                                                           title="Change avatar">
                                                                        <i class="fa-solid fa-pen-to-square"></i><span class="path1"></span><span class="path2"></span></i>

                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="section_two_icon" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
{{--                                                                        <input type="hidden" name="avatar_remove" />--}}
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Edit button-->

                                                                    <!--begin::Cancel button-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon remove_icon"
                                                                          data-kt-image-input-action="cancel"
                                                                          data-bs-toggle="tooltip"
                                                                          data-bs-dismiss="click"
                                                                          title="Cancel avatar">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                                                    <!--end::Cancel button-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="cms_submit_btn_wrapper">
                                                <button type="button" class="btn_global btn_grey">Cancel<i class="fa-solid fa-xmark"></i></button>
                                                <button type="submit" class="btn_global btn_sky_blue">Save Changes</button>

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
    </section>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        {{--$(document).ready(function() {--}}
        {{--    var imageIndex = 1;--}}
        {{--    $('.add_more_images2').click(function () {--}}
        {{--        var newImageField = `--}}
        {{--        <div class="txt_field">--}}
        {{--            <div class="custom_justify">--}}
        {{--                <label>Image</label>--}}
        {{--                <button type="button" class="btn_remove_image_container"><i class="fa-solid fa-minus"></i></button>--}}
        {{--            </div>--}}
        {{--             <div class="image-input image-input-circle" data-kt-image-input="true">--}}
        {{--                                                                                <div class="image-input-wrapper">--}}
        {{--                                                                                    <img class="input_image_field" src="{{asset('website/assets/images/service_img1.png')}}">--}}
        {{--                                                                                </div>--}}
        {{--                                                                                <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"--}}
        {{--                                                                                       data-kt-image-input-action="change">--}}
        {{--                                                                                    <i class="fa-solid fa-pen-to-square"></i>--}}
        {{--                                                                                    <input type="file" name="blogs[1][image]" accept=".png, .jpg, .jpeg, .webp" class="myinput custom_file_input"/>--}}
        {{--                                                                                </label>--}}
        {{--                                                                            </div>--}}
        {{--        </div>--}}
        {{--    `;--}}
        {{--        $(this).closest('.blog_images_wrapper2').find('.row .col-md-12 .cms_img_wrapper').append(newImageField);--}}
        {{--        imageIndex++;--}}
        {{--    });--}}
        {{--    $(document).on('click', '.btn_remove_image_container', function() {--}}
        {{--        $(this).closest('.txt_field').remove();--}}
        {{--    });--}}
        {{--});--}}
    </script>
{{--    <script>--}}
{{--        $(document).ready(function() {--}}


{{--            $(document).on('click','.add_more_images',function() {--}}
{{--                var imageIndex = $(this).attr('data-index') ;--}}
{{--                var newImageField = `--}}
{{--                <div class="txt_field">--}}
{{--                    <div class="custom_justify">--}}
{{--                        <label>Image</label>--}}
{{--                        <button type="button" class="btn_remove_image_container"><i class="fa-solid fa-minus"></i></button>--}}
{{--                    </div>--}}
{{--                    <div class="image-input image-input-circle" data-kt-image-input="true">--}}
{{--                        <div class="image-input-wrapper">--}}
{{--                            <img class="input_image_field" id="blog_image_${imageIndex}" src="{{asset('website/assets/images/service_img1.png') }}">--}}
{{--                        <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change image">--}}
{{--                            <i class="fa-solid fa-pen-to-square"></i>--}}
{{--                            <input id="image_input_${imageIndex}" type="file" name="blogs[${imageIndex}][image][]" accept=".png, .jpg, .jpeg, .webp" class="myinput custom_file_input"/>--}}
{{--                        </label>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            `;--}}
{{--                $(this).closest('.blog_images_wrapper').find('.row .col-md-12 .cms_img_wrapper').append(newImageField);--}}
{{--                imageIndex++;--}}
{{--            });--}}
{{--            $(document).on('click', '.btn_remove_image_container', function() {--}}
{{--                $(this).closest('.txt_field').remove();--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
    <script>
        $(document).ready(function () {
            $('.summer_note').summernote({
                tabsize: 6,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear', 'italic']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    // ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>

    <script>
        $(document).ready(function() {


            $('.add_more_cms').click(function () {
                var txtField = $(this).closest('.txt_field').clone();
                txtField.find('input').val(' ');
                txtField.find('.add_more_cms').remove();
                $(txtField).prepend('<button type="button" class="cross_append_functionality"> <i class="fa fa-remove"></i></button>')
                $(this).closest('.more_cms_wrapper').find('.append_more_cms_wrapper').append(txtField);
            });


            $(document).on('click', '.cross_append_functionality', function() {
                $(this).closest('.txt_field').remove();
            });

            $('.add_more_cms_blogs').click(function () {
                let counter = $(document).find('.section_blog_wrapper').length ;
                console.log(counter)
                counter++;
                console.log(counter)
                $(this).closest('.append_cms_blogs_wrapper').find('.blogs_append_wrapper').append(`
        <div class="section_blog_wrapper section_one_wrapper section_one_wrapper_blog_remove">
            <a class="cross_append_functionality_blogs" href="javascript:void(0)">
                <i class="fa-solid fa-xmark"></i>
            </a>
            <h2>Blog ${counter}</h2>
            <div class="row custom_row">
                <div class="col-md-12">
                    <div class="txt_field">
                        <label>Heading</label>
                        <input type="text" name="blogs[${counter}][heading]" class="form-control" required placeholder="Type here">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="txt_field">
                        <label>Description</label>
                        <textarea rows="5" name="blogs[${counter}][description]" class="form-control" required placeholder="Type here"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="blog_images_wrapper">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="cms_img_wrapper">
                                    <div class="txt_field">
                                        <label>Image</label>
                                        <div class="image-input image-input-circle" data-kt-image-input="true">
                                            <div class="image-input-wrapper">
                                                <img class="input_image_field" src="{{ asset('website/assets/images/service_img1.png') }}">
                                            </div>
                                            <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                   data-kt-image-input-action="change">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <input type="file" name="blogs[`+counter+`][image][]" accept=".png, .jpg, .jpeg, .webp" class="myinput custom_file_input"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn_global btn_dark_blue add_more_images" data-index="`+counter+`">Add Image</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);
            });


            $('.blogs_append_wrapper').on('click', '.cross_append_functionality_blogs', function () {
                $(this).closest('.section_one_wrapper').remove();

                let counter = 1;
                $('.section_blog_wrapper').each(function() {
                    $(this).find('h2').text('Blog ' + counter);
                    $(this).find('input[name^="blogs"]').each(function() {
                        let name = $(this).attr('name');
                        name = name.replace(/\[\d+\]/, `[${counter}]`);
                        $(this).attr('name', name);
                    });
                    $(this).find('textarea[name^="blogs"]').each(function() {
                        let name = $(this).attr('name');
                        name = name.replace(/\[\d+\]/, `[${counter}]`);
                        $(this).attr('name', name);
                    });
                    // Update the image fields to match the new blog index
                    $(this).find('input[name^="blogs["]').each(function() {
                        let name = $(this).attr('name');
                        name = name.replace(/\[\d+\]/, `[${counter}]`);
                        $(this).attr('name', name);
                    });

                    $(this).find('.add_more_images').attr('data-index', counter);
                    counter++;
                });
            });

            $(document).on('click', '.add_more_images', function() {
                var imageIndex = $(this).attr('data-index');

                var newImageField = `
            <div class="txt_field">
                <div class="custom_justify">
                    <label>Image</label>
                    <button type="button" class="btn_remove_image_container"><i class="fa-solid fa-minus"></i></button>
                </div>
                <div class="image-input image-input-circle" data-kt-image-input="true">
                    <div class="image-input-wrapper">
                        <img class="input_image_field" id="blog_image_${imageIndex}" src="{{asset('website/assets/images/service_img1.png') }}">
                    </div>
                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                           data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change image">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <input id="image_input_${imageIndex}" type="file" name="blogs[${imageIndex}][image][]" accept=".png, .jpg, .jpeg, .webp" class="myinput custom_file_input"/>
                    </label>
                </div>
            </div>
        `;

                $(this).closest('.blog_images_wrapper').find('.row .col-md-12 .cms_img_wrapper').append(newImageField);
            });

            $(document).on('click', '.btn_remove_image_container', function() {
                $(this).closest('.txt_field').remove();

                var imageIndex = 1;
                $(this).closest('.cms_img_wrapper').find('.txt_field').each(function() {
                    $(this).find('input[name^="blogs"]').each(function() {
                        var name = $(this).attr('name');
                        name = name.replace(/\[\d+\]/, `[${imageIndex}]`);
                        $(this).attr('name', name);
                    });
                    imageIndex++;
                });
            });


            $(document).on('change', '.custom_file_input', function() {
                var input = $(this);
                var img = input.closest('.image-input').find('.input_image_field');
                var file = this.files[0];

                if (file) {
                    if (file.type.startsWith('image/') || file.type === 'image/svg+xml') {
                        img.attr('src', URL.createObjectURL(file));
                    } else {
                        alert("Please select a valid image file or SVG.");
                        input.val('');
                    }
                }
            });

            $(document).on('click', '[data-kt-image-input-action="cancel"]', function() {
                var img = $(this).closest('.image-input').find('.input_image_field');
                var originalSrc = img.attr('data-original-src');
                img.attr('src', originalSrc);
            });

        });
    </script>
    <script>
        const phoneInput = document.getElementById('phoneInput');

        function formatPhoneNumber(value) {
            value = value.replace(/\D/g, '');
            if (value.length > 3 && value.length <= 6) {
                value = value.replace(/(\d{3})(\d+)/, '$1-$2');
            } else if (value.length > 6) {
                value = value.replace(/(\d{3})(\d{3})(\d+)/, '$1-$2-$3');
            }
            return value;
        }

        if (phoneInput.value) {
            phoneInput.value = formatPhoneNumber(phoneInput.value);
        }

        phoneInput.addEventListener('input', function (e) {
            e.target.value = formatPhoneNumber(e.target.value);
        });

        phoneInput.form.addEventListener('submit', function () {
            phoneInput.value = phoneInput.value.replace(/\D/g, '');
        });
    </script>
@endpush
