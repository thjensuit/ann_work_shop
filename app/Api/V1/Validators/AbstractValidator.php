<?php
/**
 * Created by PhpStorm.
 * User: tungchung
 * Date: 5/20/16
 * Time: 3:00 PM
 */

namespace App\Api\V1\Validators;

use Validator;
use Dingo\Api\Exception\ValidationHttpException;

abstract class AbstractValidator
{
    /**
     * @return array
     */
    abstract protected function rules();


    /**
     * @param $input
     * @return
     * @throws ApiValidateException
     */
    public function validate($input)
    {
        $validator =  Validator::make($input, $this->rules(), $this->messages());

        if ($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->getMessages());
        }

        return $validator;
    }

    /**
     * @return array
     */
    protected function messages()
    {
        return [];
    }
}