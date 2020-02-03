<?php

namespace App;

use Exception;
use stdClass;

class Declension
{
    /** @var stdClass Правила */
    private stdClass $rules;

    /** @var int Пол */
    private int $gender;

    /**
     * Считывание правил
     *
     * @throws Exception
     */
    protected function setupRules(): void
    {
        /** @var string $rulesFilePath TODO сделать путь настраиваемым */
        $rulesFilePath = '../app/rules.json';
        $rulesFile = fopen($rulesFilePath, 'r');

        if (false === $rulesFile) {
            throw new Exception('Файл не найден');
        }

        $rules = fread($rulesFile, filesize($rulesFilePath));
        fclose($rulesFile);

        $this->rules =json_decode($rules);
    }

    /**
     * Declension constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->gender = Gender::getNotDeterminedGender();
        $this->setupRules();
    }

    /**
     * Обработка строки
     *
     * Происходит по слудующему алгоритму. Сначала проверяются исключительные случаи,
     * затем проверяются обычные правила
     *
     * @param string $name
     * @param int $case
     * @param string $type
     *
     * @return string
     * @throws Exception
     */
    protected function process(string $name, int $case, string $type): string
    {
        if (!in_array($case, GrammarCase::allCases(), true)) {
            throw new Exception('Падеж указан неправильно');
        }

        //Неочевидное и плохое место - так как падежи у нас не сходятся по нумерации, а нумерацию падежей хочется оставить с нуля,
        //был оставлен такой костыль, который нужно убрать
        $case = $case - 1;
        
        return $this->applyRules($name, $case, $type);
    }

    /**
     * Обработка регулярных правил и применение подходящих из них
     *
     * @param string $name
     * @param int $case
     * @param string $type
     * @return string
     */
    private function applyRules(string $name, int $case, string $type): string
    {
        foreach ($this->rules->{$type}->regular as $rule) {

            if (!$this->isGenderRight($rule->gender ?? '')) {
                continue;
            }

            foreach ($rule->match as $ending) {
                $nameEnding = mb_substr($name, mb_strlen($name) - mb_strlen($ending), mb_strlen($ending));
                if ($ending === $nameEnding) {
                    if (empty($rule->replacement[$case])) {
                        return $name;
                    }

                    return $this->applyRule($rule->replacement[$case], $name);
                }
            }
        }

        return $name;
    }

    /**
     *
     *
     * @param int $gender
     */
    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * Замена окончания по правилу
     *
     * @param string $replacement
     * @param string $name
     * @return string
     */
    private function applyRule(string $replacement, string $name): string
    {
        $result = mb_substr($name, 0, mb_strlen($name) - mb_substr_count($replacement, '-'));
        return $result . str_replace('-', '', $replacement);
    }

    /**
     * Функция определяет, подходит ли для этого пола правило
     *
     * @param string $gender
     * @return bool
     */
    private function isGenderRight(string $gender): bool
    {
        $gendersMatching = static::getGenderMatching();
        $innerGender = $gendersMatching[$gender];
        return $innerGender === Gender::getNotDeterminedGender() || $this->gender === $innerGender;
    }

    private static function getGenderMatching(): array
    {
        return [
            'all' => Gender::getNotDeterminedGender(),
            'male' => Gender::getMaleGender(),
            'female' => Gender::getFemaleGender(),
        ];
    }

    /**
     * Приводит все слова к одному регистру
     *
     * TODO Можно вынести в утилиты, сделать интерфейс для работы со строками и DI
     *
     * @param string $value
     * @return string
     */
    public static function toSingleRegister(string $value): string
    {
        return mb_strtolower($value);
    }

    /**
     * Функция принимает имя и падеж, возвращает обработанное имя в правильном падеже
     *
     * TODO name и surname можно соединить, так как отличия минимальны
     *
     * @param string|null $name
     * @param int|null $case
     * @return string|null
     * @throws Exception
     */
    public function name(?string $name = null, ?int $case = null): string
    {
        if (empty($name)) {
            throw new Exception('Имя не может быть пустым');
        }

        if (Gender::getNotDeterminedGender() === $this->gender) {
            throw new Exception('Необходимо сначала задать пол');
        }

        if (empty($case)) {
            return $name;
        }

        return $this->process($name, $case, __FUNCTION__);
    }

    /**
     * Функция принимает фамилию и падеж, возвращает обработанную фамилию в правильном падеже
     *
     * @param string|null $surname
     * @param int|null $case
     * @return string|null
     * @throws Exception
     */
    public function surname(?string $surname = null, ?int $case = null): string
    {
        if (empty($surname)) {
            throw new Exception('Имя не может быть пустым');
        }

        if (Gender::getNotDeterminedGender() === $this->gender) {
            throw new Exception('Необходимо сначала задать пол');
        }

        if (empty($case)) {
            return $surname;
        }

        return $this->process($surname, $case, __FUNCTION__);
    }

}