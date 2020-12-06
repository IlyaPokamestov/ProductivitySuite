<?php

namespace IlyaPokamestov\ProductivitySuite\Tests;

/**
 * Class RandomString
 * @package IlyaPokamestov\ProductivitySuite\Tests
 */
class RandomString
{
    const alfaNumberCharacters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const alfaNumberCharactersLength = 62;

    /**
     * @param int $length
     * @return string
     */
    public static function string(int $length = 20)
    {
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= self::alfaNumberCharacters[rand(0, self::alfaNumberCharactersLength - 1)];
        }

        return $randomString;
    }
}
