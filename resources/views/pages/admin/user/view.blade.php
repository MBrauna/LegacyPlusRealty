@extends('layouts.legacy')

@section('pageName','Register user')

@section('body')

    <div class="card shadow-sm">
        @csrf
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <div style="min-width: 10vw;">
                <a href="{{ route('admin.user.list') }}" class="btn btn-outline-light btn-sm btn-block">
                    <i class="fas fa-caret-square-left"></i>
                </a>
            </div>
            <span>{{ $user->name }}</span>
            <div style="min-width: 10vw;">
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" value="{{ $user->id }}" name="idUser">

            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-user-tag"></i>
                    <small>User Level</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="id_user_type" class="text-primary">User level</label>
                                <select id="id_user_type" name="id_user_type" class="form-control form-control-sm" disabled>
                                    @if($user->id_user_type == '' || is_null($user->id_user_type))
                                        <option value="" selected>None</option>
                                    @else
                                        <option value="">None</option>
                                    @endif

                                    @foreach ($type as $item)
                                        @if($user->id_user_type == $item->id_user_type)
                                            <option value="{{ $item->id_user_type }}" selected>{{ $item->description }}</option>
                                        @else
                                            <option value="{{ $item->id_user_type }}">{{ $item->description }}</option>
                                        @endif

                                    @endforeach
                                </select>
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
                                <label for="email" class="text-primary">E-mail</label>
                                <input type="email" minlength="5" maxlength="250" class="form-control form-control-sm form-control-plaintext" id="email" name="email" aria-describedby="email" placeholder="E-mail will be used for access" value="{{ $user->email }}" disabled>
                            </div>
                        </div>
        
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="password" class="text-primary">Password</label>
                                <input type="password" minlength="4" maxlength="16" class="form-control form-control-sm form-control-plaintext" id="password" name="password" aria-describedby="password" placeholder="password" disabled>
                                <small id="password" class="form-text text-muted">Keep it blank to stay with the current password</small>
                            </div>
                        </div>


                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name" class="text-primary">First name</label>
                                <input type="text" minlength="2" maxlength="250" class="form-control form-control-sm form-control-plaintext" id="name" name="name" aria-describedby="name" placeholder="Enter the user name" value="{{ $user->first_name }}" disabled>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="second_name" class="text-primary">Middle name</label>
                                <input type="text" minlength="2" maxlength="250" class="form-control form-control-sm form-control-plaintext" id="second_name" name="second_name" aria-describedby="name" placeholder="Enter the second name" value="{{ $user->second_name }}" disabled>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="last_name" class="text-primary">Last name</label>
                                <input type="text" minlength="2" maxlength="250" class="form-control form-control-sm form-control-plaintext" id="last_name" name="last_name" aria-describedby="name" placeholder="Enter the last name" value="{{ $user->last_name }}" disabled>
                            </div>
                        </div>


                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="license" class="text-primary">License</label>
                                <input type="text" minlength="2" maxlength="250" class="form-control form-control-sm form-control-plaintext" id="license" name="license" aria-describedby="license" placeholder="License"  value="{{ $user->license }}" disabled>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="license_expiration" class="text-primary">License expiration</label>
                                <input type="date" class="form-control form-control-sm form-control-plaintext" id="license_expiration" name="license_expiration" aria-describedby="license_expiration" placeholder="License expiration date"  value="{{ $user->license_date }}" disabled>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="license_due" class="text-primary">Fee due date</label>
                                <input type="date" class="form-control form-control-sm form-control-plaintext" id="license_due" name="license_due" aria-describedby="license_due" placeholder="wiser broker fee due date" value="{{ $user->license_due }}" disabled>
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="id_user_recommend" class="text-primary">Indicated by</label>
                                <select id="id_user_recommend" name="id_user_recommend" class="form-control form-control-sm form-control-plaintext" disabled>
                                    <option value="">No recommendation</option>
                                    @foreach ($users as $item)
                                        @if($user->id_user_recommend == $item->id)
                                            <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="percent" class="text-primary">Percentage indication</label>
                                <input type="number" step="0.01" min="0" max="60" class="form-control form-control-sm text-right percent" id="percent" name="percent" aria-describedby="percent" placeholder="Percentage by indication" value="{{ number_format($user->percent,2,'.',',') }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="mt-3"></div>
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-comments-dollar"></i>
                    <small>Commission</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 border-primary">
                            <h6 class="text-center text-white bg-primary"><small>Sale</small></h6>
                            <div class="row">
                                <div class="col-12 mt-4">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover" id="tableSale">
                                            <thead>
                                                <tr>
                                                    <th><small>From (US$)</small></th>
                                                    <th><small>To (US$)</small></th>
                                                    <th><small>Split to agent</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($usercomp as $item)
                                                    @if($item->id_transaction_type == 1)
                                                        <tr>
                                                            <td><input type="number" min="0" max="100" step="0.01" readonly class="form-control-plaintext" name="min_sale[]" value="{{ $item->min_value }}"></td>
                                                            <td><input type="number" min="0" max="100" step="0.01" readonly class="form-control-plaintext" name="max_sale[]" value="{{ $item->max_value }}"></td>
                                                            <td><input type="number" min="0" max="100" step="0.01" readonly class="form-control-plaintext" name="perc_rent[]" value="{{ $item->percentual }}"></td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                            <h6 class="text-center text-white bg-primary"><small>Rent</small></h6>
                            <div class="row">
                                <div class="col-12 mt-4">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover" id="tableRent">
                                            <thead>
                                                <tr>
                                                    <th><small>From (US$)</small></th>
                                                    <th><small>To (US$)</small></th>
                                                    <th><small>Split to agent</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($usercomp as $item)
                                                    @if($item->id_transaction_type == 2)
                                                        <tr>
                                                            <td><input type="number" min="0" max="100" step="0.01" readonly class="form-control-plaintext" name="min_rent[]" value="{{ $item->min_value }}"></td>
                                                            <td><input type="number" min="0" max="100" step="0.01" readonly class="form-control-plaintext" name="max_rent[]" value="{{ $item->max_value }}"></td>
                                                            <td><input type="number" min="0" max="100" step="0.01" readonly class="form-control-plaintext" name="perc_rent[]" value="{{ $item->percentual }}"></td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="mt-3"></div>
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-users"></i>
                    <small>Group</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mt-4">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" id="tableGroup">
                                    <thead>
                                        <tr>
                                            <th><small>Group</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($group as $item)
                                            <tr>
                                                <td><small>{{ $item->name }}</small></td>
                                            </tr>
                                        @endforeach
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
                    <small>Address</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mt-4">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" id="tableAddress">
                                    <thead>
                                        <tr>
                                            <th><small>Address</small></th>
                                            <th><small>City</small></th>
                                            <th><small>State</small></th>
                                            <th><small>Country</small></th>
                                            <th><small>Zip Code</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($address as $item)
                                            <tr>
                                                <th><small><input type="text" readonly class="form-control-plaintext" name="address[]" value="{{ $item->address }}"></small></th>
                                                <th><small><input type="text" readonly class="form-control-plaintext" name="city[]" value="{{ $item->city }}"></small></th>
                                                <th><small><input type="text" readonly class="form-control-plaintext" name="state[]" value="{{ $item->state }}"></small></th>
                                                <th><small><input type="text" readonly class="form-control-plaintext" name="country[]" value="{{ $item->country }}"></small></th>
                                                <th><small><input type="text" readonly class="form-control-plaintext" name="postal_code[]" value="{{ $item->zip_code }}"></small></th>
                                            </tr>
                                        @endforeach
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
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" id="tablePhone">
                                    <thead>
                                        <tr>
                                            <th><small>Reference</small></th>
                                            <th><small>Phone</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($phone as $item)
                                        <tr>
                                            <th><small><input type="text" readonly class="form-control-plaintext" name="reference[]" value="{{ $item->reference }}"></small></th>
                                            <th><small><input type="text" readonly class="form-control-plaintext" name="phone[]" value="{{ $item->phone }}"></small></th>
                                        </tr>
                                        @endforeach
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
                    <small>Files</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('archive.import') }}" enctype="multipart/form-data" class="dropzone border-primary was-validated" id="dropzone">
                        @csrf
                        <input type="hidden" name="legacy_type" value="4">
                        <input type="hidden" name="idUser" value="{{ $user->id }}">
                        <div class="fallback">
                            <input name="fileToUpload[]" type="file" multiple />
                        </div>
                    </form>
                    <div class="row">
                        <ul class="list-group col-12">
                            @if(count($archive) <= 0)
                                <li class="list-group-item text-center">
                                    No files
                                </li>
                            @else
                                @foreach ($archive as $item)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-10 col-sm-10 col-md-10 col-lg-11">
                                            <a href="{{ Storage::url($item->repository.'/'.$item->name_server) }}">
                                                <i class="fas fa-file-invoice"></i> - {{ $item->name_file }}
                                            </a>
                                        </div>
                                        <div class="col-2 col-sm-2 col-md-2 col-lg-1">
                                            <button class="btn btn-sm btn-primary btn-block">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @endif
                            
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    

