@extends('app')

@section('content')
<div class="container">
	<div class="col">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">Inventory</div>
				<div class="panel-body">
                    <table class="table table-hover">
                      <thead>
                          <tr>
                             <th>Item Name</th>
                             <th>SKU</th>
                             <th>Price</th>
                             <th>Quantity</th>
                             <th>Edit</th>
                             <th>Delete</th>
                          </tr>
                      </thead>

                      <tbody>
                      @foreach ($items as $item)
                            @if($item->user == Auth::id())
                                <tr>
                                    <td class="col-md-4">{{ $item->item_name }}</td>
                                    <td class="col-md-2">{{ $item->sku }}</td>
                                    <td class="col-md-2">{{ $item->price }}</td>
                                    <td class="col-md-2">{{ $item->quantity }}</td>
                                    {!! Form::model($item, ['method' => 'GET', 'action' => ['InventoryController@edit', $item->id]]) !!}
                                                <td class="col-md-1"><button type="submit" class="glyphicon glyphicon-pencil"
                                                style="border:none; background-color:Transparent"></button></td>
                                    {!! Form::close() !!}
                                    {!! Form::model($item, ['method' => 'DELETE', 'action' => ['InventoryController@destroy', $item->id]]) !!}
                                                <td class="col-md-1"><button type="submit" class="glyphicon glyphicon-remove"
                                                style="border:none; background-color:Transparent"></button></td>
                                    {!! Form::close() !!}
                                </tr>
                            @endif
                      	@endforeach
                      	    <tr class="active">
                      	        <td></td>
                                <td><strong>Total Value:</strong></td>
                                <td>{{ $totalValue }}</td>
                                <td><strong>Total Quantity:</strong></td>
                                <td>{{ $totalQuantity }}</td>
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

    			    @if ($editInput != null)
    			        <div class="panel-heading">Edit Item</div>
    				    <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/inventory/update/'.$editInput->id) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Item Name</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="item_name" value="{{ $editInput->item_name }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">SKU</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="sku" value="{{ $editInput->sku }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Price</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0" max="1000000000" step="0.01" class="form-control" name="price" value="{{ $editInput->price }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Quantity</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="quantity" value="{{ $editInput->quantity }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                            </form>
    				    </div>
                    @else
                        <div class="panel-heading">Add a New Item</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/inventory/add') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Item Name</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="item_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">SKU</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="sku">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Price</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0" max="1000000000" step="0.01" class="form-control" name="price">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Quantity</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="quantity">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            </form>
                    @endif
    				</div>
    			</div>
    		</div>
    	</div>
</div>
@endsection
