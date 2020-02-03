<?php

namespace App;

/**
 * Класс Gender отвечает за единое значение констант пола человека
 *
 * @package App
 */
class Gender
{
    /**
     * Возвращает значение неопределенного пола
     *
     * @return int
     */
    public static function getNotDeterminedGender(): int
    {
        return 0;
    }

    /**
     * Возвращает значение мужского пола
     *
     * @return int
     */
    public static function getMaleGender(): int
    {
        return 1;
    }

    /**
     * Возвращает значение женского пола
     *
     * @return int
     */
    public static function getFemaleGender(): int
    {
        return 2;
    }

}