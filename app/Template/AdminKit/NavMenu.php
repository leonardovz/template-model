<?php

namespace App\Templates\AdminKit;

class NavMenu
{
    static public function navegacion()
    {
        return [
            // 'imagenes' => [
            //     'ico' => 'galery/logo/logotipo.png',
            // ],
            'index' => [
                'icon' => 'menu-icon tf-icons bx bx-home-circle',
                'name' => 'Tablero',
                'link' => 'sistema'
            ],
            'servicios' => [
                'icon' => 'menu-icon fa-solid fa-users-rectangle',
                'name' => 'Servicios',
                'link' => '#',
                'sub_menu' => [
                    'negocios' => [
                        'icon' => 'fa-solid fa-users-rectangle me-3',
                        'name' => 'Negocios',
                        'link' => 'sistema/negocios'
                    ],
                    'servicios' => [
                        'icon' => 'bx bxs-user-circle me-3',
                        'name' => 'Servicios',
                        'link' => 'sistema/servicios'
                    ],
                ]
            ],
            'configuracion' => [
                'icon' => 'menu-icon bx bx-cog',
                'name' => 'Configuración',
                'link' => '#',
                'sub_menu' => [
                    'usuarios' => [
                        'icon' => 'bx bxs-user-circle me-3',
                        'name' => 'Usuarios',
                        'link' => 'sistema/usuarios'
                    ],
                    'config' => [
                        'icon' => 'bx bxs-user-circle me-3',
                        'name' => 'Sistema',
                        'link' => 'sistema/config'
                    ],
                ]
            ]
        ];
    }
}
