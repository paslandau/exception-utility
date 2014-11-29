<?php
namespace paslandau\ExceptionUtility;

use paslandau\ExceptionUtility\Exceptions\CompileErrorException;
use paslandau\ExceptionUtility\Exceptions\CoreErrorException;
use paslandau\ExceptionUtility\Exceptions\CoreWarningException;
use paslandau\ExceptionUtility\Exceptions\DeprecatedException;
use paslandau\ExceptionUtility\Exceptions\NoticeException;
use paslandau\ExceptionUtility\Exceptions\ParseException;
use paslandau\ExceptionUtility\Exceptions\RecoverableErrorException;
use paslandau\ExceptionUtility\Exceptions\StrictException;
use paslandau\ExceptionUtility\Exceptions\UserDeprecatedException;
use paslandau\ExceptionUtility\Exceptions\UserErrorException;
use paslandau\ExceptionUtility\Exceptions\UserNoticeException;
use paslandau\ExceptionUtility\Exceptions\UserWarningException;
use paslandau\ExceptionUtility\Exceptions\WarningException;

class ExceptionUtil
{
    /**
     * Returns all nested exceptions as one string
     * @param \Exception $e|null
     * @return string
     */
    public static function getAllErrorMessagesAsString(\Exception $e = null)
    {
        $errors = self::getAllErrorMessages($e);
        $eString = implode("\n => ", $errors);
        return $eString;
    }

    /**
     * Returns all nested exceptions as single dimensional array
     * @param \Exception $e|null
     * @return string[]
     */
    public static function getAllErrorMessages(\Exception $e = null){
        $errors = self::getAllErrors($e);
        $strings = [];
        foreach($errors as $key => $error){
            $strings[$key] = get_class($error).": ".$error->getMessage();
        }
        return $strings;
    }

    /**
     * @param \Exception $e|null
     * @return \Exception[]
     */
    public static function getAllErrors(\Exception $e = null){
        $es = [];
        while ($e !== null) {
            $hash = spl_object_hash($e);
            $es[$hash] = $e;
            $e = $e->getPrevious();
        };
        return $es;
    }

    /**
     * Takes care of PHP using notices etc. instead of throwing proper Exceptions by providing a custom error handler.
     * Use via set_error_handler([ExceptionUtil::class, "throwErrors"], E_RECOVERABLE_ERROR);
     * @param  $err_severity
     * @param  $err_msg
     * @param  $err_file
     * @param  $err_line
     * @param  $err_context
     * @throws \ErrorException
     * @throws WarningException
     * @throws ParseException
     * @throws NoticeException
     * @throws CoreErrorException
     * @throws CoreWarningException
     * @throws CompileErrorException
     * @throws UserErrorException
     * @throws UserWarningException
     * @throws UserNoticeException
     * @throws StrictException
     * @throws RecoverableErrorException
     * @throws DeprecatedException
     * @throws UserDeprecatedException
     * @return boolean
     */
    public static function throwErrors($err_severity, $err_msg, $err_file, $err_line, array $err_context)
    {

        if(error_reporting() < $err_severity){
//            echo "Ignored error: $err_severity\n$err_msg\n\n";
            return false;
        }
        // error was suppressed with the @-operator
        if (0 === error_reporting()) {
            return false;
        }

        switch ($err_severity) {
            case E_ERROR:
                throw new \ErrorException            ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_WARNING:
                throw new WarningException          ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_PARSE:
                throw new ParseException            ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_NOTICE:
                throw new NoticeException           ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_CORE_ERROR:
                throw new CoreErrorException        ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_CORE_WARNING:
                throw new CoreWarningException      ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_COMPILE_ERROR:
                throw new CompileErrorException     ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_COMPILE_WARNING:
                throw new CoreWarningException      ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_USER_ERROR:
                throw new UserErrorException        ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_USER_WARNING:
                throw new UserWarningException      ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_USER_NOTICE:
                throw new UserNoticeException       ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_STRICT:
                throw new StrictException           ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_RECOVERABLE_ERROR:
                throw new RecoverableErrorException ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_DEPRECATED:
                throw new DeprecatedException       ($err_msg, 0, $err_severity, $err_file, $err_line);
            case E_USER_DEPRECATED:
                throw new UserDeprecatedException   ($err_msg, 0, $err_severity, $err_file, $err_line);
            default:
                throw new \ErrorException            ($err_msg, 0, $err_severity, $err_file, $err_line);
        }
    }

//    public static function checkForFatal()
//    {
//        $error = error_get_last();
//        if ( in_array($error["type"], [E_ERROR,E_RECOVERABLE_ERROR]) ){
//            self::throwErrors($error["type"], $error["message"], $error["file"], $error["line"], [] );
//        }
//    }
}