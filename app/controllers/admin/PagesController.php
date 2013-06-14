<?php 

use Orchestra\Acl;
use Orchestra\Form;
use Orchestra\Messages;
use Orchestra\Site;

class AdminPagesController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter(function ()
		{
			if ( ! Acl::make('playground')->can('manage article'))
			{
				return Redirect::to(handles('orchestra/foundation::/'));
			}
		});
	}

	public function index()
	{
		Site::set('title', 'List of Pages');

		$pages = Page::with('author')->paginate(30);

		return View::make('admin.pages.index', compact('pages'));
	}

	public function create()
	{
		Site::set('title', 'Create a Page');

		$form = Form::make(function ($form)
		{
			$form->with(new Page);
			$form->attributes([
				'url'    => handles('orchestra/foundation::resources/playground.pages'),
				'method' => 'POST'
			]);

			$form->fieldset(function ($fieldset)
			{
				$fieldset->control('input:text', 'title');
				$fieldset->control('input:text', 'slug');
				$fieldset->control('textarea', 'body');
			});
		});

		return View::make('admin.pages.edit', compact('form'));
	}

	public function store()
	{
		$input = Input::all();
		$rules = array(
			'title' => ['required'],
			'body'  => ['required'],
			'slug'  => ['required', 'unique:pages,slug']
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails())
		{
			return Redirect::to(handles('orchestra/foundation::resources/playground.pages/create'))
					->withInput()
					->withErrors($validation);
		}

		$page          = new Page;
		$page->title   = $input['title'];
		$page->body    = $input['body'];
		$page->slug    = $input['slug'];
		$page->user_id = Auth::user()->id;
		$page->save();

		Messages::add('success', 'Page has been added');

		return Redirect::to(handles('orchestra/foundation::resources/playground.pages'));
	}

	public function edit($id)
	{
		Site::set('title', 'Edit a Page');

		$form = Form::make(function ($form) use ($id)
		{
			$form->with(Page::find($id));
			$form->attributes([
				'url'    => handles("orchestra/foundation::resources/playground.pages/{$id}"),
				'method' => 'PUT'
			]);

			$form->fieldset(function ($fieldset)
			{
				$fieldset->control('input:text', 'title');
				$fieldset->control('input:text', 'slug');
				$fieldset->control('textarea', 'body');
			});
		});

		return View::make('admin.pages.edit', compact('form'));
	}

	public function update($id)
	{
		$page  = Page::findOrFail($id);
		$input = Input::all();
		$rules = array(
			'title' => ['required'],
			'body'  => ['required'],
			'slug'  => ['required', "unique:pages,slug,{$id}"]
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails())
		{
			return Redirect::to(handles("orchestra/foundation::resources/playground.pages/{$id}/edit"))
					->withInput()
					->withErrors($validation);
		}

		$page->title = $input['title'];
		$page->body  = $input['body'];
		$page->slug  = $input['slug'];
		$page->save();

		Messages::add('success', 'Page has been updated');

		return Redirect::to(handles('orchestra/foundation::resources/playground.pages'));
	}

	public function delete($id)
	{
		return $this->destroy($id);
	}

	public function destroy($id)
	{
		$page = Page::findOrFail($id);
		$page->delete();

		Messages::add('success', 'Page has been deleted');

		return Redirect::to(handles('orchestra/foundation::resources/playground.pages'));
	}
}
