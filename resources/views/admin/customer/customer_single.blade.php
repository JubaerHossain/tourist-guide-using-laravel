@extends('layouts.admin')
@section('title','Customer Profile')
@section('style')
<link rel="stylesheet" href="{{asset('assets/frontend/css/guide_dash.css')}}">
    <style>
    .file-upload {
	position: relative;
	display: inline-block;
}

.file-upload__label {
  display: block;
  border-radius: .4em;
  transition: background .3s;  
  &:hover {
     cursor: pointer;
     background: #000;
  }
}    
.file-upload__input {
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    font-size: 1;
    width:0;
    height: 100%;
    opacity: 0;
  }
  .img {cursor: -webkit-grab; cursor: grab;}
</style>
@endsection
@section('content')
<div class="pb-2">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="breadcrumbs-area clearfix">
                        <ul class="breadcrumbs pull-left">
                            <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li><span>Customer profile</span></li>
                        </ul>
                        <ul class="breadcrumbs pull-right">
                            <li>
                                <button onclick="Approve({{$customer->id}})" class="btn btn-sm {{$customer->verified_at  == 0 ?'btn-info':'btn-warning'}}">
                                    {{$customer->verified_at == 0 ?'Aprrove':'Disable'}}
                                </button>
                                <form id="app-form-{{ $customer->id }}" action="{{ route('admin.customer_approve', $customer->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('POST')
                                   </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
<main role="main" class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                  </div>
            <div class="container">
                <div class="row">
                      
                  <div class="col-md-8">
                      <div class="card pb-5 p-4">
                        <h3 class="pb-4">Customer completed <span style="color:{{ $total >80 ?'green' :'crimson' }}">{{ round($total) }}%</span></h3>
                          <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{ $total }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $total }}%">
                                {{ round($total) }}%
                            </div>
                          </div>
                      </div>
                      <div class="card pt-4">
                          <div class="fb-profile pb-5">
                              <img align="left" class="fb-image-lg" src="@if($customer->back_pic != null)
                              {{ asset('customer/profile/cover/'.$customer->back_pic) }}
                              @else
                              {{asset('assets/frontend/images/bg_2.jpg')}}
                              @endif" alt="Profile image example" class="img-fluid"/>
                              <img align="left" class="fb-image-profile thumbnail" src="@if($customer->profile_pic != null)
                              {{ asset('customer/profile/'.$customer->profile_pic) }}
                              @else
                              {{asset('assets/frontend/images/avatar.jpg')}}
                              @endif" alt="Profile" width="200"/>
                              
                          </div> 
                          <div class="card-body pt-5 p-5">
                                  <h3 class="pb-2"><i class="fas fa-user pr-2"></i> {{@$customer->name}}</h3>
                                  @if (@$customer->location)                                                
                                  <p><b><i class="fas fa-map-marker-alt pr-2"></i> </b>{{@$customer->location}}</p>
                                  @endif
                                  @if (@$customer->language)                                                
                                  <p><b><i class="fas fa-globe pr-2"></i> </b> {{@$guide->language}}</p> 
                                  @endif
                                  <p><b><i class="{{@$customer->verified_at == 1?'fas fa-check-circle':'fas fa-times-circle red'}} pr-2"></i>  </b> {{@$customer->verified_at == 1 ?'Verified':'Not verified'}} </p>
                                  
                                  
                          </div> 
                           
                      </div> 
                      
                  </div>
                </div>
            </div>
</main>

@endsection
@section('script')
<script>
	function Approve(id) {
				swal({
						title: 'Are you sure?',
						text: "You won't be able to revert this!",
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes, do it!',
						cancelButtonText: 'No, cancel!',
						confirmButtonClass: 'btn btn-success',
						cancelButtonClass: 'btn btn-danger',
						buttonsStyling: false,
						reverseButtons: true
				}).then((result) => {
						if (result.value) {
								event.preventDefault();
								document.getElementById('app-form-'+id).submit();
						} else if (
								result.dismiss === swal.DismissReason.cancel
						) {
								swal(
										'Cancelled',
										'Your data is safe :)',
										'error'
								)
						}
				})
		}
</script>
@endsection