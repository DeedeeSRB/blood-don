<?php
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Base;

use Inc\Base\DatabaseCreator;

class Activate
{
	public static function activate() 
	{
		DatabaseCreator::createTables();
		flush_rewrite_rules();
	}
}