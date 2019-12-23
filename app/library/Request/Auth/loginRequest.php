<?php

namespace Website\Request\Auth;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class loginRequest
{
    public function validateForm($fields)
    {
        $validation = new Validation();

        $validation->add(
            [
                'email',
                'password'
            ],
            new PresenceOf(
                [
                    'message' => ':field is required'
                ]
            )
        );

        $validation->add(
            [
                "email",
            ],
            new Email(
                [
                    "message" => ':field is not valid',
                ]
            )
        );

        return $messages = $validation->validate($fields);
    }
}