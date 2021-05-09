<?php
/**
 * @author    fanjunjun
 */
namespace GatewayWorker\Lib;

/**
 * 数据库类
 */
class Log
{
    // 日志级别 从上到下，由低到高
    const EMERG   = 'EMERG';  // 严重错误: 导致系统崩溃无法使用 7
    const ALERT    = 'ALERT';  // 警戒性错误: 必须被立即修改的错误 6
    const CRIT      = 'CRIT';  // 临界值错误: 超过临界值的错误，例如一天24小时，而输入的是25小时这样 5
    const ERR       = 'ERR';  // 一般错误: 一般性错误 4
    const WARN    = 'WARN';  // 警告性错误: 需要发出警告的错误 3
    const NOTICE  = 'NOTIC';  // 通知: 程序可以运行但是还不够完美的错误 2
    const INFO     = 'INFO';  // 信息: 程序输出信息 1
    const DEBUG   = 'DEBUG';  // 调试: 调试信息 0

    private static $log_type = 1; //0.all 1.messge 2.connect 3.close 4.error 

    private static $handle = 'messge';
    private static $action = '';
    public static function getLogType() : int{ 
        return static::$log_type;
    } 

    public static function setLogType($type, $handle = '', $action = '') : void{
        static::$log_type = $type;
        
        if ($type != 1 && !$handle) {
            if ($type == 0) {
                $handle = "access";
            } elseif ($type == 2) {
                $handle = "onConnect";
            } elseif ($type == 3) {
                $handle = "onClose";
            } elseif ($type == 4) {
                $handle = "onError";
            }
            static::setAction($action);
        }
        if ($handle) {
            static::setHandle($handle);
            if ($action) {
                static::setAction($action);
            }
        }
    }

    public static function setHandle($h) {
        static::$handle = $h;
    }
    public static function setAction($a) {
        static::$action = $a;
    }
    /**
     * 日志直接写入
     * @static
     * @access public
     * @param string $message 日志信息
     * @param string $level  日志级别
     * @param integer $type 日志记录方式
     * @param string $extra 额外参数
     * @return void
     */
    public static function write($message, $level=self::ERR, $destination='') {
		$destination = self::getLogFile($destination);
        $now = date('Y-m-d H:i:s');
        error_log("{$now}". " | {$level}: {$message}\r\n", 3,$destination );
    }

    public static function getLogFile($destination) {
        if (!$destination) {
		    $destination = LOG_PATH . static::$handle . "_" . static::$action . "_". date('y_m_d') . ".log";
        }
		return $destination;
	}
    
}
