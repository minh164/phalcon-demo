<?php

return [
    'routes' => [
        [
            'prefix' => '/admin',
            'class' => Website\Controllers\Admin\AuthController::class,
            'methods' => [
                'get' => [
                    '404' => ['/404' => 'notfoundAction'],
                    'admin.login' => ['/login' => 'showLoginFormAction'],
                    'admin.register' => ['/register' => 'showRegisterFormAction'],
                    'admin.logout' => ['/logout' => 'logoutAction']
                ],
                'post' => [
                    'admin.login.submit' => ['/submit/login' => 'submitLoginAction'],
                    'admin.register.submit' => ['/submit/register' => 'submitRegisterAction']
                ],
            ],
        ],
        [
            'prefix' => '/admin/blog',
            'class' => Website\Controllers\Admin\BlogController::class,
            'methods' => [
                'get' => [
                    'admin.blog.list' => ['/list' => 'listAction'],
                    'admin.blog.create' => ['/create' => 'createAction'],
                    'admin.blog.edit' => ['/edit/{id}' => 'editAction'],
                ],
                'post' => [
                    'admin.blog.store' => ['/store' => 'storeAction'],
                    'admin.blog.update' => ['/update/{id}' => 'updateAction']
                ],
            ],
        ],
        [
            'prefix' => '/api/admin/blog',
            'class' => Website\Controllers\Api\Admin\BlogController::class,
            'methods' => [
                'get' => [
                    'api.admin.blog.list' => ['/list' => 'listAction'],
                    'api.admin.blog.edit' => ['/show/{id}' => 'showAction'],
                ],
                'post' => [
                    'api.admin.blog.store' => ['/store' => 'storeAction'],
                    'api.admin.blog.update' => ['/update/{id}' => 'updateAction']
                ],
                'delete' => [
                    'api.admin.blog.delete' => ['/delete/{id}' => 'destroyAction']
                ]
            ],
        ],
        [
            'prefix' => '/api/admin/category',
            'class' => Website\Controllers\Api\Admin\CategoryController::class,
            'methods' => [
                'get' => [
                    'api.admin.category.list' => ['/list' => 'listAction'],
//                    'api.admin.blog.edit' => ['/show/{id}' => 'showAction'],
                ],
                'post' => [
//                    'api.admin.blog.store' => ['/store' => 'storeAction'],
//                    'api.admin.blog.update' => ['/update/{id}' => 'updateAction']
                ],
                'delete' => [
//                    'api.admin.blog.delete' => ['/delete/{id}' => 'destroyAction']
                ]
            ],
        ]
    ],
    'middleware' => [
//        [
//            'event' => 'before',
//            'class' => Website\Middleware\EnvironmentMiddleware::class,
//        ],
//        [
//            'event' => 'before',
//            'class' => Website\Middleware\NotFoundMiddleware::class,
//        ],
//        [
//            'event' => 'before',
//            'class' => Website\Middleware\RedirectMiddleware::class,
//        ],
//        [
//            'event' => 'before',
//            'class' => Website\Middleware\AssetsMiddleware::class,
//        ],
        [
            'event' => 'before',
            'class' => Website\Middleware\AuthenticateMiddleware::class,
        ],
        [
            'event' => 'after',
            'class' => Website\Middleware\ViewMiddleware::class,
        ]
    ]
];