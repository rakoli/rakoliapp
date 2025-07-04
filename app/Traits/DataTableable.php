<?php

namespace App\Traits;

use App\Utils\DataTableColumn;
use App\Utils\DataTableBuilder;
use Yajra\DataTables\DataTables;

trait DataTableable
{
    /**
     * Create a DataTable builder instance
     */
    protected function createDataTableBuilder()
    {
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();

        return DataTableBuilder::make($builder);
    }

    /**
     * Get standard DataTable configuration
     */
    protected function getStandardDataTableConfig()
    {
        return [
            'responsive' => true,
            'ordering' => true,
            'searching' => true,
            'paging' => true,
            'dom' => 'frtilp',
            'lengthMenu' => [[25, 50, 100, -1], [25, 50, 100, "All"]],
        ];
    }

    /**
     * Create a standard actions column
     */
    protected function createActionsColumn($title = null)
    {
        return DataTableColumn::make('actions')
            ->title($title ?? __('Actions'))
            ->orderable(false)
            ->searchable(false)
            ->exportable(false)
            ->printable(false)
            ->centerAlign()
            ->width('120px');
    }

    /**
     * Create a standard ID column
     */
    protected function createIdColumn($title = null)
    {
        return DataTableColumn::make('id')
            ->title($title ?? __('ID'))
            ->width('60px')
            ->centerAlign()
            ->orderable();
    }

    /**
     * Create a standard name column
     */
    protected function createNameColumn($field = 'name', $title = null)
    {
        return DataTableColumn::make($field)
            ->title($title ?? __('Name'))
            ->searchable()
            ->orderable();
    }

    /**
     * Create a standard email column
     */
    protected function createEmailColumn($title = null)
    {
        return DataTableColumn::make('email')
            ->title($title ?? __('Email'))
            ->searchable()
            ->orderable();
    }

    /**
     * Create a standard phone column
     */
    protected function createPhoneColumn($title = null)
    {
        return DataTableColumn::make('phone')
            ->title($title ?? __('Phone'))
            ->searchable()
            ->nowrap()
            ->width('120px');
    }

    /**
     * Create a standard date column
     */
    protected function createDateColumn($field = 'created_at', $title = null)
    {
        return DataTableColumn::make($field)
            ->title($title ?? __('Date'))
            ->orderable()
            ->centerAlign()
            ->width('130px');
    }

    /**
     * Create a standard status column
     */
    protected function createStatusColumn($field = 'status', $title = null)
    {
        return DataTableColumn::make($field)
            ->title($title ?? __('Status'))
            ->orderable(false)
            ->centerAlign()
            ->width('100px');
    }

    /**
     * Create a standard amount/currency column
     */
    protected function createAmountColumn($field = 'amount', $title = null)
    {
        return DataTableColumn::make($field)
            ->title($title ?? __('Amount'))
            ->rightAlign()
            ->orderable()
            ->width('120px');
    }
}
