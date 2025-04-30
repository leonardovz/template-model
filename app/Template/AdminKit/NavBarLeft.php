<?php

namespace App\Templates\AdminKit;

use App\Config\Config;
use App\Template\Template;

class NavBarLeft
{

    static function NavBarLeft($active = "index", $sub_active = "index")
    {
        $menu = self::build_menu($active, $sub_active);
        $ruta = Config::RUTA();
        $T = new Template();
        $imagen = $T->LOGO;


        return '<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                    <div class="app-brand main-menu">
                        <a href="' . $ruta . 'sistema" class="app-brand-link">
                            <span class="app-brand-logo main-menu">
                                <img src="' . $ruta . $imagen . '" width="38px">
                            </span>
                            <span class="app-brand-text main-menu menu-text fw-bolder ms-2">' . $T->SISTEMNAME . '</span>
                        </a>

                        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                            <i class="bx bx-chevron-left bx-sm align-middle"></i>
                        </a>
                    </div>

                    <div class="menu-inner-shadow"></div>

                    <ul class="menu-inner py-1">
                        ' . $menu . '
                    </ul>
                </aside>';
    }
    static public function build_menu($active, $sub_active)
    {
        $navegacion = NavMenu::navegacion();
        $menu = "";

        foreach ($navegacion as $i_item => $item) {
            if (!isset($item['sub_menu'])) $menu .=  self::nav_menu($item, ($i_item == $active));
            else $menu .=  self::nav_submenu($item, ($i_item == $active), $sub_active);
        }

        return $menu;
    }
    static function nav_menu($item, $active)
    {
        $active = ($active ? 'active' : '');
        $ruta = Config::RUTA() . $item['link'];
        $icon = $item['icon'];
        $name = $item['name'];

        return "<li class=\"menu-item $active\">
                    <a href=\"$ruta\" class=\"menu-link\">
                        <i class=\"$icon\"></i>
                        <div data-i18n=\"$name\">$name</div>
                    </a>
                </li>";
    }
    static function nav_submenu($item, $active, $sub_active)
    {

        $sub_menus = '';
        foreach ($item['sub_menu'] as $i_item => $sub_item) {
            $status_active = ($sub_active == $i_item ? 'active' : '');
            $ruta = Config::RUTA() . $sub_item['link'];
            $icon = $sub_item['icon'];
            $name = $sub_item['name'];

            $sub_menus .=  "<li class=\"menu-item $status_active\">
                                <a href=\"$ruta\" class=\"menu-link \">
                                    <div data-i18n=\"$name\">$name</div>
                                </a>
                            </li>";
        }


        $active = ($active ? 'active open' : '');
        $icon = $item['icon'];
        $name = $item['name'];

        return "<li class=\"menu-item $active\">
                    <a href=\"javascript:void(0);\" class=\"menu-link menu-toggle\">
                        <i class=\"$icon\"></i>
                        <div data-i18n=\"$name\">$name</div>
                    </a>
                    <ul class=\"menu-sub\">
                        $sub_menus
                    </ul>
                </li>";
    }
}
