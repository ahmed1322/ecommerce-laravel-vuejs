<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>LMS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- App css -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
        @yield('style')
    </head>
