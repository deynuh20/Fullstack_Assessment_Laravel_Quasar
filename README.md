Technical Assessment – Product Management App

This is a **full-stack Product Management system** built with:

- **Backend**: Laravel (API + PostgreSQL)
- **Frontend**: Quasar Framework (Vue 3 + Pinia + Axios)

It demonstrates:
- CRUD operations on Products
- Self-referencing products (parent → child hierarchy)
- Frontend/Backend integration with REST API
- Authentication-ready via Laravel Passport

---

## Features

- Add, Edit, Delete Products
- Assign products as **children of other products**
- Display products
- API-first backend (Laravel) with CORS support
- Quasar frontend with **QTable** integration and Pinia store

---

## 🛠️ Installation

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/technical_assessment.git
cd technical_assessment

### 2. Backend (Laravel)
cd backend
composer install
cp .env.example .env
php artisan key:generate

Configure .env

Update with your PostgreSQL credentials:

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=products_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Allow frontend access
CORS_ALLOWED_ORIGINS=http://localhost:9000

Run Migrations
php artisan migrate

Start the Backend Server
php artisan serve


Backend API will be available at:
👉 http://127.0.0.1:8000/api/products

3. Frontend (Quasar Vue)
cd frontend
npm install

Configure API URL

Create a .env file in frontend/:

VITE_API_URL=http://127.0.0.1:8000/api


The app uses axios to connect to this URL.

Run the Frontend
quasar dev


Frontend will run at:
👉 http://localhost:9000
