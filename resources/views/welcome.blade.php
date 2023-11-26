<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact API Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        code {
            background-color: #f4f4f4;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body>

<h1>Contact API Documentation</h1>

<h2>Endpoints</h2>

<h3>1. Get all Contacts</h3>
<code>GET /api/v1/contacts</code>
<pre>
curl http://localhost/api/v1/contacts
</pre>

<h3>2. Get a Contact by ID</h3>
<code>GET /api/v1/contacts/{id}</code>
<pre>
curl http://localhost/api/v1/contacts/{id}
</pre>

<h3>3. Find Contact by Phone Number</h3>
<code>GET /api/v1/contacts/find/{phoneNumber}</code>
<pre>
curl http://localhost/api/v1/contacts/find/{phoneNumber}
</pre>

<h3>4. Create a new Contact</h3>
<code>POST /api/v1/contacts</code>
<pre>
curl -X POST -H "Content-Type: application/json" -d '{
    "first_name": "John",
    "last_name": "Doe",
    "phone_numbers": ["(555) 555-5555"]
}' http://localhost/api/v1/contacts
</pre>

<h3>5. Update a Contact by ID</h3>
<code>PUT /api/v1/contacts/{id}</code>
<pre>
curl -X PUT -H "Content-Type: application/json" -d '{
    "first_name": "UpdatedFirstName",
    "last_name": "UpdatedLastName",
    "phone_numbers": ["(555) 555-5555", "(555) 555-5556"]
}' http://localhost/api/v1/contacts/{id}
</pre>

<h3>6. Delete a Contact by ID</h3>
<code>DELETE /api/v1/contacts/{id}</code>
<pre>
curl -X DELETE http://localhost/api/v1/contacts/{id}
</pre>

<h2>Notes</h2>

<ul>
    <li>Replace <code>{id}</code> and <code>{phoneNumber}</code> with the actual ID and phone number values.</li>
    <li>Ensure to include the appropriate headers for POST and PUT requests (e.g., <code>Content-Type: application/json</code>).</li>
    <li>The <code>phone_numbers</code> field is an array of phone numbers. You can add as many phone numbers as you want but each phone number must be unique.</li>
    <li>Phone can be in any format and will be stored in the database in two formats: one as is and the other with only numbers for searching.  (e.g., <code>+420 123 456 789</code> will be also stored as <code>+420123456789</code>).</li>
</ul>

</body>
</html>
