<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PhoneBook</title>
    </head>
    <body class="antialiased">
        <h1>Simple PhoneBook api</h1>
        <ul>
            <li>GET /api/v1/contacts</li>
            <li>GET /api/v1/contacts/{id}</li>
            <li>POST /api/v1/contacts</li>
            <li>PUT /api/v1/contacts/{id}</li>
            <li>DELETE /api/v1/contacts/{id}</li>
        </ul>
    </body>
</html>
