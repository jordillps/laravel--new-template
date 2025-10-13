<?php

return [

    'management_schema' => [

        'actions' => [

            'label' => 'Aplicació d\'autenticació',

            'below_content' => 'Utilitzeu una aplicació segura per generar un codi temporal per verificar l\'inici de sessió.',

            'messages' => [
                'enabled' => 'Habilitada',
                'disabled' => 'Deshabilitada',
            ],

        ],

    ],

    'login_form' => [

        'label' => 'Utilitzeu un codi de la vostra aplicació d\'autenticació',

        'code' => [

            'label' => 'Insereix el codi de 6 dígits de l\'aplicació d\'autenticació',

            'validation_attribute' => 'codi',

            'actions' => [

                'use_recovery_code' => [
                    'label' => 'Utilitzeu un codi de recuperació en el seu lloc',
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

];
