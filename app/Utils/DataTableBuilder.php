<?php

namespace App\Utils;

use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class DataTableBuilder
{
    protected $columns = [];
    protected $htmlBuilder;
    protected $options = [];

    public function __construct(Builder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
    }

    public static function make(Builder $htmlBuilder)
    {
        return new static($htmlBuilder);
    }

    public function addColumn(DataTableColumn $column)
    {
        $this->columns[] = $column;
        return $this;
    }

    public function columns(array $columns)
    {
        foreach ($columns as $column) {
            if ($column instanceof DataTableColumn) {
                $this->addColumn($column);
            } else {
                // For backwards compatibility with array-based columns
                $this->columns[] = $column;
            }
        }
        return $this;
    }

    public function responsive($responsive = true)
    {
        $this->options['responsive'] = $responsive;
        return $this;
    }

    public function ordering($ordering = true)
    {
        $this->options['ordering'] = $ordering;
        return $this;
    }

    public function ajax($url)
    {
        $this->options['ajax'] = $url;
        return $this;
    }

    public function paging($paging = true)
    {
        $this->options['paging'] = $paging;
        return $this;
    }

    public function dom($dom)
    {
        $this->options['dom'] = $dom;
        return $this;
    }

    public function lengthMenu($lengthMenu)
    {
        $this->options['lengthMenu'] = $lengthMenu;
        return $this;
    }

    public function searching($searching = true)
    {
        $this->options['searching'] = $searching;
        return $this;
    }

    public function build()
    {
        $columnsArray = [];
        foreach ($this->columns as $column) {
            if ($column instanceof DataTableColumn) {
                $columnsArray[] = $column->toArray();
            } else {
                $columnsArray[] = $column;
            }
        }

        $builder = $this->htmlBuilder->columns($columnsArray);

        foreach ($this->options as $method => $value) {
            if (method_exists($builder, $method)) {
                $builder = $builder->$method($value);
            }
        }

        return $builder;
    }
}
