<?php
/**
 * Created by PhpStorm.
 * User: tungchung
 * Date: 5/20/16
 * Time: 3:01 PM
 */

namespace App\Api\V1\Validators;


class SampleValidator extends AbstractValidator
{
    protected function rules()
    {
        return [
            'name'        => 'required',
            'description' => 'required',
        ];
    }
}