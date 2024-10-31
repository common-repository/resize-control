<?php

namespace Reco;

class AdminPage
{
    public function createPage()
    {

        //If global admin page doesn't exist, create it
        global $submenu;
        $hook = get_plugin_page_hookname('tuning-wp', '');
        $tuningIcon = 'data:image/svg+xml;base64, PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c3ZnIGlkPSJhIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0NTAuNzkgNDUwLjgzIj48ZGVmcz48c3R5bGU+LmJ7b3BhY2l0eTouNTU7fS5iLC5je2ZpbGw6IzQyNzJmOTt9PC9zdHlsZT48L2RlZnM+PHBhdGggY2xhc3M9ImIiIGQ9Im0yOTIuNzEsMjQzLjI1bC04NS4xNy04NS4xN2MtOS43Ni05Ljc2LTI1LjU5LTkuNzYtMzUuMzYsMGgwYy05Ljc2LDkuNzYtOS43NiwyNS41OSwwLDM1LjM2bDcuMjMsNy4yM2M5Ljc2LDkuNzYsOS43NiwyNS41OSwwLDM1LjM2bC0zOS4xLDM5LjFjLTkuNzYsOS43Ni05Ljc2LDI1LjU5LDAsMzUuMzZoMGM5Ljc2LDkuNzYsMjUuNTksOS43NiwzNS4zNiwwbDM5LjEtMzkuMWM5Ljc2LTkuNzYsMjUuNTktOS43NiwzNS4zNiwwbDcuMjMsNy4yM2M5Ljc2LDkuNzYsMjUuNTksOS43NiwzNS4zNiwwaDBjOS43Ni05Ljc2LDkuNzYtMjUuNTksMC0zNS4zNloiLz48cGF0aCBjbGFzcz0iYyIgZD0ibTQyNS41MywxNjUuNTRMMjg0LjQ3LDI0LjQ4QzI2OC42NSw4LjY2LDI0Ny42MS0uMDQsMjI1LjI0LDBjLTIyLjQ0LjA0LTQzLjg3LDkuMzktNTkuNzQsMjUuMjZMMjQuNDQsMTY2LjMyYy0zMi41OSwzMi41OS0zMi41OSw4NS42MSwwLDExOC4xOWw3LjA1LDcuMDVjOS43Niw5Ljc2LDI1LjU5LDkuNzYsMzUuMzYsMCw5Ljc2LTkuNzYsOS43Ni0yNS41OSwwLTM1LjM2bC03LjA1LTcuMDVjLTEzLjA5LTEzLjA5LTEzLjA5LTM0LjM5LDAtNDcuNDhMMjAxLjYzLDU5LjgzYzYuNDctNi40NywxNS4xMy05Ljk4LDI0LjMtOS44Myw4LjkuMTQsMTcuMzQsMy45OSwyMy42MywxMC4yOGwxNDEuMzksMTQxLjM5YzYuNDcsNi40Nyw5Ljk4LDE1LjEzLDkuODMsMjQuMzEtLjE1LDguOS0zLjk5LDE3LjM0LTEwLjI4LDIzLjYzbC0xNDEuMzksMTQxLjM4Yy02LjQ3LDYuNDctMTUuMTMsOS45OC0yNC4zLDkuODMtOC45LS4xNC0xNy4zNC0zLjk5LTIzLjYzLTEwLjI4bC0yOS4wNS0yOS4wNWMtNi4zNC02LjM0LTkuODMtMTQuNzctOS44My0yMy43NHMzLjQ5LTE3LjQsOS44My0yMy43NGwzLjU0LTMuNTRjLTkuNzYsOS43Ni0yNS41OSw5Ljc2LTM1LjM2LDBoMGMtOS43Ni05Ljc2LTkuNzYtMjUuNTksMC0zNS4zNmwtMy41MywzLjU0Yy0xNS44MiwxNS44Mi0yNC41MSwzNi44NS0yNC40OCw1OS4yMy4wMywyMi40NCw5LjM5LDQzLjg3LDI1LjI2LDU5Ljc0bDI3Ljk1LDI3Ljk1YzE1Ljg3LDE1Ljg3LDM3LjMsMjUuMjIsNTkuNzQsMjUuMjYsMjIuMzcuMDMsNDMuNDEtOC42Niw1OS4yMy0yNC40OGwxNDEuODQtMTQxLjg0YzE1LjgyLTE1LjgyLDI0LjUxLTM2Ljg1LDI0LjQ4LTU5LjIzLS4wMy0yMi40NC05LjM4LTQzLjg4LTI1LjI2LTU5Ljc1WiIvPjxwYXRoIGNsYXNzPSJjIiBkPSJtMjA3LjU0LDE1OC4wOGwxNy42OCwxNy42OCwxNy42OC0xNy42OGM5Ljc2LTkuNzYsOS43Ni0yNS41OSwwLTM1LjM2aDBjLTkuNzYtOS43Ni0yNS41OS05Ljc2LTM1LjM2LDBsLTM1LjM2LDM1LjM2aDBjOS43Ni05Ljc2LDI1LjU5LTkuNzYsMzUuMzYsMFoiLz48cGF0aCBjbGFzcz0iYyIgZD0ibTMyOC4wNiwyMDcuOWMtOS43Ni05Ljc2LTI1LjU5LTkuNzYtMzUuMzYsMGwtMTcuNjgsMTcuNjgsMTcuNjgsMTcuNjhjOS43Niw5Ljc2LDkuNzYsMjUuNTksMCwzNS4zNmwzNS4zNi0zNS4zNmM5Ljc2LTkuNzYsOS43Ni0yNS41OSwwLTM1LjM2WiIvPjwvc3ZnPg==';

        if (!isset($submenu[$hook])) {
            add_menu_page(
                'Resize Control',
                'Resize Control',
                'manage_options',
                'tuning-wp',
                false, //no callback
                $tuningIcon
            );
        }

        //Create subpage if tuning-wp is set
        add_submenu_page(
            'tuning-wp',
            'General',
            'General',
            'manage_options',
            'tuning-wp',
            [$this, 'returnContent']
        );
    }

    public function returnContent()
    {
        //RecoLoader found in helpers
        require RecoViewloader('MainTemplate');
    }

    public function addAdminPageIcon()
    {
        $styleString = "
            <style>
                .toplevel_page_tuning-wp .wp-menu-image {
                    filter: brightness(0) invert(1);
                }
                .toplevel_page_tuning-wp a:not(.current):hover .wp-menu-image {
                    filter: initial;
                }
            </style>
        ";
        echo wp_kses($styleString, ['style' => []]);
    }
}