<?php

namespace Website\Request\Blog;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class UpdateRequest
{
    public function validateForm($fields)
    {
        $validation = new Validation();

        $validation->add(
            [
                'title',
                'content',
                'category_id',
            ],
            new PresenceOf(
                [
                    'message' => ':field is required'
                ]
            )
        );

        $validation->add(
            "title",
            new StringLength(
                [
                    "max"            => 160,
                    "messageMaximum" => ":field just 160 characters",
                ]
            )
        );

        return $messages = $validation->validate($fields);
    }
}