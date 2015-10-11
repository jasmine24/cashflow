<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use View;
use App\User;
use App\Scan;
use Auth;

class InventoryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $userid = Auth::id();
        $items = Item::orderBy('item_name', 'asc')->get();
        $editInput = null;
        $skuscan = null;
        $email = User::where('id', $userid)->first()->email;
        $scan = Scan::where('userEmail', $email)->first();
        if($scan){
            $skuscan = $scan;
        }
        $totalValue = Item::where('user', $userid)->sum('price');
        $totalQuantity = Item::where('user', $userid)->sum('quantity');
        return view('inventory', compact('items', 'editInput', 'totalValue', 'totalQuantity', 'skuscan'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        //$input = Request::all();
        $request->merge(['user' => Auth::id()]);
        $this->validate($request, ['item_name' => 'required', 'sku' => 'required|numeric|unique:items,sku',
                            'price' => 'required', 'quantity' => 'required|numeric', 'user' => 'required']);
        Item::create($request->all());

        //delete scanner
        $email = User::where('id', Auth::id())->first()->email;
        $scan = Scan::where('userEmail', $email)->delete();

        return redirect('inventory');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function edit($id)
    {
        $userid = Auth::id();
        $items = Item::orderBy('item_name', 'asc')->get();
        $editInput = Item::findOrFail($id);
        $skuscan = null;
        $email = User::where('id', $userid)->first()->email;
        $scan = Scan::where('userEmail', $email)->first();
        if($scan){
            $skuscan = $scan;
        }
        $totalValue = Item::where('user', $userid)->sum('price');
        $totalQuantity = Item::where('user', $userid)->sum('quantity');
        return view('inventory', compact('items', 'editInput', 'totalValue', 'totalQuantity', 'skuscan'));
    }

	public function update($id, Request $request)
	{
        $request->merge(['user' => Auth::id()]);
        $this->validate($request, ['item_name' => 'required', 'sku' => 'required|numeric',
            'price' => 'required', 'quantity' => 'required|numeric', 'user' => 'required']);
        Item::findOrFail($id)->update($request->all());
        return redirect('inventory');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect('inventory');
	}
}
