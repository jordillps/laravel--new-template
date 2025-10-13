<?php

return [

    'label' => 'Apagar',

    'modal' => [

        'heading' => 'Deshabilitar la aplicació d\'autenticació',

        'description' => '¿Segur que vol deixar d\'utilitzar la aplicació d\'autenticació? Deshabilitar-la eliminarà una capa addicional de seguretat del seu compte.',

        'form' => [

            'code' => [

                'label' => 'Insereix el codi de 6 dígits de l\'aplicació d\'autenticació',

                'validation_attribute' => 'codi',

                'actions' => [

                    'use_recovery_code' => [
                        'label' => 'Use un codi de recuperació en el seu lloc',
                    ],

                ],

                'messages' => [

                    'invalid' => 'El codi introduït no és vàlid.',

                ],

            ],

            'recovery_code' => [

                'label' => 'O bé, insereix un codi de recuperació',

                'validation_attribute' => 'codi de recuperació',

                'messages' => [

                    'invalid' => 'El codi de recuperació introduït no és vàlid.',

                ],

            ],

        ],

        'actions' => [

            'submit' => [
                'label' => 'Deshabilitar aplicació d\'autenticació',
            ],

        ],

    ],

    'notifications' => [

        'disabled' => [
            'title' => 'La aplicació d\'autenticació ha estat deshabilitada',
        ],

    ],

];
