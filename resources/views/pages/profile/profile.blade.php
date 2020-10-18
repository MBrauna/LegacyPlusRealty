@extends('layouts.legacy')

@section('pageName','Profile')

@section('body')
    <form action="{{ route('admin.user.update') }}" method="POST" class="card was-validated shadow-sm" autocomplete="off">
        @csrf
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <div style="min-width: 10vw;">
            </div>
            <span>Edit {{ $user->name }}</span>
            <div style="min-width: 10vw;">
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" name="idUser" value="{{ $user->id }}">

            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-user-tag"></i>
                    <small>User Level</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="admin" name="admin" value="1" {{ $user->admin ? 'checked' : null }} disabled>
                                <label class="form-check-label" for="admin">Admin</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="broker" name="broker" value="1" {{ $user->broker ? 'checked' : null }} disabled>
                                <label class="form-check-label" for="broker">Broker</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="realtor" name="realtor" value="1" {{ $user->realtor ? 'checked' : null }} disabled>
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
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name" class="text-primary">Name</label>
                                <input type="text" minlength="2" maxlength="250" class="form-control form-control-sm" id="name" name="name" aria-describedby="name" placeholder="Enter the user name" value="{{ $user->name }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="second_name" class="text-primary">Middle name</label>
                                <input type="text" minlength="2" maxlength="250" class="form-control form-control-sm" id="second_name" name="second_name" aria-describedby="name" value="{{ $user->second_name }}" placeholder="Enter the second name">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="last_name" class="text-primary">Last name</label>
                                <input type="text" minlength="2" maxlength="250" class="form-control form-control-sm" id="last_name" name="last_name" aria-describedby="name" value="{{ $user->last_name }}" placeholder="Enter the last name" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="email" class="text-primary">E-mail</label>
                                <input type="email" minlength="5" maxlength="250" class="form-control form-control-sm" id="email" name="email" aria-describedby="email" placeholder="E-mail will be used for access" value="{{ $user->email }}" required>
                            </div>
                        </div>
        
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="license" class="text-primary">License</label>
                                <input type="text" minlength="2" maxlength="250" class="form-control form-control-sm" id="license" name="license" aria-describedby="license" placeholder="License"  value="{{ $user->license }}">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="license_expiration" class="text-primary">License expiration</label>
                                <input type="date" class="form-control form-control-sm" id="license_expiration" name="license_expiration" aria-describedby="license_expiration" placeholder="License expiration date"  value="{{ $user->license_expiration }}">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="license_due" class="text-primary">Fee due date</label>
                                <input type="date" class="form-control form-control-sm" id="license_due" name="license_due" aria-describedby="license_due" placeholder="wiser broker fee due date"  value="{{ $user->license_due }}">
                            </div>
                        </div>



                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="password" class="text-primary">Password</label>
                                <input type="password" minlength="2" maxlength="16" class="form-control form-control-sm" id="password" name="password" aria-describedby="password" placeholder="password">
                                <small id="password" class="form-text text-muted">Keep it blank to stay with the current password</small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="id_user_recommend" class="text-primary">Indicated by</label>
                                <select id="id_user_recommend" name="id_user_recommend" class="form-control form-control-sm">
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
                    <small>Comission</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($usercomp as $item)
                            @if($item->type == 1)
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="text-primary">Sale %</label>
                                        <input type="number" min="0" max="100" step="0.01"  class="form-control form-control-sm" id="perc_sale" name="perc_sale" aria-describedby="Sale" placeholder="For sale" value="{{ number_format($item->percentual,2,'.',',') }}" disabled>
                                    </div>
                                </div>
                            @else
                            <div class="col-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name" class="text-primary">Rent %</label>
                                    <input type="number" min="0" max="100" step="0.01" class="form-control form-control-sm" id="perc_rent" name="perc_rent" aria-describedby="Rent" placeholder="For rent" value="{{ number_format($item->percentual,2,'.',',') }}" disabled>
                                </div>
                            </div>
                            @endif
                        @empty
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="name" class="text-primary">Sale %</label>
                            <input type="number" min="0" max="100" step="0.01" value="0.00" class="form-control form-control-sm" id="perc_sale" name="perc_sale" aria-describedby="Sale" placeholder="For sale" value="0.00" disabled>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="name" class="text-primary">Rent %</label>
                                <input type="number" min="0" max="100" step="0.01" value="0.00" class="form-control form-control-sm" id="perc_rent" name="perc_rent" aria-describedby="Rent" placeholder="For rent" value="0.00" disabled>
                            </div>
                        </div>
                        @endforelse
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
                                            <th style="width: 10vw;"><small>Icon</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($group as $item)
                                            <tr>
                                                <td><small>{{ $item->name }}</small></td>
                                                <td><small><i class="{{ $item->icon ?? 'fas fa-users' }}"></i></small></td>
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
                        <div class="col-12 col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="addressAdd" class="text-primary">Address</label>
                                <input type="text" minlength="5" maxlength="150" class="form-control form-control-sm" id="addressAdd" aria-describedby="addressAdd" placeholder="Enter the user's address">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="postal_codeAdd" class="text-primary">Zip Code</label>
                                <input type="number" min="0" max="99999999" class="form-control form-control-sm" id="postal_codeAdd" aria-describedby="postal_code" placeholder="Postal code">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="cityAdd" class="text-primary">City</label>
                                <input type="text" minlength="3" maxlength="150" class="form-control form-control-sm" id="cityAdd" aria-describedby="city" placeholder="City">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="stateAdd" class="text-primary">State</label>
                                <input type="text" minlength="3" maxlength="150" class="form-control form-control-sm" id="stateAdd" aria-describedby="state" placeholder="State">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="countryAdd" class="text-primary">Country</label>
                                <input type="text" minlength="3" maxlength="150" class="form-control form-control-sm" id="countryAdd" aria-describedby="country" placeholder="Country" value="USA">
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
                                            <th><small>Zip Code</small></th>
                                            <th><small>Action</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($address as $item)
                                            <tr>
                                                <th><small><input type="text" readonly class="form-control-plaintext" name="address[]" value="{{ $item->address }}"></small></th>
                                                <th><small><input type="text" readonly class="form-control-plaintext" name="city[]" value="{{ $item->city }}"></small></th>
                                                <th><small><input type="text" readonly class="form-control-plaintext" name="state[]" value="{{ $item->state }}"></small></th>
                                                <th><small><input type="text" readonly class="form-control-plaintext" name="country[]" value="{{ $item->country }}"></small></th>
                                                <th><small><input type="text" readonly class="form-control-plaintext" name="postal_code[]" value="{{ $item->postal_code }}"></small></th>
                                                <td style="width: 10vw;"><button class="btn btn-primary btn-sm" onClick="deleteNode(this);"><i class="fas fa-trash"></i></button></td>
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
                        <input type="hidden" min="0" max="999" class="form-control form-control-sm" id="dddAdd"  aria-describedby="DDD" placeholder="DDD" value="0">
                        <input type="hidden" min="0" max="999" class="form-control form-control-sm" id="ddiAdd"  aria-describedby="DDI" placeholder="DDI" value="1">
                        <div class="col-12 col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="referenceAdd" class="text-primary">Reference</label>
                                <input type="text" minlength="0" maxlength="150" class="form-control form-control-sm" id="referenceAdd" aria-describedby="Reference" placeholder="Who will be communicated">
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="phoneAdd" class="text-primary">Phone</label>
                                <input type="number" min="0" max="99999999999" class="form-control form-control-sm" id="phoneAdd" aria-describedby="Phone" placeholder="Phone">
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
                                            <th><small></small></th>
                                            <th><small></small></th>
                                            <th><small>Phone</small></th>
                                            <th><small>Action</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($phone as $item)
                                        <tr>
                                            <th><small><input type="text" readonly class="form-control-plaintext" name="reference[]" value="{{ $item->reference }}"></small></th>
                                            <th><small><input type="hidden" readonly class="form-control-plaintext" name="ddi[]" value="{{ $item->ddi }}"></small></th>
                                            <th><small><input type="hidden" readonly class="form-control-plaintext" name="ddd[]" value="{{ $item->ddd }}"></small></th>
                                            <th><small><input type="text" readonly class="form-control-plaintext" name="phone[]" value="{{ $item->phone }}"></small></th>
                                            <td style="width: 10vw;"><button class="btn btn-primary btn-sm" onClick="deleteNode(this);"><i class="fas fa-trash"></i></button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-primary">
            <button class="btn btn-block btn-sm btn-outline-light" type="submit">Update {{ $user->name }}</button>
        </div>
    </form>
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

        if(postal_code > 999999999999) {
            alert('invalid zip code!');
        } // if(phone > 999999999999) { ... }

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

        if(phone > 999999999999) {
            alert('invalid phone!');
        } // if(phone > 999999999999) { ... }

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

    $(document).ready(function(){
        $('.percent').mask('000.00', {
            reverse: true,
        });
    });
</script>
@endsection