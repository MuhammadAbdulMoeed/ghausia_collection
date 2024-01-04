@extends('frontend.layouts.master')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Women Category</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Contact -->
    <section class="small-banner section mb-5 mt-5">
        <div class="container ">
            <div class="row">
                @if($subCategory->count()>0)
                    @foreach($subCategory as $sub)
                        <div class="col-lg-6 col-md-6 col-12 mb-4">
                            <div class="single-banner grid-cat">
                                <a href="{{route('product-grids',['childCatId'=>$sub->id])}}"
                                   class="image-zoom-link">
                                    <img src="{{asset($sub->photo?:'backend/img/thumbnail-default.jpg')}}" alt=""
                                         class="cat-img">
                                </a>
                                <div class="content">
                                    <h3><a href="{{route('product-grids',['childCatId'=>$sub->id])}}" class="mt-0 pb-2 pt-1">{{$sub->title ?? ""}}</a></h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!--/ End Contact -->

    <!-- Start Shop Newsletter  -->
    @include('frontend.layouts.newsletter')
    <!-- End Shop Newsletter -->
    <!--================Contact Success  =================-->
    <div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-success">Thank you!</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-success">Your message is successfully sent...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals error -->
    <div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-warning">Sorry!</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-warning">Something went wrong.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .modal-dialog .modal-content .modal-header {
            position: initial;
            padding: 10px 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .modal-dialog .modal-content .modal-body {
            height: 100px;
            padding: 10px 20px;
        }

        .modal-dialog .modal-content {
            width: 50%;
            border-radius: 0;
            margin: auto;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('frontend/js/contact.js') }}"></script>
@endpush
