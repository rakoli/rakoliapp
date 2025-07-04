<?php

namespace Tests\Unit\Utils;

use Tests\TestCase;
use App\Utils\DataTableColumn;
use App\Utils\DataTableBuilder;
use Yajra\DataTables\Html\Builder;

class DataTableTest extends TestCase
{
    public function test_data_table_column_creation()
    {
        $column = DataTableColumn::make('name')
            ->title('Name')
            ->searchable()
            ->orderable()
            ->width('150px')
            ->centerAlign();

        $array = $column->toArray();

        $this->assertEquals('name', $array['data']);
        $this->assertEquals('Name', $array['title']);
        $this->assertTrue($array['searchable']);
        $this->assertTrue($array['orderable']);
        $this->assertEquals('150px', $array['width']);
        $this->assertEquals('text-center', $array['className']);
    }

    public function test_data_table_column_defaults()
    {
        $column = DataTableColumn::make('test');
        $array = $column->toArray();

        $this->assertEquals('test', $array['data']);
        $this->assertFalse($array['searchable']);
        $this->assertFalse($array['orderable']);
        $this->assertTrue($array['visible']);
        $this->assertTrue($array['exportable']);
        $this->assertTrue($array['printable']);
    }

    public function test_data_table_column_alignment_helpers()
    {
        $leftColumn = DataTableColumn::make('left')->leftAlign();
        $centerColumn = DataTableColumn::make('center')->centerAlign();
        $rightColumn = DataTableColumn::make('right')->rightAlign();

        $this->assertEquals('text-left', $leftColumn->toArray()['className']);
        $this->assertEquals('text-center', $centerColumn->toArray()['className']);
        $this->assertEquals('text-right', $rightColumn->toArray()['className']);
    }

    public function test_data_table_column_nowrap()
    {
        $column = DataTableColumn::make('test')
            ->centerAlign()
            ->nowrap();

        $this->assertEquals('text-center text-nowrap', $column->toArray()['className']);
    }

    public function test_data_table_column_export_print_settings()
    {
        $column = DataTableColumn::make('actions')
            ->exportable(false)
            ->printable(false);

        $array = $column->toArray();
        $this->assertFalse($array['exportable']);
        $this->assertFalse($array['printable']);
    }
}
