<?php

Orchestra\Acl::make('playground')->attach(Orchestra\App::memory());

Event::listen('orchestra.started: admin', function ()
{
	$playground = Orchestra\Resources::make('playground', [
		'name' => 'Playground',
		'uses' => 'restful:AdminHomeController',
	]);
});