@endsection

@section('layout')
    <link href="/legacy/vendor/dropzone/dist/dropzone.css" rel="stylesheet">
@endsection

@section('script')
    <script src="/legacy/vendor/jquery-mask/dist/jquery.mask.min.js"></script>
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

            // Validate length for inputs
            if(address.length < 0 || address.length > 250) {
                alert('The content of the address field does not conform to valid parameters.');
                return false;
            } // if(city.length < 0 || city.length > 250) { ... }

            if(city.length < 0 || city.length > 250) {
                alert('The content of the city field does not conform to valid parameters.');
                return false;
            } // if(city.length < 0 || city.length > 250) { ... }

            if(state.length < 0 || state.length > 250) {
                alert('The content of the state field does not conform to valid parameters.');
                return false;
            } // if(city.length < 0 || city.length > 250) { ... }

            if(country.length < 0 || country.length > 250) {
                alert('The content of the country field does not conform to valid parameters.');
                return false;
            }

            if(postal_code < 0 || postal_code > 999999999) {
                alert('The content of the zip code field does not conform to valid parameters.');
                return false;
            }

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

            if(reference == '' || phone == '') {
                alert('Fill out the form correctly!');
                return;
            } // if(reference == '' || ddi == '' || ddd == '' || phone == '') { ... }

            if(phone < 0 || phone > 99999999999999) {
                alert('Invalid phone number!');
                return false;
            } // if(phone < 0 || phone > 99999999999999) { ... }

            // Clear data form
            document.getElementById('referenceAdd').value   =   null;
            //document.getElementById('ddiAdd').value         =   null;
            //document.getElementById('dddAdd').value         =   null;
            document.getElementById('phoneAdd').value       =   null;

            var tableRef        =   document.getElementById('tablePhone').getElementsByTagName('tbody')[0];
            var newRow          =   tableRef.insertRow();

            var newCell         =   newRow.insertCell(0);
            newCell.innerHTML   =   '<input type="text" readonly class="form-control-plaintext" name="reference[]" value="' + reference + '">';

            var newCell         =   newRow.insertCell(1);
            newCell.innerHTML   =   '<input type="hidden" readonly class="form-control-plaintext" name="ddi[]" value="' + ddi + '">';

            var newCell         =   newRow.insertCell(2);
            newCell.innerHTML   =   '<input type="hidden" readonly class="form-control-plaintext" name="ddd[]" value="' + ddd + '">';

            var newCell         =   newRow.insertCell(3);
            newCell.innerHTML   =   '<input type="text" readonly class="form-control-plaintext" name="phone[]" value="' + phone + '">';

            var newCell         =   newRow.insertCell(4);
            newCell.innerHTML   =   '<button class="btn btn-primary btn-sm" onClick="deleteNode(this);"><i class="fas fa-trash"></i></button>';
        } // function addPhone(data) { ... }


        function addGroup() {
            var groupID     =   document.getElementById('id_groupAdd').options[document.getElementById('id_groupAdd').selectedIndex].value;
            var groupName   =   document.getElementById('id_groupAdd').options[document.getElementById('id_groupAdd').selectedIndex].text;

            if(groupID == '') {
                alert('Fill out the form correctly!');
                return;
            } // if(reference == '' || ddi == '' || ddd == '' || phone == '') { ... }

            // Clear data form
            document.getElementById('id_groupAdd').value    =   '';

            var tableRef        =   document.getElementById('tableGroup').getElementsByTagName('tbody')[0];
            var newRow          =   tableRef.insertRow();

            var newCell         =   newRow.insertCell(0);
            newCell.innerHTML   =   '<input type="hidden" readonly class="form-control-plaintext" name="id_group[]" value="' + groupID + '"><input type="text" readonly class="form-control-plaintext" value="' + groupName + '">';

            var newCell         =   newRow.insertCell(1);
            newCell.innerHTML   =   '<button class="btn btn-primary btn-sm" onClick="deleteNode(this);"><i class="fas fa-trash"></i></button>';
        } // function addPhone(data) { ... }

        function addRent() {
            var minRent     =   document.getElementById('min_rent').value;
            var maxRent     =   document.getElementById('max_rent').value;
            var percRent    =   document.getElementById('percent_rent').value;

            if(minRent == '' || maxRent == '' || percRent == '') {
                alert('Fill out the form correctly!');
                return false;
            } // if(saleMinRent == '' || saleMaxRent == '' || percRent == '') {

            if(minRent < 0 || minRent > 999999999999) {
                alert('Content must be between US$ 0 and US$ 999999999999');
                return false;
            }

            if(maxRent < 0 || maxRent > 999999999999) {
                alert('Content must be between US$ 0 and US$ 999999999999');
                return false;
            }

            if(percRent < 0 || percRent > 100) {
                alert('Content must be between 0% and 100%');
                return false;
            }

            // Clear data form
            document.getElementById('percent_rent').value   =   '0.00';
            document.getElementById('min_rent').value       =   maxRent;
            document.getElementById('max_rent').value       =   '0.00';

            var tableRef        =   document.getElementById('tableRent').getElementsByTagName('tbody')[0];
            var newRow          =   tableRef.insertRow();

            var newCell         =   newRow.insertCell(0);
            newCell.innerHTML   =   '<input type="number" min="0" max="999999999999" step="0.01" readonly class="form-control-plaintext" name="min_rent[]" value="' + minRent + '">';

            var newCell         =   newRow.insertCell(1);
            newCell.innerHTML   =   '<input type="number" min="0" max="999999999999" step="0.01" readonly class="form-control-plaintext" name="max_rent[]" value="' + maxRent + '">';

            var newCell         =   newRow.insertCell(2);
            newCell.innerHTML   =   '<input type="number" min="0" max="100" step="0.01" readonly class="form-control-plaintext" name="perc_rent[]" value="' + percRent + '">';

            var newCell         =   newRow.insertCell(3);
            newCell.innerHTML   =   '<button class="btn btn-primary btn-sm" onClick="deleteNode(this);"><i class="fas fa-trash"></i></button>';
        } // function addPhone(data) { ... }


        function addSale() {
            var minSale     =   document.getElementById('min_sale').value;
            var maxSale     =   document.getElementById('max_sale').value;
            var percSale    =   document.getElementById('percent_sale').value;

            if(minSale == '' || maxSale == '' || percSale == '') {
                alert('Fill out the form correctly!');
                return;
            } // if(saleMinRent == '' || saleMaxRent == '' || percRent == '') {

            if(minSale < 0 || minSale > 999999999999) {
                alert('Content must be between US$ 0 and US$ 999999999999');
                return false;
            }

            if(maxSale < 0 || maxSale > 999999999999) {
                alert('Content must be between US$ 0 and US$ 999999999999');
                return false;
            }

            if(percSale < 0 || percSale > 100) {
                alert('Content must be between 0% and 100%');
                return false;
            }

            // Clear data form
            document.getElementById('percent_sale').value   =   '0.00';
            document.getElementById('min_sale').value       =   maxSale;
            document.getElementById('max_sale').value       =   '0.00';

            var tableRef        =   document.getElementById('tableSale').getElementsByTagName('tbody')[0];
            var newRow          =   tableRef.insertRow();

            var newCell         =   newRow.insertCell(0);
            newCell.innerHTML   =   '<input type="number" min="0" max="999999999999" step="0.01" readonly class="form-control-plaintext" name="min_sale[]" value="' + minSale + '">';

            var newCell         =   newRow.insertCell(1);
            newCell.innerHTML   =   '<input type="number" min="0" max="999999999999" step="0.01" readonly class="form-control-plaintext" name="max_sale[]" value="' + maxSale + '">';

            var newCell         =   newRow.insertCell(2);
            newCell.innerHTML   =   '<input type="number" min="0" max="100" step="0.01" readonly class="form-control-plaintext" name="perc_sale[]" value="' + percSale + '">';

            var newCell         =   newRow.insertCell(3);
            newCell.innerHTML   =   '<button class="btn btn-primary btn-sm" onClick="deleteNode(this);"><i class="fas fa-trash"></i></button>';
        } // function addPhone(data) { ... }

        function deleteNode(btn) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
        } // function deleteNode(btn) { ... }

        $(document).ready(function(){
            $('.percent').mask('000.00', {
                reverse: true,
            });
        });
    </script>
    <script src="/legacy/vendor/dropzone/dist/dropzone.js"></script>
    <script type="text/javascript">
        Dropzone.options.dropzone = {
            maxFilesize: 12,
            addRemoveLinks: false,
            timeout: 5000,
            parallelUploads:10,
            dictDefaultMessage: "Drop files here to upload on Legacy Plus Realty",
            success: function(file, response) {
                location.reload();
            },
        };
    </script>
@endsection