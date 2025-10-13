<?php

return [

    'management_schema' => [

        'actions' => [

            'label' => 'Códigos de verificació per correu electrònic',

            'below_content' => 'Rebi un codi temporal al seu correu electrònic per verificar la seva identitat durant l\'inici de sessió.',

            'messages' => [
                'enabled' => 'Habilitats',
                'disabled' => 'Deshabilitats',
            ],

        ],

    ],

    'login_form' => [

        'label' => 'Enviar un codi al seu correu electrònic',

        'code' => [

            'label' => 'Insereix el codi de 6 dígits que t\'hem enviat per correu electrònic',

            'validation_attribute' => 'codi',

            'actions' => [

                'resend' => [

                    'label' => 'Enviar un nou codi per correu electrònic',

                    'notifications' => [

                        'resent' => [
                            'title' => 'Us hem enviat un nou codi per correu electrònic.',
                        ],

                    ],

                ],

            ],

            'messages' => [

                'invalid' => 'El codi introduït no és vàlid.',

            ],

        ],

    ],

];
