<?php

return [

    'label' => 'Configurar',

    'modal' => [

        'heading' => 'Configurar codis de verificació per correu electrònic',

        'description' => 'Necessitarà inserir el codi de 6 dígits que li hem enviat per correu electrònic cada vegada que iniciï sessió o realitzi accions sensibles. Reviseu el vostre correu electrònic per trobar el codi de 6 dígits i completar la configuració.',

        'form' => [

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

        'actions' => [

            'submit' => [
                'label' => 'Habilitar codis de verificació per correu',
            ],

        ],

    ],

    'notifications' => [

        'enabled' => [
            'title' => 'S\'han habilitat els codis de verificació per correu electrònic',
        ],

    ],

];
