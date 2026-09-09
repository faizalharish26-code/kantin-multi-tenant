<?php

use App\Modules\Admin\Providers\AdminServiceProvider;
use App\Modules\Catalog\Providers\CatalogServiceProvider;
use App\Modules\Kitchen\Providers\KitchenServiceProvider;
use App\Modules\Ordering\Providers\OrderingServiceProvider;
use App\Modules\Payments\Providers\PaymentsServiceProvider;
use App\Modules\Reporting\Providers\ReportingServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\FortifyServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    FortifyServiceProvider::class,
    AdminServiceProvider::class,
    CatalogServiceProvider::class,
    KitchenServiceProvider::class,
    OrderingServiceProvider::class,
    PaymentsServiceProvider::class,
    ReportingServiceProvider::class,
];
