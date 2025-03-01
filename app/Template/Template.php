<?php

use App\Config\Config;

class Template
{
    private $headerScripts = [];
    private $headerStyles  = [];


    public $RUTA        = false;
    public $SISTEMNAME  = "";
    public $TITULO      = "";
    public $DESCRIPCION = "";
    public $KEYWORDS    = "";
    public $IMAGEN      = "images/icons/icon.png";
    public $LOGO        = "images/icons/icon.png";

    function v()
    {
        return "?v=" . Config::version();
    }

    function header($styles = false)
    {
        $header = "";
        $header .= '
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>' . $this->TITULO . ' </title>
                <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
                <meta http-equiv="Cache-control" content="no-cache">
                <meta http-equiv="Pragma" content="no-cache">
                <meta http-equiv="Expires" Content="0">
                <meta name="keywords" content="' . $this->KEYWORDS . '">
                <meta name="description" content="' . $this->DESCRIPCION . '">
                <meta name="robots" content="all">
                <meta name="author" content="WEBMASTER - Ing. Leonardo Vázquez Angulo">
                <!-- Open Graph protocol -->
                <meta property="og:title" content="' . $this->TITULO . '" />
                <meta property="og:site_name" content="' . $this->TITULO . '" />
                <meta property="og:type" content="website" />
                <meta property="og:url" content="' . Config::RUTA() . '" />
                <meta property="og:image" content="' . Config::RUTA() . $this->IMAGEN . '" />
                <meta property="og:image:type" content="image/png" />
                <meta property="og:image:width" content="200" />
                <meta property="og:image:height" content="200" />
                <meta property="og:description" content="' . $this->DESCRIPCION . '" />
                <meta name="twitter:title" content="' . $this->TITULO . '" />
                <meta name="twitter:image" content="' . Config::RUTA() . $this->IMAGEN . '" />
                <meta name="twitter:url" content="' . Config::RUTA() . '" />
                <meta name="twitter:card" content="' . $this->DESCRIPCION . '" />
                <link rel="manifest" href="' . Config::RUTA() . 'manifiesto/webmanifest.json' . self::v() . '">
                <link rel="icon" href="' . Config::RUTA() . $this->LOGO . '" type="image/x-icon"/>';

        $header .= $this->renderHeader();

        $header .= "</head>";
        echo $header;
    }

    public function summerNote($key)
    {
        $this->addStyle("https://maps.googleapis.com/maps/api/js?key=$key");
        $this->addScript("https://maps.googleapis.com/maps/api/js?key=$key");
    }
    public function GoogleAPI($key)
    {
        $this->addStyle("https://maps.googleapis.com/maps/api/js?key=$key");
        $this->addScript("https://maps.googleapis.com/maps/api/js?key=$key");
    }

    public function addScript($script, $type = 'text/javascript')
    {
        $this->headerScripts[] = ['src' => $script, 'type' => $type];
    }

    public function addStyle($style)
    {
        $this->headerStyles[] = $style;
    }

    public function renderHeader()
    {
        $render = "";
        foreach ($this->headerStyles as $style) {
            $render .= "<link rel='stylesheet' type='text/css' href='$style'>\n";
        }
        return $render;
    }
    public function renderScripts()
    {
        foreach ($this->headerScripts as $script) {
            echo "<script src='{$script['src']}' type='{$script['type']}'></script>\n";
        }
    }
}
