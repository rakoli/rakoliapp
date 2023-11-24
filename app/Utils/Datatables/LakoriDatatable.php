<?php

namespace App\Utils\Datatables;

trait LakoriDatatable
{


    protected function buttons($actions)
    {
        ob_start();
        ?>

        <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
           data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            Actions
            <i class="ki-outline ki-down fs-5 ms-1"></i>
        </a>
        <!--begin::Menu-->
        <div
            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
            data-kt-menu="true">

            <?php
            foreach ($actions as $name => $route) {


                ?>
                <div class="menu-item px-3">

                    <a class="menu-link px-3" href="<?= $route ?>"><?= $name ?></a>
                </div>
                <?php
            }
            ?>

            <!--end::Menu item-->
        </div>
        <!--end::Menu-->


        <?php
        return ob_get_clean();
    }


    private function active()
    {
        ob_start();
        ?>
        <span class='badge badge-success'>Active</span>
        <?php
        return ob_get_clean();

    }

    private function notActive()
    {
        ob_start();
        ?>
        <span class='badge badge-warning' style="background-color: #F96E46; color: #fff3cd">Not Active</span>
        <?php
        return ob_get_clean();

    }


}
