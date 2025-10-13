<?php

return [

    'label' => 'Regenerar codi de recuperació',

    'modal' => [

        'heading' => 'Regenerar codis de recuperació de l\'aplicació d\'autenticació',

        'description' => 'Si perd els seus codis de recuperació, pot regenerar-los aquí. Els seus codis de recuperació antics s\'invalidaran immediatament.',

        'form' => [

            'code' => [

                'label' => 'Insereix el codi de 6 dígits de l\'aplicació d\'autenticació',

                'validation_attribute' => 'codi',

                'messages' => [

                    'invalid' => 'El codi introduït no és vàlid.',

                ],

            ],

            'password' => [

                'label' => 'O bé, insereix la teva contrasenya actual',

                'validation_attribute' => 'contrasenya',

            ],

        ],

        'actions' => [

            'submit' => [
                'label' => 'Regenerar codis de recuperació',
            ],

        ],

    ],

    'notifications' => [

        'regenerated' => [
            'title' => 'S\'han generat nous codis de recuperació de l\'aplicació d\'autenticació',
        ],

    ],

    'show_new_recovery_codes' => [

        'modal' => [

            'heading' => 'Nous codis de recuperació',

            'description' => 'Guardeu els següents codis de recuperació en un lloc segur. Només es mostraran una vegada, i els necessitareu si perdeu l\'accés a la vostra aplicació d\'autenticació:',

            'actions' => [

                'submit' => [
                    'label' => 'Tancar',
                ],

            ],

        ],

    ],

];
