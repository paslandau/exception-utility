<?php

use paslandau\ArrayUtility\ArrayUtil;
use paslandau\ExceptionUtility\ExceptionUtil;

class ExceptionUtilTest extends PHPUnit_Framework_TestCase {

    public function test_getAllErrors(){

        $first = new InvalidArgumentException("first");
        $second = new UnexpectedValueException("second",0,$first);
        $third = new RuntimeException("third",0,$second);
        $exceptions = new Exception("foo",0, $third);

        $all = [
            spl_object_hash($exceptions) => $exceptions,
            spl_object_hash($third) => $third,
            spl_object_hash($second) => $second,
            spl_object_hash($first) => $first,
        ];

        $strings = [];
        /**
         * @var Exception $error
         */
        foreach($all as $key => $error){
            $strings[$key] = get_class($error).": ".$error->getMessage();
        }

        $eString = implode("\n => ", $strings);

        $tests = [
            "getAllErrors" => [
                "method" => "getAllErrors",
                "input" => $exceptions,
                "expected" => $all,
            ],
            "getAllErrors-null" => [
                "method" => "getAllErrors",
                "input" => null,
                "expected" => [],
            ],
            "getAllErrorMessages" => [
                "method" => "getAllErrorMessages",
                "input" => $exceptions,
                "expected" => $strings,
            ],
                "getAllErrorMessagesAsString" => [
                    "method" => "getAllErrorMessagesAsString",
                    "input" => $exceptions,
                    "expected" => $eString,
                ]
                ];


        foreach($tests as $test => $data) {
            $method = $data["method"];
            $input = $data["input"];
            $expected = $data["expected"];
            $res = call_user_func([ExceptionUtil::class, $method],$input);
            $msg = [
                "Error in test $test:",
                "Input    : " . json_encode($input),
                "Excpected: " . json_encode($expected),
                "Actual   : " . json_encode($res),
            ];
            $msg = implode("\n", $msg);
            if(is_array($expected)) {
                $this->assertTrue(ArrayUtil::equals($res, $expected, true, true, true), $msg);
            }else{
                $this->assertEquals($expected, $res, $msg);
            }
        }

    }
}
 