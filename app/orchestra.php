<?php

Orchestra\Acl::make('playground')->attach(Orchestra\App::memory());

Event::listen('orchestra.started: admin', function ()
{
	$playground = Orchestra\Resources::make('playground', [
		'name'    => 'Playground',
		'uses'    => 'restful:AdminHomeController',
		'visible' => function ()
		{
			$acl = Orchestra\Acl::make('playground');
			
			return ($acl->can('manage article') or $acl->can('manage page'));
		}, 
	]);

	$playground['pages'] = 'resource:AdminPagesController';
});
