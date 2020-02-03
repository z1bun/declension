<?php

namespace App;

/**
 * Класс GrammarCase отвечает за единое значение констант падежей русского языка. Назван так из-за наличия ключевого
 * слова case
 *
 * @package App
 */
class GrammarCase
{
    /**
     * Возвращает значение именительного падежа
     *
     * @return int
     */
    public static function getNominativeCase(): int
    {
        return 0;
    }

    /**
     * Возвращает значение родительного падежа
     *
     * @return int
     */
    public static function getGenitiveCase(): int
    {
        return 1;
    }

    /**
     * Возвращает значение дательного падежа
     *
     * @return int
     */
    public static function getDativeCase(): int
    {
        return 2;
    }

    /**
     * Возвращает значение винительного падежа
     *
     * @return int
     */
    public static function getAccusativeCase(): int
    {
        return 3;
    }

    /**
     * Возвращает значение творительного падежа
     *
     * @return int
     */
    public static function getInstrumentalCase(): int
    {
        return 4;
    }

    /**
     * Возвращает значение предложного падежа
     *
     * @return int
     */
    public static function getPrepositionalCase(): int
    {
        return 5;
    }

    /**
     * Возвращает все значения падежей
     * TODO добавить названия, если будет нужно
     *
     * @return array
     */
    public static function allCases(): array
    {
        return [0, 1, 2, 3, 4, 5];
    }

}