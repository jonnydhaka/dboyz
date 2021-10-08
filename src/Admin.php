<?php

namespace Dboyz\PS;

/**
 * The admin class
 */
class Admin
{

	/**
	 * Initialize the class
	 */
	function __construct()
	{

		new Admin\Menu\Menu();
		new Admin\Meta\Meta();
	}
}
