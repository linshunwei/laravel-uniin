<?php

namespace Linshunwei\Uniin\Facades;

use Illuminate\Support\Facades\Facade;

class Uniin extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'uniin';
	}
}
