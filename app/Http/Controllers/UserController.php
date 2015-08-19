<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use Input;
use App\User;
use Validator;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
	public function store()
	{
        $input = Input::only(['first_name','last_name','email','password','password_confirmation']);
        //validate form
        $validator = Validator::make(
            $input,
            [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'email' => 'required|email|min:3',
                'password' => 'required|min:3|confirmed',
                'password_confirmation'=> 'required|min:3'
            ]
        );

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $newUser = User::create($input);
        if($newUser){
            Auth::login($newUser);
            return redirect('home');
        }

        return Redirect::back()->withInput();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function login(){
        return view('user.login');
    }

    public function handleLogin(){
        $input = Input::only(['email', 'password']);
        //validate login
        $validator = Validator::make(
            $input,
            [
                'email' => 'required|email|min:8',
                'password' => 'required',
            ]
        );

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if(Auth::attempt(['email' => $input['email'], 'password' => $input['password']])){
            return redirect('home');
        }
        else {
            $messages = $validator->errors();
            $messages->add('Credentials Mismatch', 'You\'re username and password do not match.');
            return Redirect::back()->withErrors($messages)->withInput();
        }
    }

    public function logout(){
        if(Auth::check()){
            Auth::logout();
        }
        return redirect('login');
    }

    public function register(){
        return view('user.register');
    }

}
