# Invoice App

This is a simple Laravel-based Invoice Management System that supports full **CRUD operations** and **email notification** features. It allows users to create, update, view, and delete invoices and automatically sends an invoice email upon creation.

---

##  Features

- Create, Read, Update, Delete (CRUD) invoices
- Add multiple invoice items (products) per invoice
- Automatically calculate subtotal, tax, and grand total
- Send invoice summary as email to the customer using Mailtrap SMTP
- routes and clean UI using Blade templating
- Validation and error handling

---

##  Technologies Used

- **Laravel Framework Current version**
- **Blade Templating Engine**
- **Mailtrap** for email testing
- **Bootstrap** for UI styling
- **MySQL** for database

---

## 📂 Installation Steps

1. **Clone the repository:**


git clone https://github.com/sasikumarsd/invoice-app.git
cd invoice-app

2. **Install dependencies**

composer install

3. **Create .env file:**

cp .env.example .env

4. **Configure database:**

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invoice_app
DB_USERNAME=root
DB_PASSWORD=

5. **Configure Mailtrap SMTP (for testing email):**

(I have used test mailtrap account to send the email notification, you can update the smtp credentials)

MAIL_MAILER=smtp
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=api
MAIL_PASSWORD=b3be9613030ec74cf5eba56ad54772fb
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hi@demomailtrap.co
MAIL_FROM_NAME="Invoice App"

6. **Run migrations:**

php artisan migrate


7. **Run the application:**

php artisan serve


Visit: http://127.0.0.1:8000



Email Notification
Once an invoice is created, an email is automatically sent to the customer's email using the configured Mailtrap SMTP account.

Trigger Email
Emails are sent from this controller action:


Mail::to($invoice->customer_email)->send(new InvoiceGeneratedMail($invoice, $totalTaxamount));

The mail template includes:

Invoice number

List of items

Subtotal

Tax

Grand total

Project Structure
app/Models/Invoice.php — Invoice model

app/Models/InvoiceItem.php — Invoice items (linked to invoices)

app/Mail/InvoiceGeneratedMail.php — Mailable class for invoice emails

app/Http/Controllers/InvoiceController.php — Controller for invoice logic

resources/views/invoices/ — Blade views for invoice CRUD

routes/web.php — Web routes


