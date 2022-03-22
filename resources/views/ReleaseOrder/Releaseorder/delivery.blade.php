@extends('layouts.manage.app')
@push('css')
<style>
    .dataTables_scrollBody,
    .dataTables_wrapper {
        position: static !important;
    }

    .dropdown-button {
        cursor: pointer;
        font-size: 2em;
        display: block
    }

    .dropdown-menu i {
        font-size: 1.33333333em;
        line-height: 0.75em;
        vertical-align: -15%;
        color: #000;
    }

</style>
@endpush
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('ro.index') }}">Release Order</a></li>
@endsection
@section('content')
<div class="">
    <div class="card my-1">
        <div class="card-body">
            <div class="row">
                <div class="col col-3 border-right h-100">
                    @include('ReleaseOrder.Releaseorder.rosidebar')
                </div>
                <div class="col col-9">
                    <h4>Delivered List</h4>
                    <form action="{{ route('export.delivery') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="col-9">
                            
                            <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-weight-bold" id="searchModalLabel">Search</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="inputArea" class="col-sm-2 col-form-label font-weight-bold">Area</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputArea" name="inputArea" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputDriver" class="col-sm-2 col-form-label font-weight-bold">Driver</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputDriver" name="inputDriver" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputStatus" class="col-sm-2 col-form-label font-weight-bold">Status</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control" name="status" id="status">
                                                            <option value="">All</option>
                                                            <option value="00">Active</option>
                                                            <option value="99">Cancel</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="inputStatus" class="col-sm-2 col-form-label font-weight-bold">Date From</label>
                                                    <div class="col-sm-4">
                                                        <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
                                                    </div>
                                                    <label for="inputStatus" class="col-sm-2 col-form-label font-weight-bold">To </label>

                                                    <div class="col-sm-4">
                                                        <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                
                                                <button type="button" class="btn btn-secondary" id="reset">Reset</button>
                                                <button type="button" name="searchBtn" id="searchBtn" class="btn btn-primary">search</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Export
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <button type="submit" name="submit" value="excel" class="dropdown-item">Excel</button>
                                            <button type="submit" name="submit" value="excel-detailed" class="dropdown-item">Excel - Detailed</button>
                                        </div>
                                    </div> 
                                </div>

                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal ">
                                        Search
                                    </button>
                                </div> 
                            </div>

                        </div>


                    </form>

                    <div class="table-responsive">
                        {{ $dataTable->table(['class'=>'table table-sm']) }}

                        {{-- @include('export.view.delivery', [$data]) --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>


</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <form action="{{ route('release.cancel') }}" method="post">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="exampleModalLabel">Are you sure want to cancel?</h5>
                    <input type="hidden" id="id" name="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes ! Cancel it</button>
                </div>
            </div>
        </form>

    </div>
</div>
</div>
</div>
<!-- Modal -->
@endsection
@push('js')


{{-- <script src="{{ asset('/js/vue.min.js') }}"></script> --}}
{{-- <script>
    new Vue({
        el: '#app',
        data: {
            seen: false
        },
        methods: {
            deleteRONO: function (id) {
                console.log('test clicked');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('/release/cancel/' + id, {
                                _method: 'DELETE'
                            })
                            .then(response => {
                                Swal.fire({
                                    title: "Canceled!",
                                    text: "Your imaginary file has been canceled.",
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            "{{ route('release.delivery') }}";
}
});

})
.catch(error => {
//handle failure
console.log("error");
})
}
})
}
}
})

</script> --}}



<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{{$dataTable->scripts()}}

<script>
    $(document).on("click", ".d-cancel", function () {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

</script>

<script>
    const table = $("#delivery-table");
    table.on('preXhr.dt', function (e, settings, data) {
        data.from_date = $('#from_date').val();
        data.to_date = $('#to_date').val();
        data.status = $('#status').val();
        data.driver = $('#inputDriver').val();
        data.area = $('#inputArea').val();

    });


    $('#searchBtn').on('click', function () {
        table.DataTable().ajax.reload();
        $('#searchModal').modal('hide'); //modal_1 is the id 1

        return false;
    })

    $('#reset').on('click', function () {
        $('#from_date').val("");
        $('#to_date').val("");
        $('#status').val("");
        $('#inputDriver').val("");
        $('#inputArea').val("");
        table.DataTable().ajax.reload();
        return false;

    }) 

</script>
@endpush
