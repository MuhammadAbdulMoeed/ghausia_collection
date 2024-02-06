@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')



<style type="text/css">
  .top-header-info{
    background: rgba(0, 0, 0, 0.04);
    padding: 10px;
    border-radius: 10px;
  }
  .product-details-placeholder{
    background: #fff;
    padding: 40px 0px;
  }
  .header-h h5{
    color: #000;
    font-size: 18px;
    text-transform: uppercase;
    font-weight: 700;
  }
  .single-product-detail-list label{
    margin-right: 10px;
    position: relative;
    top: 2px;
  }
  .single-product-detail-list li{
    /*background: rgba(0, 0, 0,0.05);*/
    padding: 2px 0px;
  }
  .status-wrapper{
    text-align: right;
  }
  @media(min-width:320px) and (max-width:767px){
.status-wrapper{
    text-align: left;
  }
}
</style>

<div class="product-details-placeholder">
  <div class="">
    <div class="container-fluid">
      <!-- Top Info Row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="top-header-info">
            <div class="row align-items-center">
              <div class="col-lg-6">
                <div class="header-h">
                  <h5 class="mb-0"> @if($order)Order ID: {{$order->id}}@endif</h5>
                </div>    
              </div>
              <div class="col-lg-6">
                <div class="download-btn status-wrapper">
                  <a href="{{route('order.pdf',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Starter Order info -->
      @if($order)
      <div class="row">
        <div class="col-lg-12">
          <div class="order-header-wrapper">
            <div class="row">
              <div class="col-6 mt-3">
                <div class="single-information-wrapper">
                  <label>Order No</label>
                  <p>{{$order->order_number}}</p>
                </div>
              </div>
              <div class="col-6 mt-3">
                <div class="order-action-header">
                  <ul>
                    <li>
                      <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>    
                    </li>
                    <li>
                      <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                      </form>    
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-6 mt-2">
                <div class="single-information-wrapper">
                  <label>Name</label>
                  <p>{{$order->first_name}} {{$order->last_name}}</p>
                </div>
                <div class="single-information-wrapper mt-2">
                  <label>Email</label>
                  <p>{{$order->email}}</p>
                </div>
              </div>
              <div class="col-lg-6 mt-2">
                <div class="single-information-wrapper status-wrapper">
                  <label class="d-block text-end">Status</label>
                  @if($order->status=='new')
                  <p><span class="badge badge-primary">{{$order->status}}</span></p>
                  @elseif($order->status=='process')
                  <p><span class="badge badge-warning">{{$order->status}}</span></p>
                  @elseif($order->status=='delivered')
                  <p><span class="badge badge-success">{{$order->status}}</span></p>
                  @else
                  <p><span class="badge badge-danger">{{$order->status}}</span></p>
                  @endif

                </div>
                <div class="single-information-wrapper mt-2 status-wrapper" >
                  <label class="d-block text-end">Total Amount</label>
                  <p>Rs {{number_format($order->total_amount,2)}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Top Info Row -->
      <div class="row mt-4">
        <div class="col-lg-12">
          <div class="top-header-info">
            <div class="row align-items-center">
              <div class="col-lg-12">
                <div class="header-h">
                  <h5 class="mb-0">Order Products</h5>
                </div>    
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Order Products -->
      <div class="products-wrapper-list mt-4 mb-4">
          <ul>
            @if(isset($products))
            @foreach($products as $key=> $product)
            @php
            $images = explode(',',$product['product_image']);

            @endphp
            @if(isset($images[0]))
            <li class="mt-3">
              <div class="row align-items-center">
                <div class="col-lg-2">
                  <div class="product-img-wrapper">
                    <img src="{{asset($images[0])}}" class="img-fluid">
                  </div>
                </div>
                <div class="col-lg-10">
                  <div class="porduct-deesc-detail">
                    <div class="single-information-wrapper">
                      <p style="font-size:26px; text-transform: capitalize;">{{$product['product_title'] ?? ""}}</p>
                    </div>

                    <ul class="single-product-detail-list">
                      <li>
                        <div class="single-information-wrapper d-flex">
                          <label class="d-block text-end">Color:</label>
                          <p>{{$product['product_color'] ?? ""}}</p>
                        </div>  
                      </li>
                      <li>
                        <div class="single-information-wrapper d-flex">
                          <label class="d-block text-end">Size:</label>
                          <p>{{$product['product_size'] ?? ""}}</p>
                        </div>  
                      </li>
                      <li>
                        <div class="single-information-wrapper d-flex">
                          <label class="d-block text-end">Quantity:</label>
                          <p>{{$product['product_quantity'] ?? ""}}</p>
                        </div>  
                      </li>
                      <li>
                        <div class="single-information-wrapper d-flex">
                          <label class="d-block text-end">Price:</label>
                          <p>Rs {{$product['product_price'] ?? ""}}</p>
                        </div>  
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </li>
            @endif
            @endforeach
            @endif
          </ul>
        </div>

        <!-- Order Details -->

        <div class="row">
          <div class="col-lg-6">
            <div class="top-header-info">
              <div class="header-h">
                <h5 class="mb-0">Order Information</h5>
              </div> 
            </div>
            <ul class="order-info-list">
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Order Number</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">{{$order->order_number}}</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Order Date</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">{{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('g : i a')}}</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Quantity</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">{{$order->quantity}}</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Order Status</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">{{$order->status}}</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Shipping Charge</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">Rs {{isset($order->shipping) ? $order->shipping->price:0}}</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Coupon</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">Rs {{number_format($order->coupon,2)}}</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Total Amount</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">Rs {{number_format($order->total_amount,2)}}</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Payment Method</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">@if($order->payment_method=='cod') Cash on Delivery @else Paypal @endif</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Payment Status</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">{{$order->payment_status}}</label>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="col-lg-6">
            <div class="top-header-info">
              <div class="header-h">
                <h5 class="mb-0">SHIPPING INFORMATION</h5>
              </div> 
            </div>
            <ul class="order-info-list">
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Full Name</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">{{$order->first_name}} {{$order->last_name}}</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Email</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">{{$order->email}}</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Phone No.</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">{{$order->phone}}</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Address</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">{{$order->address1}}, {{$order->address2}}</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>City</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">{{$order->city}}</label>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="row align-items-center">
                  <div class="col-6">
                    <div class="o-info-label first-label">
                      <label>Post Code</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="o-info-label second-label" style="text-align:right;">
                      <label class="d-block">{{$order->post_code}}</label>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>

       @endif
    </div>
  </div>
</div>



  <style type="text/css">
    .order-info-list {
      list-style: none;
      padding: 0px;
      margin: 0px;
    }
    .order-info-list li{
      padding: 8px;
    }
    .order-info-list li:nth-child(even){
      background: rgba(0, 0, 0, 0.04);
      border-radius: 6px;
    }
    .o-info-label.first-label label
    {
      font-weight: 600;
      color: #858796;
      font-size: 16px;
      margin-bottom: 0px;
    }
    .o-info-label.second-label label
    {
      font-weight: 600;
      color: rgba(0, 0, 0, 0.8);
      font-size: 16px;
      margin-bottom: 0px;
      word-break: break-all;
    }
    .order-detail-wrapper{
      padding: 0px 20px;
    }
    .order-action-header{
      text-align: right;
    }
    .products-wrapper{
      background: rgba(0, 0, 0, 0.1);
      display: inline-block;
      width: 100%;
      height: 6px;
    }
    .order-action-header ul{
      list-style: none;
      padding: 0px;
      margin: 0px;
    }
    .order-action-header ul li{
      display: inline-block;
    }
    .single-information-wrapper label{
      font-weight: 700 !important;
      text-transform: uppercase;
      color: #858796;
      font-size: 14px;
      margin-bottom: 0px;
    }
    .single-information-wrapper p{
      color: rgba(0, 0, 0, 0.8);
      font-weight: 700;
      margin-bottom: 0px;
    }
    .this-border{
      padding-right: 15px;
      border-right: 1px solid rgba(0, 0, 0, 0.1);
    }
    .products-wrapper-list ul {
      list-style: none;
      padding: 0px;
      margin: 0px;
    }
    .product-img-wrapper img{
      object-fit: cover;
      height: 200px;
      width: 100%;
      border-radius: 10px;
      object-position: top;
    }
  </style>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
