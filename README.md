# PhoneBook API Documentation

##### Ahoj Martine, kdyby cokoliv nebylo jasne, tak se neboj napsat

## Important files and directories

### 1. Controllers directory

- `app/Http/Controllers/ContactsController.php`

### 2. Routes directory
- `routes/api.php`

### 3. Models directory
- `app/Models/Contact.php`

### 4. Migrations directory
- `database/migrations

### 5. Seeders and directory
- `database/seeders/ContactsSeeder.php`
- `database/factories/ContactFactory.php`

### 6. Tests directory
- `tests/Tests/Feature



## Instalation and Setup

### 1. Clone the repository

```bash
git clone github.com/dnitra/phonebook
```

### 2. Boot up the Docker containers with Sail helper tool

```bash
alias sail='bash vendor/bin/sail'
sail up -d
```
### 3. Install dependencies

```bash
sail composer install
sail npm install
```

### 4. Generate application key

```bash
sail artisan key:generate
```

### 5. Create `.env` file

```bash
cp .env.example .env
```

### 6. Run database migrations and seeders

```bash
sail artisan migrate --seed
```

### 7. Run tests

```bash
sail artisan test
```

## Endpoints

### 1. Get all Contacts

`GET /api/v1/contacts`

```bash
curl http://localhost/api/v1/contacts
```

### 2. Get a Contact by ID

`GET /api/v1/contacts/{id}`

```bash
curl http://localhost/api/v1/contacts/{id}
```

### 3. Find Contact by Phone Number

`GET /api/v1/contacts/find/{phoneNumber}`

```bash
curl http://localhost/api/v1/contacts/find/{phoneNumber}
```

### 4. Create a new Contact

`POST /api/v1/contacts`

```bash
curl -X POST -H "Content-Type: application/json" -d '{
    "first_name": "John",
    "last_name": "Doe",
    "phone_numbers": ["+420 123 456 789", "+420 987 654 321"]
}' http://localhost/api/v1/contacts
```

### 5. Update a Contact by ID

`PUT /api/v1/contacts/{id}`

```bash
curl -X PUT -H "Content-Type: application/json" -d '{
    "first_name": "UpdatedFirstName",
    "last_name": "UpdatedLastName",
    "phone_numbers": ["+420 777 777 777"]
}' http://localhost/api/v1/contacts/{id}
```

### 6. Delete a Contact by ID

`DELETE /api/v1/contacts/{id}`

```bash
curl -X DELETE http://localhost/api/v1/contacts/{id}
```

## Notes

- Replace `{id}` and `{phoneNumber}` with the actual ID and phone number values.
- Ensure to include the appropriate headers for POST and PUT requests (e.g., `Content-Type: application/json`).
- The `phone_numbers` field is an array of phone numbers. You can add as many phone numbers as you want, but each phone number must be unique.
- Phone numbers can be in any format and will be stored in the database in two formats: one as is and the other with only numbers for searching. (e.g., `+420 123 456 789
