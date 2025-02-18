<?php
class Template
{
    private $headerScripts = [];
    private $headerStyles  = [];

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
        foreach ($this->headerStyles as $style) {
            echo "<link rel='stylesheet' type='text/css' href='$style'>\n";
        }
    }
    public function renderScripts()
    {
        foreach ($this->headerScripts as $script) {
            echo "<script src='{$script['src']}' type='{$script['type']}'></script>\n";
        }
    }
}
