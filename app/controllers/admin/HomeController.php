<?php 

class AdminHomeController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter(function ()
		{
			$acl = Orchestra\Acl::make('playground');
			
			if ( ! ($acl->can('manage article') or $acl->can('manage page')))
			{
				return Redirect::to(handles('orchestra/foundation::/'));
			}
		});
	}

	public function getIndex()
	{
		return '<h1>We are in Playground</h1>';
	}

	public function getUser()
	{
		return User::all();
	}
}
