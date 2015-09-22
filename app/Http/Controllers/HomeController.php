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
        //get tax from user settings
        $tax = 0.08;
        return view('home',compact('items', 'transactionItems', 'totalValue', 'totalQuantity', 'tax'));
	}

    public function add($id){
        //add the item to the transaction log
        $userid = Auth::id();
        $purchasedItem = Item::where('user', $userid)->findOrFail($id);
        //get max transaction id
        $maxTransactionId = Transaction::where('user_id', '=', $userid)->max('transaction_id');
        //check if open
        $maxTransactionIdStatus = Transaction::where('user_id', $userid)->where('transaction_id', $maxTransactionId)->first()->status;
        if($maxTransactionIdStatus == 'open'){
            //check if item already in list
            $currentTransaction = Transaction::where('user_id', '=', $userid)->where('transaction_id', '=', $maxTransactionId)->
            where('sku', '=', $purchasedItem->sku)->first();
            if($currentTransaction){
                $updateQuantity = $currentTransaction->quantity;
                $updateQuantity++;
                $currentTransaction->update(array('quantity' => $updateQuantity));
            }
            //if not yet in list, add to open transaction list
            else{
                Transaction::create(array(  'transaction_id' => $maxTransactionId,
                    'user_id' => $userid,
                    'item_name' => $purchasedItem->item_name,
                    'price' => $purchasedItem->price,
                    'quantity' => 1,
                    'sku' => $purchasedItem->sku,
                    'status' => 'open'));
            }
        }
        else if($maxTransactionIdStatus = 'closed'){
            $newTransactionId = $maxTransactionId + 1;
            Transaction::create(array(  'transaction_id' => $newTransactionId,
                'user_id' => $userid,
                'item_name' => $purchasedItem->item_name,
                'price' => $purchasedItem->price,
                'quantity' => 1,
                'sku' => $purchasedItem->sku,
                'status' => 'open'));
        }

        //reduce inventory
        $inventoryItemQuantity = $purchasedItem->quantity;
        $inventoryItemQuantity--;
        $purchasedItem->update(array('quantity' => $inventoryItemQuantity));
        return redirect('home');
    }

    public function destroy($id){
        $userid = Auth::id();
        $currentTransaction = Transaction::where('user_id', '=', $userid)->findOrFail($id);
        $purchasedItem = Item::where('user', $userid)->where('sku', $currentTransaction->sku)->first();
        $inventoryQuantity = $currentTransaction->quantity;
        $newQuantity = $inventoryQuantity + $purchasedItem->quantity;
        $purchasedItem->update(array('quantity' => $newQuantity));
        $currentTransaction->delete();

        return redirect('home');
    }
}

