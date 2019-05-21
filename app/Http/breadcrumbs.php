<?php
foreach (File::allFiles(__DIR__ . '/Breadcrumbs') as $partial)
    require_once $partial->getPathName();