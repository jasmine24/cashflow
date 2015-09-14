@extends('app')

@section('content')
<div class="container">
	<div class="col">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">Transaction Log</div>
				<div class="panel-body">
                    <table class="table table-hover">
                      <thead>
                          <tr>
                             <th>Item Name</th>
                             <th>Price</th>
                             <th>Quantity</th>
                             <th>Total</th>
                             <th>Edit</th>
                             <th>Delete</th>
                          </tr>
                      </thead>

                      <tbody>
                        <tr class="active">
                            <td></td>
                            <td><strong>Total Value:</strong></td>
                            <td><strong>Total Quantity:</strong></td>
                            <td></td>
                         </tr>
                      </tbody>
                    </table>
				</div>
			</div>
		</div>
	</div>

		<div class="col">
    		<div class="col-md-4">
    			<div class="panel panel-default">

    				@if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                        <div class="panel-heading">Inventory</div>
                        <div class="panel-body">
                         <table class="table table-hover">
                          <thead>
                              <tr>
                                 <th>Item Name</th>
                                 <th>Price</th>
                                 <th>Quantity</th>
                              </tr>
                          </thead>
                          <tbody>
                          @foreach ($items as $item)
                            <tr>
                                <td class="col-md-4">{{ $item->item_name }}</td>
                      			<td class="col-md-2">{{ $item->price }}</td>
                                <td class="col-md-2">{{ $item->quantity }}</td>
                                {!! Form::model($item, ['method' => 'GET', 'action' => ['HomeController@add', $item->id]]) !!}
                                            <td class="col-md-1"><button type="submit" class="glyphicon glyphicon-plus"
                                            style="border:none; background-color:Transparent"></button></td>
                                {!! Form::close() !!}
                            </tr>
                          @endforeach
                          </tbody>
    				</div>
    			</div>
    		</div>
    	</div>
</div>
@endsection
