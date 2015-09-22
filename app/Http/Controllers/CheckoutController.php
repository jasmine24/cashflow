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
use App\Receipt;

class CheckoutController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Checkout Controller
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
        $transactionItems = Transaction::where('user_id', $userid)->where('status', 'open')->get();
        $totalValue = Transaction::where('user_id', $userid)->where('status', 'open')->sum('price');
        $totalQuantity = Transaction::where('user_id', $userid)->where('status' ,'open')->sum('quantity');
        $change = null;
        $cash_tendered = null;
        //get tax from user settings
        $tax = 0.08;
        return view('checkout', compact('transactionItems', 'totalValue', 'totalQuantity', 'tax', 'change', 'cash_tendered'));
    }

    public function charge(Request $request, $id)
    {
        $cash_tendered = $request->input('cash_tendered');
        $balance = $id;
        $change = $cash_tendered-$balance;
        $userid = Auth::id();
        $transactionItems = Transaction::where('user_id', $userid)->where('status', 'open')->get();
        $totalValue = Transaction::where('user_id', $userid)->where('status', 'open')->sum('price');
        $totalQuantity = Transaction::where('user_id', $userid)->where('status' ,'open')->sum('quantity');
        $tax = 0.08;
        return view('checkout', compact('transactionItems', 'totalValue', 'totalQuantity', 'tax', 'change', 'cash_tendered'));

    }

    public function complete(Request $request, $id)
    {
        $userid = Auth::id();
        $transaction_id = Transaction::where('user_id', $userid)->where('status', 'open')->first()->transaction_id;
        $totalValue = Transaction::where('user_id', $userid)->where('status', 'open')->sum('price');
        $tax = 0.08;
        $total = $totalValue*$tax+$totalValue;
        $change = $id;
        $notes = $request->input('notes');
        $cash_received = $change + $total;
        //store receipt
        Receipt::create(array(
                    'transaction_id' => $transaction_id,
                    'user_id' => $userid,
                    'total' => $total,
                    'cash_received' => $cash_received,
                    'change' => $change,
                    'notes' => $notes));

        //close transaction
        $transactionItems = Transaction::where('user_id', $userid)->where('status', 'open')->get();
        foreach($transactionItems as $item){
            $item->update(array('status' => 'closed'));
        }
        return redirect('home');
    }

}

