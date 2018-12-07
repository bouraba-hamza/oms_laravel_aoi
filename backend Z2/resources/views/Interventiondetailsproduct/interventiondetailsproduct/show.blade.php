@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Interventiondetailsproduct {{ $interventiondetailsproduct->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/interventiondetailsproduct/interventiondetailsproduct') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/interventiondetailsproduct/interventiondetailsproduct/' . $interventiondetailsproduct->id . '/edit') }}" title="Edit Interventiondetailsproduct"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('interventiondetailsproduct/interventiondetailsproduct' . '/' . $interventiondetailsproduct->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" title="Delete Interventiondetailsproduct" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $interventiondetailsproduct->id }}</td>
                                    </tr>
                                    <tr><th> Intervention  Detail Id </th><td> {{ $interventiondetailsproduct->intervention__detail_id }} </td></tr><tr><th> Installer Product Id </th><td> {{ $interventiondetailsproduct->installer_product_id }} </td></tr><tr><th> Created By </th><td> {{ $interventiondetailsproduct->created_by }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
