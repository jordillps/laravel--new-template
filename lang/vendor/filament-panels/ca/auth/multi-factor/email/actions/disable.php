<?php

return [

    'label' => 'Apagar',

    'modal' => [

        'heading' => 'Deshabilitar codi de verificació per correu',

        'description' => '¿Seguro que desea dejar de recibir codis de verificació per correu? Desactivar aquesta opció eliminarà una capa addicional de seguretat de la seva compte.',

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
                'label' => 'Deshabilitar codis de verificació per correu',
            ],

        ],

    ],

    'notifications' => [

        'disabled' => [
            'title' => 'Els codis de verificació per correu han estat deshabilitats',
        ],

    ],

];
