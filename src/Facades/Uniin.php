<?php

namespace Linshunwei\Uniin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Linshunwei\Uniin\Services\WhitelistCallerService whitelistCaller()
 * @method static \Linshunwei\Uniin\Services\AxbService axb()
 * @method static \Linshunwei\Uniin\Services\AxybService axyb()
 * @method static \Linshunwei\Uniin\Services\AxnService axn()
 * @method static \Linshunwei\Uniin\Services\AxnExtService axnExt()
 */
class Uniin extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'uniin';
	}
}
