<?php

namespace App\Utils\Traits;

trait InteractsWithSweetAlerts
{
    public function confirm($icon, $title, $html, $confirmButtonText, $successEvent, ?array $params, $cancelEvent)
    {
        return $this->dispatch('swal:confirm', ['icon' => $icon, 'title' => $title, 'html' => $html, 'confirmText' => $confirmButtonText, 'successEvent' => $successEvent, 'params' => $params, 'cancelEvent' => $cancelEvent]);
    }

    public function inputAlert(string $title, string $input, string $inputLabel, string $inputPlaceholder)
    {
        return $this->dispatch('swal:inputAlert', ['title' => $title, 'input' => $input, 'inputLabel' => $inputLabel, 'inputPlaceholder' => $inputPlaceholder]);
    }

    public function modal(string $icon, string $title, string $text)
    {
        return $this->dispatch('swal:modal', ['icon' => $icon, 'title' => $title, 'text' => $text]);
    }

    public function alert(string $title, string $icon = 'success', int $timeout = 5000)
    {
        return $this->dispatch('swal:alert', ['icon' => $icon, 'title' => $title, 'timeout' => $timeout]);
    }

    public function dismissModal(string $modalId)
    {
        return $this->dispatch('modal:dismiss', ['modalId' => $modalId]);
    }

    public function openModal(string $modalId)
    {
        return $this->dispatch('modal:open', ['modalId' => $modalId]);
    }

    public function refreshDataDatable(string $tableId)
    {
        return $this->dispatch('table:refresh', ['tableId' => $tableId]);
    }

    public function addDataToComponent($attribute, $value, $appendType = 'text')
    {
        return $this->dispatch('refresh:component_data', ['attribute_name' => $attribute, 'attribute_value' => $value, 'appendType' => $appendType]);
    }
}
