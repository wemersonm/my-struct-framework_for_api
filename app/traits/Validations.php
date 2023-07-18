<?php

namespace app\traits;

use app\models\Filters;
use app\models\QueryBuilder;
use app\supports\Request;
use app\supports\Validate;

class Validations
{
    use Validate;

    private array $msgValidations = [];

    public function required(string $field)
    {
        $value = Request::input($field);
        $value = trim($value);
        if (strlen($value) <= 0) {
            $this->msgValidations[$field][] = "Campo obrigatorio";
            return false;
        }
        return $value;
    }
    public function alpha(string $field)
    {
        $value = Request::input($field);

        if (!preg_match("/^[a-zA-Z]+$/", $value)) {
            $this->msgValidations[$field][] = "Campo permitide somente letras";
            return false;
        }
        return $value;
    }
    public function numeric(string $field)
    {
        $value = Request::input($field);

        if (!preg_match("/^[0-9]+$/", $value)) {
            $this->msgValidations[$field][] = "Campo permitide somente numeros";
            return false;
        }
        return $value;
    }
    public function in(string $field, mixed $param)
    {
        $value = Request::input($field);
        if (is_array($param)) {
            if (!in_array($value, $param)) {
                $this->msgValidations[$field][] = "Valor informado invalido";
                return false;
            }
        }
        return ($value == $param) ? $value : false;
    }
    public function email(string $field)
    {
        $value = filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL);
        if (!$value) {
            $this->msgValidations[$field][] = "Email invalido";
            return false;
        }
        return $value;
    }
    public function unique(string $field, string $param)
    {
        $filter = new Filters();
        $query = new QueryBuilder();
        $value = Request::input($field);
        $filter->where("email_user", "=", $value);
        $hasEmail =  $query->setFilters($filter)->setTable($param)->findBy();

        if (!empty($hasEmail)) {
            $this->msgValidations[$field][] = "Email já existente no sistema";
            return false;
        }
        return $value;
    }

    public function min(string $field, string $number)
    {
        $value = trim(Request::input($field));

        if (strlen($value) < $number) {
            $this->msgValidations[$field][] = "Informe mais de {$number} caracteres";
            return false;
        }
        return $value;
    }
    public function max(string $field, string $number)
    {
        $value = trim(Request::input($field));

        if (strlen($value) > $number) {
            $this->msgValidations[$field][] = "Informe mais de {$number} caracteres";
            return false;
        }
        return $value;
    }
    public function alpha_num(string $field)
    {
        $value = trim(Request::input($field));
        if (!preg_match("/^[a-zA-Z0-9]+$/", $value)) {
            $this->msgValidations[$field][] = "O campo deve conter apenas letras e numeros";
            return false;
        }
        return $value;
    }

    public function regex(string $field, string $pattern)
    {
        $value = trim(Request::input($field));
        if (!preg_match("/{$pattern}/", $value)) {

            $this->msgValidations[$field][] = "O valor do campo não corresponde ao pattern";
            return false;
        }
        return $value;
    }

    public function date(string $field)
    {
        $value = trim(Request::input($field));
        $timeDate = strtotime($value);
        if ($timeDate == false) {
            $this->msgValidations[$field][] = "Data invalida";
            return false;
        }
        return $value;
    }

    public function between(string $field, mixed $param)
    {
        $value = trim(Request::input($field));
        list($min, $max) = $param;

        if ($value < $min || $value > $max) {
            $this->msgValidations[$field][] = "O valor informado não está dentro do intervalo definido";
            return false;
        }
        return $value;
    }
    public function not_in(string $field, mixed $param)
    {
        $value = trim(Request::input($field));
        if (is_array($param)) {
            if (in_array($value, $param)) {
                $this->msgValidations[$field][] = "O valor informado invalido";
                return false;
            }
        }
        return ($value == $param) ? false : $value;
    }

    public function same(string $field, string $param)
    {
        $value = trim(Request::input($field));
        $beforeValue = trim(Request::input($param));
        if ($value != $beforeValue) {
            $this->msgValidations[$field][] = "O campo não corresponde";
            return false;
        }
        return $value;
    }
}
