@extends('layouts.legacy')

@section('pageName','Profile')

@section('body')
    <div class="card border-primary shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                </div>


                <div class="col-12 col-sm-6 col-3">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input type="number" class="form-control form-control-sm" id="id" name="id" value="{{ Auth::user()->id}}" readonly>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-9">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ Auth::user()->name}}" readonly>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-6">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{ Auth::user()->email}}" readonly>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-6">
                    <div class="form-group">
                        <label for="license">License</label>
                        <input type="text" class="form-control form-control-sm" id="license" name="license" value="{{ Auth::user()->license }}" readonly>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-6">
                    <div class="form-group">
                        <label for="id_user_recommend">Recommended by</label>
                        <input type="text" class="form-control form-control-sm" id="id_user_recommend" name="id_user_recommend" value="{{ $id_user_recommend->name ?? ' -- ' }}" readonly>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-6">
                    <div class="form-group">
                        <label for="percent">Aditional comission %</label>
                        <input type="text" class="form-control form-control-sm" id="percent" name="percent" value="{{ number_format(Auth::user()->percent,2,',','.') }}" readonly>
                    </div>
                </div>
            </div>


            <div class="card border-primary shadow">
                <div class="card-header bg-primary text-white text-center">
                    Compensation
                </div>
                <div class= "card-body">
                    <ul class="list-group">
                        @forelse ($groups as $item)
                            <li class="list-group-item text-primary border-primary">
                                <div class="d-flex w-100 justify-content-between text-primary">
                                    <i class="{{ $item->icon }}">
                                    <span class="text-center">{{ $item->name}}</span>
                                    <i class="{{ $item->icon }}">
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-primary border-primary">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6><i class="fas fa-frown-open"></i></h6>
                                    <h6 class="mb-1">No compensation</h6>
                                    <h6><i class="fas fa-frown-open"></i></h6>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>


            <div class="card border-primary shadow mt-4">
                <div class="card-header bg-primary text-white text-center">
                    Address
                </div>
                <div class= "card-body">
                    <ul class="list-group">
                        @forelse ($groups as $item)
                            <li class="list-group-item text-primary border-primary">
                                <div class="d-flex w-100 justify-content-between text-primary">
                                    <i class="{{ $item->icon }}">
                                    <span class="text-center">{{ $item->name}}</span>
                                    <i class="{{ $item->icon }}">
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-primary border-primary">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6><i class="fas fa-frown-open"></i></h6>
                                    <h6 class="mb-1">No address</h6>
                                    <h6><i class="fas fa-frown-open"></i></h6>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>


            <div class="card border-primary shadow mt-4">
                <div class="card-header bg-primary text-white text-center">
                    Phone
                </div>
                <div class= "card-body">
                    <ul class="list-group">
                        @forelse ($groups as $item)
                            <li class="list-group-item text-primary border-primary">
                                <div class="d-flex w-100 justify-content-between text-primary">
                                    <i class="{{ $item->icon }}">
                                    <span class="text-center">{{ $item->name}}</span>
                                    <i class="{{ $item->icon }}">
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-primary border-primary">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6><i class="fas fa-frown-open"></i></h6>
                                    <h6 class="mb-1">No phone</h6>
                                    <h6><i class="fas fa-frown-open"></i></h6>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>


            <div class="card border-primary shadow">
                <div class="card-header bg-primary text-white text-center">
                    Groups
                </div>
                <div class= "card-body">
                    <ul class="list-group">
                        @forelse ($groups as $item)
                            <li class="list-group-item text-primary border-primary">
                                <div class="d-flex w-100 justify-content-between text-primary">
                                    <i class="{{ $item->icon }}">
                                    <span class="text-center">{{ $item->name}}</span>
                                    <i class="{{ $item->icon }}">
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-primary border-primary">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6><i class="fas fa-frown-open"></i></h6>
                                    <h6 class="mb-1">No groups</h6>
                                    <h6><i class="fas fa-frown-open"></i></h6>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection