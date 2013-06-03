<?php 

class AdminHomeController extends BaseController {

	public function getIndex()
	{
		return '<h1>We are in Playground</h1>';
	}

	public function getUser()
	{
		return User::all();
	}
}
