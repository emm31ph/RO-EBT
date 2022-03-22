@extends('layouts.manage.app')
@push('css')
 
@endpush
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('manage.role.index') }}">Roles</a></li>
    <li class="breadcrumb-item"><a href="{{ route('manage.permission.index') }}">Permission</a></li>
    <li class="breadcrumb-item">Settings </li>
@endsection
@section('content')
    <div class="container">
         <div class="card border border-primary">
             <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title">
                            Report Create Item
                        </h3>
                    </div>
                    <div class="col-2">
                        <ul class="navbar-nav float-right">
                            <li class="nav-item dropdown">
                                <a id="my-dropdown" class="nav-link  dropdown-toggle text-white" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>
                                    @permission('acl-create')
                                    <div class="dropdown-menu dropdown-menu-right " aria-labelledby="my-dropdown">
                                        <a class="dropdown-item" href="{{ route('report.index') }}">Back</a>
                                    </div>
                                    @endpermission
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
   {!! Form::open(['route' => 'report.store', 'id' => 'reportForm', 'role' => 'form']) !!}
             
                <div class="row">
                    <div class="col col-3 border-right h-100">
                        @include('manage.sidebar')
                    </div>
                    <div class=" col col-9 card-body d-flex flex-wrap">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="input-group input-group-sm mb-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><small>Header</small></span>
                                        </div>
                                        <input type="text" name="header" placeholder="" class="header1 form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="input-group input-group-sm mb-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><small>Sub-Header</small></span>
                                        </div>
                                        <input type="text" name="subheader" placeholder="" class="header2 form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="input-group input-group-sm mb-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><small>Item Header</small></span>
                                        </div>
                                        <input type="text" name="itemheader" placeholder="" class="header3 form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="input-group input-group-sm mb-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><small>Item Code</small></span>
                                        </div>
                                        <input type="text" name="itemcode" placeholder="" class="itemcode form-control">
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="input-group input-group-sm mb-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><small>Section</small></span>
                                        </div>
                                        <select class="form-control" id="section" name="section">
                                            <option value="00001">1st Section</option>
                                            <option value="00002">2nd Section</option>
                                        </select>
                                    </div>
                                </div>

                            </div> 
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </div>

                    </div>

                </div>

                {!! Form::close() !!}
            <div class="card-footer bg-primary">
                &nbsp;
            </div>
        </div>
    </div> 

    @endsection
    @push('js') 
    
  <script type="text/javascript">
    var path = "{{ route('header1') }}";
    $('input.header1').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });

        var path2 = "{{ route('header2') }}";
    $('input.header2').typeahead({
        source:  function (query, process) {
        return $.get(path2, { query: query }, function (data) {
                return process(data);
            });
        }
    });

        var path3 = "{{ route('header3') }}";
    $('input.header3').typeahead({
        source:  function (query, process) {
        return $.get(path3, { query: query }, function (data) {
                return process(data);
            });
        }
    });
        var path4 = "{{ route('itemcode') }}";
    $('input.itemcode').typeahead({
        source:  function (query, process) {
        return $.get(path4, { query: query }, function (data) {
                return process(data);
            });
        }
    });
    </script>
    @endpush
