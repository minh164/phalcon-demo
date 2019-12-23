<?php

namespace Website\Request\Auth;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\StringLength;

class registerRequest
{
    public function validateForm($fields)
    {
        $validation = new Validation();

        $validation->add(
            [
                'name',
                'email',
                'password',
                're_password'
            ],
            new PresenceOf(
                [
                    'message' => ':field is required'
                ]
            )
        );

        $validation->add(
            [
                'password'
            ],
            new Confirmation(
                [
                    "message" => [
                        "password" => "Password doesn't match confirmation",
                    ],
                    "with" => [
                        "password" => "re_password",
                    ],
                ]
            )
        );

        $validation->add(
            "password",
            new StringLength(
                [
                    "max"            => 20,
                    "min"            => 6,
                    "messageMaximum" => ":field just 20 characters",
                    "messageMinimum" => ":field less 6 characters",
                ]
            )
        );

        return $messages = $validation->validate($fields);
    }
}