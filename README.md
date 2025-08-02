# AdminLTE PHP Admin Panel

## Folder Structure

```
/myadminlte/
├── dist/               # AdminLTE CSS/JS assets
├── plugins/            # Plugin assets
├── pages/              # Custom content pages
│   ├── users.php
│   ├── providers.php
│   ├── services.php
│   ├── categories.php
│   └── bookings.php
├── includes/
│   ├── header.php
│   ├── sidebar.php
│   ├── footer.php
│   └── db.php
├── index.php           # Dashboard
└── login.php           # Admin login
```

## Setup Instructions

1. **Install PHP & MySQL**
   - Make sure your server (e.g., Apache, Nginx) has PHP and MySQL installed.

2. **Database**
   - Create a database named `myapp`.
   - Create the following tables:
     - `users` (id, name, email, phone, password, role, status)
     - `services` (id, name, description, category_id, price, status)
     - `categories` (id, name, description)
     - `bookings` (id, user_id, service_id, date, status)
     - `provider_profiles` (user_id, profile_info)
   - Insert at least one admin user. Passwords should be hashed with `password_hash()`.

3. **Assets**
   - Download AdminLTE assets and place them in `dist/` and `plugins/` as needed.
   - You can get AdminLTE from [https://adminlte.io/](https://adminlte.io/)

4. **Run the App**
   - Place the project in your web root (e.g., `/var/www/html/myadminlte`).
   - Access via `http://localhost/myadminlte/login.php` to log in as admin.

5. **Security**
   - Change default DB credentials in `includes/db.php`.
   - Use HTTPS in production.
   - Always hash passwords and validate user input.

## Best Practices & Improvements
- Use prepared statements for all SQL queries (already done for login).
- Restrict access to pages for non-logged-in users (add session checks in each page).
- Sanitize all output to prevent XSS.
- Add CSRF protection for forms.
- For production, move config (DB credentials) outside web root.

---

If you need help with database SQL or want sample data, let me know!
