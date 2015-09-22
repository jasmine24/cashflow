@extends('...app')

@section('content')
<div class="container">
	<div class="col">
		<div class="col-md-8">
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

				<div class="panel-heading">Transaction Log</div>
				<div class="panel-body">
                    <table class="table table-hover">
                      <thead>
                          <tr>
                             <th>Item Name</th>
                             <th>Price</th>
                             <th>Quantity</th>
                             <th>Total</th>
                             <th>Delete</th>
                          </tr>
                      </thead>

                      <tbody>
                     @if(count($transactionItems) == 0)
                         <tr>
                            <td class="col-md-12">Add items from inventory to begin transaction.</td>
                         </tr>
                     @endif
                     @foreach ($transactionItems as $item)
                            <tr>
                                <td class="col-md-4">{{ $item->item_name }}</td>
                                <td class="col-md-2">{{ $item->price }}</td>
                                <td class="col-md-2">{{ $item->quantity }}</td>
                                <td class="col-md-2">{{ $item->quantity*$item->price .'.00' }}</td>
                                {!! Form::model($item, ['method' => 'DELETE', 'action' => ['HomeController@destroy', $item->id]]) !!}
                                            <td class="col-md-1"><button type="submit" class="glyphicon glyphicon-remove"
                                            style="border:none; background-color:Transparent"></button></td>
                                {!! Form::close() !!}
                            </tr>
                      @endforeach
                        <tr>
                            <td></td>
                            <td><strong>Subtotal:</strong></td>
                            <td>{{$totalValue}}</td>
                            <td></td>
                            <td></td>
                         </tr>
                         <tr>
                            <td></td>
                            <td><strong>Tax {{'('.$tax.'%) '}}:</strong></td>
                            <td>{{$totalValue*$tax}}</td>
                            <td></td>
                            <td></td>
                         </tr>
                         <tr class="active">
                            <td></td>
                            <td><strong>Total:</strong></td>
                            <td>{{$totalValue*$tax+$totalValue}}</td>
                            <td><strong>Total Quantity:</strong></td>
                            <td>{{$totalQuantity}}</td>
                         </tr>
                      </tbody>
                    </table>
                    <div class="col-md-12" style="text-align: right">
                        <button type="button" class="btn btn-primary btn-sm">Add Discount</button>
                        <button type="button" class="btn btn-primary btn-sm">Tax Exempt</button>
                    <p>
                        <a href ="/checkout"><button type="button" class="btn btn-success btn-lg">Checkout</button></a>
                        <button type="button" class="btn btn-danger btn-lg">Cancel</button>
                    </p>
                    </div>
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
                                 <th>Add</th>
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
