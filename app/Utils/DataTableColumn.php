<?php

namespace App\Utils;

class DataTableColumn
{
    protected $data;
    protected $title;
    protected $searchable = false;
    protected $orderable = false;
    protected $visible = true;
    protected $width = null;
    protected $className = null;
    protected $render = null;
    protected $exportable = true;
    protected $printable = true;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public static function make($data)
    {
        return new static($data);
    }

    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    public function searchable($searchable = true)
    {
        $this->searchable = $searchable;
        return $this;
    }

    public function orderable($orderable = true)
    {
        $this->orderable = $orderable;
        return $this;
    }

    public function visible($visible = true)
    {
        $this->visible = $visible;
        return $this;
    }

    public function width($width)
    {
        $this->width = $width;
        return $this;
    }

    public function className($className)
    {
        $this->className = $className;
        return $this;
    }

    public function render($callback)
    {
        $this->render = $callback;
        return $this;
    }

    public function exportable($exportable = true)
    {
        $this->exportable = $exportable;
        return $this;
    }

    public function printable($printable = true)
    {
        $this->printable = $printable;
        return $this;
    }

    public function centerAlign()
    {
        $this->className = 'text-center';
        return $this;
    }

    public function rightAlign()
    {
        $this->className = 'text-right';
        return $this;
    }

    public function leftAlign()
    {
        $this->className = 'text-left';
        return $this;
    }

    public function nowrap()
    {
        $this->className = ($this->className ? $this->className . ' ' : '') . 'text-nowrap';
        return $this;
    }

    public function toArray()
    {
        $column = [
            'data' => $this->data,
            'title' => $this->title,
            'searchable' => $this->searchable,
            'orderable' => $this->orderable,
            'visible' => $this->visible,
            'exportable' => $this->exportable,
            'printable' => $this->printable,
        ];

        if ($this->width !== null) {
            $column['width'] = $this->width;
        }

        if ($this->className !== null) {
            $column['className'] = $this->className;
        }

        if ($this->render !== null) {
            $column['render'] = $this->render;
        }

        return $column;
    }
}
