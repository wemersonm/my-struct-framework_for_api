<?php

namespace app\supports;

use Exception;

trait Validate
{
    private array $dataValidations = [];

    public function validations(array $validations)
    {
        foreach ($validations as $field => $validation) {
            $param = '';
            $existPipe = str_contains($validation, "|");
            if (!$existPipe) {
                list($validation, $param) = $this->paramExist($validation);
                $this->methodExist($validation);
                $this->dataValidations[$field] = $this->$validation($field, $param);
            }
            if ($existPipe) {
                $othersValidations = explode("|", $validation);
                foreach ($othersValidations as $validation) {
                    list($validation, $param) = $this->paramExist($validation);
                    $this->methodExist($validation);
                    $this->dataValidations[$field] = $this->$validation($field, $param);
                    if ($this->dataValidations[$field] === false)
                        break;
                }
            }
        }
        $this->returnDataValidations();
    }

    private function returnDataValidations()
    {
        return in_array(false, $this->dataValidations, true)
            ?
            ["validations" => false, "msgError" => $this->msgValidations]
            :
            ["validations" => true, "data" => $this->dataValidations];
    }
    private function methodExist(string $validation)
    {
        if (!method_exists($this, $validation)) {
            throw new Exception("O metodo de validação {$validation} não existe");
        }
    }
    private function paramExist(string $validation)
    {
        if (str_contains($validation, ":")) {
            list($validation, $param) = explode(":", $validation);
            $param = str_contains($param, ",") ? explode(",", trim($param)) : $param;
            return [$validation, $param];
        }
    }
}
