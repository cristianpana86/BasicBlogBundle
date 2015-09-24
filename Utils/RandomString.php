<?php

namespace CPANA\BasicBlogBundle\Utils;
/**
 * Random string generator 
 */
class RandomString
{
    /**
     * Generates a random string with default length of 10 characters
     *
     * @param integer $length 
     *
     * @return string - a random generated string
     */
    public static function randomStr($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    
    }


}
