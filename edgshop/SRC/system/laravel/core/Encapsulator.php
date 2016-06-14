<?php  namespace App\Eloquent; 

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;

/**
 * Class Encapsulator
 *
 * @author Original encapsulation pattern contributed by Kayla Daniels
 * @package App\Eloquent
 */
class Encapsulator
{
	private static $conn;

	private function __construct() {}

	static public function init()
	{
		$capsule = null;

		if (is_null(self::$conn))
		{
			$capsule = new Capsule;
//			$capsule->addConnection([
//				'driver'    => DB_DRIVER,
//				'host'      => DB_HOSTNAME,
//				'database'  => DB_DATABASE,
//				'username'  => DB_USERNAME,
//				'password'  => DB_PASSWORD,
//				'charset'   => 'utf8',
//				'collation' => 'utf8_unicode_ci',
//				'prefix'    => DB_PREFIX,
//			]);
                                                      //analytics logic(@author wql @date:2016/3/30)连接主从库信息
                                                      $_db_config = unserialize(DB_SETTING);
                                                      foreach($_db_config as $key=>$arr)
                                                      {
                                                               $capsule->addConnection([
				'driver'     => $arr['driver'],
				'host'      => $arr['host'],
				'database'   => $arr['database'],
				'username'  => $arr['username'],
				'password'   => $arr['password'],
				'charset'   => 'utf8',
				'collation'  => 'utf8_unicode_ci',
				'prefix'      => $arr['prefix'],
			         ], $key);
                                                      }
                                                      //analytics logic END.

			$capsule->setEventDispatcher(new Dispatcher(new Container));

			$capsule->setAsGlobal();

			$capsule->bootEloquent();
		}
		return $capsule;
	}
}
