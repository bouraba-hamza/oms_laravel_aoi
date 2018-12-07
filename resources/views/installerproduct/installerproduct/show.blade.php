@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Installerproduct {{ $installerproduct->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/installerproduct/installerproduct') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/installerproduct/installerproduct/' . $installerproduct->id . '/edit') }}" title="Edit Installerproduct"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('installerproduct/installerproduct' . '/' . $installerproduct->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" title="Delete Installerproduct" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $installerproduct->id }}</td>
                                    </tr>
                                    <tr><th> Status </th><td> {{ $installerproduct->status }} </td></tr><tr><th> Product Id </th><td> {{ $installerproduct->product_id }} </td></tr><tr><th> Installer Id </th><td> {{ $installerproduct->installer_id }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
