@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Interventiondetail {{ $interventiondetail->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/interventiondetails/interventiondetails') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/interventiondetails/interventiondetails/' . $interventiondetail->id . '/edit') }}" title="Edit Interventiondetail"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('interventiondetails/interventiondetails' . '/' . $interventiondetail->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" title="Delete Interventiondetail" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $interventiondetail->id }}</td>
                                    </tr>
                                    <tr><th> Type </th><td> {{ $interventiondetail->type }} </td></tr><tr><th> Observation </th><td> {{ $interventiondetail->observation }} </td></tr><tr><th> Status </th><td> {{ $interventiondetail->status }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
