@extends('...app')

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
                             <th></th>
                          </tr>
                      </thead>

                      <tbody>
                      @foreach ($transactionItems as $item)
                        <tr>
                            <td class="col-md-4">{{ $item->item_name }}</td>
                            <td class="col-md-2">{{ $item->price }}</td>
                            <td class="col-md-2">{{ $item->quantity }}</td>
                            <td class="col-md-2">{{ $item->quantity*$item->price .'.00' }}</td>
                            <td></td>
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

                <div class="panel-heading">Checkout</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{"/checkout/charge/"}}{{$totalValue*$tax+$totalValue}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="payment">Payment: </label>
                            <div class="col-md-8">
                                <select class="form-control" id="payment">
                                    <option>Cash</option>
                                    <option>Credit</option>
                                    <option>Debit</option>
                                    <option>Check</option>
                                </select>
                             </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Cash Tendered: </label>
                            <div class="col-md-8">
                                <input type="number" min="0" max="1000000000" step="0.01" class="form-control" name="cash_tendered" value="{{$cash_tendered}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Charge</button>
                            </div>
                        </div>
                     </form>

                     <form class="form-horizontal" role="form" method="POST" action="{{"/checkout/complete/"}}{{$change}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Change: </label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="change" value="{{$change}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Notes: </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="notes">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Complete</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
