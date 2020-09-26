@extends('layouts.legacy')

@section('pageName','Create contract')

@section('body')

    <form class="card border-primary shadow-sm needs-validation" enctype="multipart/form-data" method="POST" action="{{ route('admin.contract.add') }}">
        @csrf
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <div style="min-width: 10vw;">
                <a href="{{ route('admin.contract.list') }}" class="btn btn-outline-light btn-sm btn-block">
                    <i class="fas fa-caret-square-left"></i>
                </a>
            </div>
            <span>Create contract</span>
            <div style="min-width: 10vw;">
            </div>
        </div>
        <div class="card-body">
            <div class="row text-primary">
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select class="form-control form-control-sm" id="type" name="type" required>
                            <option value="">Select a type</option>
                            @foreach ($types as $item)
                            <option value="{{ $item->code }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="id_user_seller">Seller:</label>
                        <select class="form-control form-control-sm" id="id_user_seller" name="id_user_seller" required>
                            <option value="">Select a seller</option>
                            @foreach ($users as $item)
                            <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->allDesc->percent }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="col-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="start_contract">Start:</label>
                        <input type="date" class="form-control form-control-sm" id="start_contract" name="start_contract" min="{{ $minDate }}" required>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="end_contract">End:</label>
                        <input type="date" class="form-control form-control-sm" id="end_contract" name="end_contract" min="{{ $minDate }}" required>
                    </div>
                </div>



                <div class="col-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="value">Value:</label>
                        <input type="number" step="0.01" min="0" max="999999999999" class="form-control form-control-sm" id="value" name="value" required>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea minlength="0" maxlength="2500" class="form-control form-control-sm" name="description" id="description"></textarea>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white text-center">
                            Address register
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="addressAdd">Address:</label>
                                        <input type="text" class="form-control form-control-sm" minlength="3" maxlength="250" id="addressAdd">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="cityAdd">City:</label>
                                        <input type="text" class="form-control form-control-sm" minlength="3" maxlength="250" id="cityAdd">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="stateAdd">State:</label>
                                        <input type="text" class="form-control form-control-sm" minlength="3" maxlength="250" id="stateAdd">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="countryAdd">Country:</label>
                                        <input type="text" class="form-control form-control-sm" minlength="3" maxlength="250" id="countryAdd">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="postal_codeAdd">Postal code:</label>
                                        <input type="number" class="form-control form-control-sm" min="0" max="99999999" minlength="3" maxlength="8" id="postal_codeAdd">
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm btn-block" onclick="addAddress();">Add address</button>
                            <h6 class="text-center text-primary"><small>Only the content below will be taken to the register</small></h6>

                            <div class="table-responsive">
                                <table class="table table-sm table-hover" id="tableAddress">
                                    <thead>
                                        <tr>
                                            <th><small>Address</small></th>
                                            <th><small>City</small></th>
                                            <th><small>State</small></th>
                                            <th><small>Country</small></th>
                                            <th><small>Postal Code</small></th>
                                            <th><small>Action</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white text-center">
                            Phone register
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" class="form-control form-control-sm" min="0" max="999" minlength="0" maxlength="3" id="ddiAdd" value="0">
                                <input type="hidden" class="form-control form-control-sm" min="0" max="999" minlength="0" maxlength="3" id="dddAdd" value="1">

                                <div class="col-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="phoneAdd">Phone:</label>
                                        <input type="tel" class="form-control form-control-sm" min="0" max="999999999" minlength="0" maxlength="12" id="phoneAdd">
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm btn-block" onclick="addPhone()">Add phone</button>
                            <h6 class="text-center text-primary"><small>Only the content below will be taken to the register</small></h6>

                            <div class="table-responsive">
                                <table class="table table-sm table-hover" id="tablePhone">
                                    <thead>
                                        <tr>
                                            <th><small></small></th>
                                            <th><small></small></th>
                                            <th><small>Phone</small></th>
                                            <th><small>Action</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-primary text-white">
            <button type="submit" class="btn btn-outline-light btn-sm btn-block">Submit contract form</button>
        </div>
    </form>


