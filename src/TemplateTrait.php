<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Trait TemplateTrait
 * @package Attogram\Body
 */
trait TemplateTrait
{
    /** @var string */
    private $templatesDirectory = '../templates/';

    /** @var array */
    private $data = [];

    /**
     * @param string $name
     */
    public function includeTemplate(string $name)
    {
        $template = $this->templatesDirectory . $name . '.php';
        if (!is_readable($template)) {
            return;
        }
        /** @noinspection PhpIncludeInspection */
        include $template;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function getData($value)
    {
        if (isset($this->data[$value])) {
            return $this->data[$value];
        }
        return '?';
    }
}
