<?php

use Illuminate\Database\Migrations\Migration;

class SeedPlaygroundAcls extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$acl   = Orchestra\Acl::make('playground');
		$roles = Orchestra\Model\Role::lists('name');

		// Lets attach roles to our ACL.
		$acl->roles()->fill($roles);

		// Lets also attach actions to our ACL.
		$viewActions = ["View Article", "View Page"];
		$actions     = array_merge($viewActions, ["Manage Article", "Manage Page"]);

		$acl->actions()->fill($actions);

		// Administrator should allowed to have all.
		$acl->allow('Administrator', $actions);

		// Members and Guest should only allowed to view.
		$acl->allow(["Guest", "Member"], $viewActions);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Orchestra\App::memory()->forget('acl_playground');
	}

}
