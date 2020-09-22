@extends('layouts.legacy')

@section('pageName','User list')

@section('body')

    <form action="#" method="POST" class="card was-validated shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <div style="min-width: 10vw;">
                <a href="{{ route('admin.user.list') }}" class="btn btn-outline-light btn-sm btn-block">
                    <i class="fas fa-caret-square-left"></i>
                </a>
            </div>
            <span>Register</span>
            <div style="min-width: 10vw;">
            </div>
        </div>
        <div class="card-body">


            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-user-tag"></i>
                    <small>User Level</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="admin" name="admin" value="1">
                                <label class="form-check-label" for="admin">Admin</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="broker" name="broker" value="1">
                                <label class="form-check-label" for="broker">Broker</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="realtor" name="realtor" value="1">
                                <label class="form-check-label" for="realtor">Realtor</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3"></div>
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-user-plus"></i>
                    <small>Personal access</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="name" class="text-primary">Name</label>
                                <input type="text" minlength="5" maxlength="250" class="form-control form-control-sm" id="name" name="name" aria-describedby="name" placeholder="Enter the user name" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="email" class="text-primary">E-mail</label>
                                <input type="email" minlength="5" maxlength="250" class="form-control form-control-sm" id="email" name="email" aria-describedby="email" placeholder="E-mail will be used for access" required>
                            </div>
                        </div>
        
                        <div class="col-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label for="license" class="text-primary">License</label>
                                <input type="text" minlength="2" maxlength="250" class="form-control form-control-sm" id="license" name="license" aria-describedby="license" placeholder="License">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="password" class="text-primary">Password</label>
                                <input type="password" minlength="2" maxlength="16" class="form-control form-control-sm" id="password" name="password" aria-describedby="password" placeholder="password" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="id_user_recommend" class="text-primary">Recommended by</label>
                                <select id="id_user_recommend" name="id_user_recommend" class="form-control form-control-sm">
                                    <option value="" selected>No recommendation</option>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="percent" class="text-primary">Percentage by indication</label>
                                <input type="number" step="0.01" min="0" max="60" class="form-control form-control-sm" id="percent" name="percent" aria-describedby="percent" placeholder="Percentage by indication" value="0.00" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="mt-3"></div>
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-house-user"></i>
                    <small>Address</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="addressAdd" class="text-primary">Address</label>
                                <input type="text" minlength="5" maxlength="150" class="form-control form-control-sm" id="addressAdd" name="addressAdd" aria-describedby="addressAdd" placeholder="Enter the user's address">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="postal_codeAdd" class="text-primary">Postal Code</label>
                                <input type="number" min="0" max="99999999" class="form-control form-control-sm" id="postal_codeAdd" name="postal_codeAdd" aria-describedby="postal_code" placeholder="Postal code">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="cityAdd" class="text-primary">City</label>
                                <input type="text" minlength="3" maxlength="150" class="form-control form-control-sm" id="cityAdd" name="cityAdd" aria-describedby="city" placeholder="City">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="stateAdd" class="text-primary">State</label>
                                <input type="text" minlength="3" maxlength="150" class="form-control form-control-sm" id="stateAdd" name="stateAdd" aria-describedby="state" placeholder="State">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="countryAdd" class="text-primary">Country</label>
                                <input type="text" minlength="3" maxlength="150" class="form-control form-control-sm" id="countryAdd" name="countryAdd" aria-describedby="country" placeholder="Country" value="USA">
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-sm btn-block" onclick="addAddress();">Add address</button>
                        <div class="col-12 text-center text-primary"><small>Only the content below will be taken to the register</small></div>

                        <div class="col-12 mt-4">
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
            </div>

            <div class="mt-3"></div>
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-house-user"></i>
                    <small>Phone</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="referenceAdd" class="text-primary">Reference</label>
                                <input type="text" minlength="0" maxlength="150" class="form-control form-control-sm" id="referenceAdd" name="referenceAdd" aria-describedby="Reference" placeholder="Who will be communicated">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label for="ddiAdd" class="text-primary">DDI</label>
                                <input type="number" min="0" max="999" class="form-control form-control-sm" id="ddiAdd" name="ddiAdd" aria-describedby="DDI" placeholder="DDI" value="1">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label for="dddAdd" class="text-primary">DDD</label>
                                <input type="number" min="0" max="999" class="form-control form-control-sm" id="dddAdd" name="dddAdd" aria-describedby="DDD" placeholder="DDD">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="phoneAdd" class="text-primary">Phone</label>
                                <input type="tel" min="0" max="99999999999" class="form-control form-control-sm" id="phoneAdd" name="phoneAdd" aria-describedby="Phone" placeholder="Phone">
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-sm btn-block" onclick="addPhone()">Add phone</button>
                        <div class="col-12 text-center text-primary"><small>Only the content below will be taken to the register</small></div>

                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" id="tablePhone">
                                    <thead>
                                        <tr>
                                            <th><small>Reference</small></th>
                                            <th><small>DDI</small></th>
                                            <th><small>DDD</small></th>
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
    </form>

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
                return;
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
            var reference   =   document.getElementById('referenceAdd').value;
            var ddi         =   document.getElementById('ddiAdd').value;
            var ddd         =   document.getElementById('dddAdd').value;
            var phone       =   document.getElementById('phoneAdd').value;

            if(reference == '' || ddi == '' || ddd == '' || phone == '') {
                alert('Fill out the form correctly!');
                return;
            } // if(reference == '' || ddi == '' || ddd == '' || phone == '') { ... }

            // Clear data form
            document.getElementById('ddiAdd').value     =   null;
            document.getElementById('dddAdd').value     =   null;
            document.getElementById('phoneAdd').value   =   null;

            var tableRef        =   document.getElementById('tablePhone').getElementsByTagName('tbody')[0];
            var newRow          =   tableRef.insertRow();

            var newCell         =   newRow.insertCell(0);
            newCell.innerHTML   =   '<input type="text" readonly class="form-control-plaintext" name="ddi[]" value="' + ddi + '">';

            var newCell         =   newRow.insertCell(1);
            newCell.innerHTML   =   '<input type="text" readonly class="form-control-plaintext" name="ddd[]" value="' + ddd + '">';

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