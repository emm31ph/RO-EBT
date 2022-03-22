@extends('layouts.manage.app')
@push('css')

@endpush
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('ro.index') }}">Release Order</a></li>
    <li class="breadcrumb-item">Settings </li>
@endsection
@section('content')

    @php

    @endphp
    <div class="container">
        <div class="card  border border-primary">
            <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title">
                            Delivery
                        </h3>
                    </div>
                    <div class="col-2">
                        <ul class="navbar-nav float-right">
                            <li class="nav-item dropdown">
                                <a id="my-dropdown" class="nav-link  dropdown-toggle text-white" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dropdown">
                                    <a class="dropdown-item" href="{{ url()->previous() }}">Back</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('ro.store') }}" method="POST" @submit.prevent="submit()" novalidate>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="input-group input-group-sm mb-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><small>Please release the following items for
                                                delivery
                                                on</small></span>
                                    </div>
                                    <input type="date" name="dateInput" min="2010-01-01" max="2050-12-31"
                                        :class="['form-control', allerros.dateInput ? 'border border-danger' : '']"
                                        v-model="form.dateInput">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><small>to the following customers :</small></span>
                                    </div>
                                </div>
                                <small v-if="allerros.dateInput"
                                    :class="['form-text text-danger']">@{{ allerros . dateInput[0] }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group input-group-sm mb-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="inputGroup-sizing-sm"><small>R.O.&nbsp;</small></span>
                                    </div>
                                    <input type="text" name="rono" value="{{ old('rono') }}" autofocus="autofocus"
                                        :class="['form-control', allerros.rono ? 'border border-danger' : '']"
                                        v-model="form.rono">
                                </div>
                                <small v-if="allerros.rono"
                                    :class="['form-text text-danger']">@{{ allerros . rono[0] }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group input-group-sm mb-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="inputGroup-sizing-sm"><small>Driver</small></span>
                                    </div>
                                    <input type="text" name="driver" value="{{ old('driver') }}"
                                        :class="['form-control', allerros.driver ? 'border border-danger' : '']"
                                        v-model="form.driver">
                                </div>

                                <small v-if="allerros.driver"
                                    :class="['form-text text-danger']">@{{ allerros . driver[0] }}</small>
                            </div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm mb-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"><small>Plate
                                                No.</small></span>
                                    </div>
                                    <input type="text" name="plate" value="{{ old('plate') }}"
                                        :class="['form-control', allerros.driver ? 'border border-danger' : '']"
                                        v-model="form.plate">
                                </div>

                                <small v-if="allerros.plate"
                                    :class="['form-text text-danger']">@{{ allerros . plate[0] }}</small>
                            </div>
                        </div> --}}


                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group input-group-sm mb-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="inputGroup-sizing-sm"><small>Trucker</small></span>
                                    </div>
                                    {{--
                                    {{ Form::select('trucker', $utrucker, old('trucker'), [':class' => "['form-control', allerros.trucker ? 'border border-danger' : '']", 'v-model' => 'form.trucker']) }}
                                    --}}
                                    <select :class="['form-control', allerros.trucker ? 'border border-danger' : '']"
                                        v-model="form.trucker" name="trucker">

                                        @foreach ($utrucker as $value)
                                            <option value="{{ $value }}" {{ $value == old('trucker') ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <small v-if="allerros.trucker"
                                    :class="['form-text text-danger']">@{{ allerros . trucker[0] }}</small>
                            </div>
                        </div>


                        {{-- <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm mb-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"><small>Truck
                                                No.</small></span>
                                    </div>
                                    <input type="text" name="truck" value="{{ old('truck') }}"
                                        :class="['form-control', allerros.driver ? 'border border-danger' : '']"
                                        v-model="form.truck">
                                </div>

                                <small v-if="allerros.truck"
                                    :class="['form-text text-danger']">@{{ allerros . truck[0] }}</small>
                            </div>
                        </div> --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group input-group-sm mb-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"><small>Area</small></span>
                                    </div>
                                    <input type="text" name="area" value="{{ old('area') }}"
                                        :class="['form-control', allerros.area ? 'border border-danger' : '']"
                                        v-model="form.area">
                                </div>

                                <small v-if="allerros.area"
                                    :class="['form-text text-danger']">@{{ allerros . area[0] }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-sm">
                                <input type="text" ref='search' class="form-control" placeholder="Doc. No."
                                    aria-label="Doc. No." v-model="keywords">

                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" @click="fetch" type="button">Search</button>
                                    <button class="btn btn-outline-success" :disabled="seen" type="button"
                                        @click="addNewRow">Add</button>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-sm" v-if="results != '' && !results[0] ">
                                <input type="text" :value="results.Customer" class="form-control" disabled>
                            </div>

                        </div>

                    </div>

                    <div class="row py-1">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th class=" text-center">#</th>
                                        <th>SI/DR No.</th>
                                        <th>Customer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(invoice_product, k) in invoice_products" :key="k">
                                        <td scope="row" class="align-middle text-center">
                                            <i class="fa fa-trash text-danger" @click="deleteRow(k, invoice_product)"></i>
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="text"
                                                v-model="invoice_products[k].product_no"
                                                :names-array="invoice_products.map(a => a.PO_no)" disabled />

                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="text"
                                                :value="invoice_product.product_name" disabled />
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" id="remarks" rows="3" name="remarks"
                            v-model="form.remarks"></textarea>
                    </div>

                    @permission(['signatory-read'])
                    <div class="row">
                        <div class="col-12">
                        <label for="">Signatories</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group input-group-sm mb-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"><small>Loading Incharge</small></span>
                                    </div>
                                     @if (!Auth::user()->hasPermission(['signatory-update']))

                                    <input type="text" name="signa1"  autofocus="autofocus" :class="['form-control'
                                            ]" v-model="form.signa1" readonly>
                                    @else

                                    <input type="text" name="signa1"  autofocus="autofocus" :class="['form-control'
                                            ]" v-model="form.signa1" >
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group input-group-sm mb-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"><small>Sales Admin</small></span>
                                    </div>
                                    @if (!Auth::user()->hasPermission(['signatory-update']))

                                    <input type="text" name="signa2"  autofocus="autofocus" :class="['form-control'
                                            ]" v-model="form.signa2" readonly>
                                    @else

                                    <input type="text" name="signa2"  autofocus="autofocus" :class="['form-control'
                                            ]" v-model="form.signa2" >
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    @endpermission
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" :disabled="!invoice_products.length !=0"
                            class="btn btn-sm btn-primary">Process</button>
                    </div>

                </form>
            </div>
            <div class="card-footer bg-primary">
                &nbsp;

            </div>
        </div>
    </div>


@endsection
@push('js')

    <script src="{{ asset('/js/vue.min.js') }}"></script>

    <script>
        new Vue({
            el: "#app",
            data() {
                return {
                    form: {
                        rono: '{{ str_pad($rono->ro_no, 5, "0", STR_PAD_LEFT) }}',
                        dateInput: '',
                        driver: '',
                        truck: '',
                        trucker: '',
                        plate: '',
                        area: '',
                        remarks: '',
                        signa1: '{{ $signatories->signatory1 }}',
                        signa2: '{{ $signatories->signatory2 }}',

                    },
                    releaseno: '',
                    allerros: [],
                    success: false,
                    keywords: null,
                    seen: true,
                    results: [],
                    invoice_products: [],

                };
            },
            watch: {
                keywords(after, before) {
                    if (!this.seen) {
                        this.seen = true;
                        this.results = '';
                    }
                }
            },
            methods: {
                fetch() {
                    this.seen = false;

                    axios.get('/release/search', {
                            params: {
                                keywords: this.keywords
                            }
                        })
                        .then(response => {
                            this.results = response.data;
                            // console.log(this.results);


                            if (this.results[0].error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Record not found!',
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                                this.keywords = null;
                                this.seen = true;
                            }


                        })
                        .catch(error => {});
                    if (this.keywords == null || this.keywords == '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid input!',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        this.keywords = null;
                        this.seen = true;
                    }


                },
                deleteRow(index, invoice_product) {
                    var idx = this.invoice_products.indexOf(invoice_product);
                    console.log(idx, index);
                    if (idx > -1) {
                        this.invoice_products.splice(idx, 1);
                    }

                },
                addNewRow() {
                    this.seen = true;
                    res = true;

                    if (this.results.status == '01') {
                        Swal.fire({
                            icon: 'error',
                            title: 'SI/DR No. : ' + this.keywords + ' is already process! ',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        this.keywords = null;
                        res = false;
                    }

                    this.invoice_products.forEach((invoice_product, index) => {
                        if (this.invoice_products[index]['product_no'] == this.keywords) {
                            Swal.fire({
                                icon: 'error',
                                title: 'SI/DR No. is already add!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            res = false;
                        }
                    });


                    if (res) {
                        if (this.results.PO_no != null) {
                            this.invoice_products.push({
                                product_no: this.results.PO_no,
                                product_name: this.results.Customer,
                            });
                        }
                    }
                    this.results = '';
                    this.keywords = '';
                    this.$refs.search.focus();

                },
                submit() {

                    dataform = new FormData();
                    dataform.append('rono', this.form.rono);
                    dataform.append('dateInput', this.form.dateInput);
                    dataform.append('driver', this.form.driver);
                    dataform.append('plate', this.form.plate);
                    dataform.append('truck', this.form.truck);
                    dataform.append('trucker', this.form.trucker);
                    dataform.append('area', this.form.area);
                    dataform.append('remarks', (this.form.remarks).replace(/(?:\r\n|\r|\n)/g, '<br>'));
                    dataform.append('signa1', this.form.signa1);
                    dataform.append('signa2', this.form.signa2);
                    dataform.append('po_no', JSON.stringify(this.invoice_products));

                    axios.post("{{ route('ro.store') }}", dataform).then(response => {
                        // console.log(response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Record has been save',
                            showConfirmButton: false,
                            timer: 1000
                        });

                          var url = '{{ url("/release/print", ":id") }}';
                        url = url.replace('%3Aid', this.form.rono);

                        window.open(url);

                        window.location.href  = "{{ url('ro/create') }}";
                        this.resetForm();
                        this.success = true;
                        this.allerros = [];

                    }).catch((error) => {
                        this.allerros = error.response.data.errors;
                        this.success = false;
                    });

                },
                resetForm() {
                    console.log('Reseting the form')
                    var self = this; //you need this because *this* will refer to Object.keys below`
                    this.keywords = null;
                    this.seen = true;
                    //Iterate through each object field, key is name of the object field`
                    Object.keys(this.form).forEach(function(key, index) {
                        self.form[key] = '';
                    });

                    this.invoice_products = [];

                }
            }
        });

    </script>
@endpush
