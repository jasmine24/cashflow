<?php namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use View;
use Auth;
use Session;
use App\Transaction;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
    {
        $userid = Auth::id();
        $items = Item::where('user', $userid)->orderBy('item_name', 'asc')->get();
        $transactionItems = Transaction::where('user_id', $userid)->where('status', 'open')->get();
        $totalValue = Transaction::where('user_id', $userid)->where('status', 'open')->sum('price');
        $totalQuantity = Transaction::where('user_id', $userid)->where('status' ,'open')->sum('quantity');
        return view('home',compact('items', 'transactionItems', 'totalValue', 'totalQuantity'));
	}

    public function add($id){
        //add the item to the transaction log
        $userid = Auth::id();
        $purchasedItem = Item::where('user', $userid)->findOrFail($id);
        $maxTransaction = Transaction::where('user_id', '=', $userid)->where('status', '=', 'open')->max('transaction_id');
        $currentTransaction = Transaction::where('user_id', '=', $userid)->where('transaction_id', '=', $maxTransaction)->
        where('sku', '=', $purchasedItem->sku)->first();
        if($maxTransaction && $currentTransaction){
            $updateQuantity = $currentTransaction->quantity;
            $updateQuantity++;
            $currentTransaction->update(array('quantity' => $updateQuantity));
        }
        else if ($maxTransaction){
            Transaction::create(array(  'transaction_id' => $maxTransaction,
                                        'user_id' => $userid,
                                        'item_name' => $purchasedItem->item_name,
                                        'price' => $purchasedItem->price,
                                        'quantity' => 1,
                                        'sku' => $purchasedItem->sku,
                                        'status' => 'open'));
        }
        else{
            Transaction::create(array(  'transaction_id' => 1,
                                        'user_id' => $userid,
                                        'item_name' => $purchasedItem->item_name,
                                        'price' => $purchasedItem->price,
                                        'quantity' => 1,
                                        'sku' => $purchasedItem->sku,
                                        'status' => 'open'));
        }

        $transactionItems = Transaction::where('user_id', '=', $userid)->where('status', '=', 'open')->get();
        $items = Item::where('user', $userid)->orderBy('item_name', 'asc')->get();
        $totalValue = Transaction::where('user_id', $userid)->where('status', 'open')->sum('price');
        $totalQuantity = Transaction::where('user_id', $userid)->where('status' ,'open')->sum('quantity');
        return view('home',compact('items', 'transactionItems', 'totalValue', 'totalQuantity'));
    }

    public function destroy($id){
        $userid = Auth::id();
        $currentTransaction = Transaction::where('user_id', '=', $userid)->findOrFail($id);
        $currentTransaction->delete();
        return redirect('home');
    }
}
