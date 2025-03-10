<?php


namespace App\Template\PublicKit;

class Footer
{
    private $content;

    public function __construct()
    {
        $this->content = '';
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function render()
    {
        return '<footer class="footer">' . $this->content . '</footer>';
    }

    public function __toString()
    {
        return $this->render();
    }
}
