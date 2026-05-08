# Kaylia Admin Interface

Vue.js 3 admin interface for Kaylia Suite Home backend system.

## Features

- Vue 3 with Composition API
- Vue Router for navigation with protected routes
- Pinia for state management
- Axios for API calls with automatic token handling
- Tailwind CSS for styling
- Role-based access control (super_admin, admin, editor)

## Prerequisites

- Node.js 18+ and npm
- Backend API running on http://localhost:8000

## Installation

```bash
npm install
```

## Configuration

Copy `.env.example` to `.env` and configure:

```
VITE_API_BASE_URL=http://localhost:8000/api
```

## Development

Start the development server:

```bash
npm run dev
```

The admin interface will be available at http://localhost:5173

## Build

Build for production:

```bash
npm run build
```

The built files will be in the `dist` directory.

## Project Structure

```
admin/
├── src/
│   ├── api/           # API client configuration
│   ├── components/    # Reusable components
│   ├── layouts/       # Layout components
│   ├── router/        # Vue Router configuration
│   ├── stores/        # Pinia stores
│   ├── views/         # Page components
│   ├── App.vue        # Root component
│   ├── main.js        # Application entry point
│   └── style.css      # Global styles
├── public/            # Static assets
├── .env               # Environment variables
└── package.json       # Dependencies
```

## Authentication

The admin interface uses JWT tokens for authentication:

- Tokens are stored in localStorage
- Tokens are automatically added to all API requests
- Token refresh is handled automatically on 401 responses
- Users are redirected to login on authentication failure

## Default Credentials

Use the credentials from the backend seeder:

- Email: admin@kaylia.com
- Password: password

## Routes

- `/login` - Login page
- `/` - Dashboard
- `/apartments` - Apartment management
- `/reservations` - Reservation management
- `/customers` - Customer management
- `/spa/services` - SPA services management
- `/spa/reservations` - SPA reservations management
- `/reviews` - Review management
- `/promo-codes` - Promo code management (admin only)
- `/contact-messages` - Contact messages
- `/newsletter` - Newsletter management
- `/content` - Content management (admin/editor)
- `/settings` - Site settings (admin only)
- `/users` - Admin user management (super_admin only)
- `/activity-logs` - Activity logs (admin only)

## Role-Based Access

- **super_admin**: Full access to all features
- **admin**: Access to all features except user management
- **editor**: Content editing and read-only access to other features