@endsection

@section('layout')
    <link href="/legacy/vendor/dropzone/dist/dropzone.css" rel="stylesheet">
@endsection

@section('script')
    <script type="text/javascript">
        function addAddress(data) {
            var address         =   document.getElementById('addressAdd').value;
            var city            =   document.getElementById('cityAdd').value;
            var state           =   document.getElementById('stateAdd').value;
            var country         =   document.getElementById('countryAdd').value;
            var postal_code     =   document.getElementById('postal_codeAdd').value;

            if(address == '' || city == '' || state == '' || country == '' || postal_code == null) {
                alert('Fill out the form correctly!');
                return false;
            } // if(address == '' || city == '' || state == '' || country == '' || postal_code == null) {

            // Clear data form
            document.getElementById('addressAdd').value     =   null;
            document.getElementById('cityAdd').value        =   null;
            document.getElementById('stateAdd').value       =   null;
            document.getElementById('countryAdd').value     =   null;
            document.getElementById('postal_codeAdd').value =   null;

            var tableRef        =   document.getElementById('tableAddress').getElementsByTagName('tbody')[0];
            var newRow          =   tableRef.insertRow();

            var newCell         =   newRow.insertCell(0);
            newCell.innerHTML   =   '<input type="text" readonly class="form-control-plaintext" name="address[]" value="' + address + '">';

            var newCell         =   newRow.insertCell(1);
            newCell.innerHTML   =   '<input type="text" readonly class="form-control-plaintext" name="city[]" value="' + city + '">';

            var newCell         =   newRow.insertCell(2);
            newCell.innerHTML   =   '<input type="text" readonly class="form-control-plaintext" name="state[]" value="' + state + '">';

            var newCell         =   newRow.insertCell(3);
            newCell.innerHTML   =   '<input type="text" readonly class="form-control-plaintext" name="country[]" value="' + country + '">';

            var newCell         =   newRow.insertCell(4);
            newCell.innerHTML   =   '<input type="text" readonly class="form-control-plaintext" name="postal_code[]" value="' + postal_code + '">';

            var newCell         =   newRow.insertCell(5);
            newCell.innerHTML   =   '<button class="btn btn-primary btn-sm" onClick="deleteNode(this);"><i class="fas fa-trash"></i></button>';
        } // function addAddress(data) { ... }

        function addPhone() {
            var ddi     =   document.getElementById('ddiAdd').value;
            var ddd     =   document.getElementById('dddAdd').value;
            var phone   =   document.getElementById('phoneAdd').value;

            // Clear data form
            //document.getElementById('ddiAdd').value     =   null;
            //document.getElementById('dddAdd').value     =   null;
            document.getElementById('phoneAdd').value   =   null;

            var tableRef        =   document.getElementById('tablePhone').getElementsByTagName('tbody')[0];
            var newRow          =   tableRef.insertRow();

            var newCell         =   newRow.insertCell(0);
            newCell.innerHTML   =   '<input type="hidden" readonly class="form-control-plaintext" name="ddi[]" value="' + ddi + '">';

            var newCell         =   newRow.insertCell(1);
            newCell.innerHTML   =   '<input type="hidden" readonly class="form-control-plaintext" name="ddd[]" value="' + ddd + '">';

            var newCell         =   newRow.insertCell(2);
            newCell.innerHTML   =   '<input type="text" readonly class="form-control-plaintext" name="phone[]" value="' + phone + '">';

            var newCell         =   newRow.insertCell(3);
            newCell.innerHTML   =   '<button class="btn btn-primary btn-sm" onClick="deleteNode(this);"><i class="fas fa-trash"></i></button>';
        } // function addPhone(data) { ... }

        function deleteNode(btn) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
        } // function deleteNode(btn) { ... }
    </script>
@endsection