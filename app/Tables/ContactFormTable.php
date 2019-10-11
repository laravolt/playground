<?php

declare(strict_types=1);

namespace App\Tables;

use Laravolt\Suitable\Columns\Date;
use Laravolt\Suitable\Columns\Id;
use Laravolt\Suitable\Columns\Text;
use Laravolt\Suitable\TableView;

class ContactFormTable extends TableView
{
    protected function columns()
    {
        return [
            Id::make(),
            Text::make('name')->sortable()->searchable(),
            Text::make('email')->sortable()->searchable(),
            Text::make('category')->sortable()->searchable(),
            Text::make('message')->sortable()->searchable(),
            Date::make('created_at'),
        ];
    }
}
