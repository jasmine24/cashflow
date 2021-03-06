<?php namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Scan;
class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::guest()){
            return view('user.login');
        }
        else{
            return view('welcome');
        }
	}

    public function connectdb($content, $format)
    {
        $scanFormat = $format;
        $scanContent = $content;
        $user = 'emily.thorn@gmail.com';
        $type = 'inventory';
        if($scanFormat && $scanContent != null){
            Scan::create(array('userEmail' => $user,
                                'sku' => $content,
                                'type' => $type));}
    }
}
