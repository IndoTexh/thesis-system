# Thesis System

This repository contains the **backend** for the Thesis System, which provides API endpoints, authentication, and core business logic for managing thesis-related workflows.

- **Frontend repository:** [Ithnoobs/thesis_sys_app](https://github.com/Ithnoobs/thesis_sys_app)

## Overview

The Thesis System is designed to help students, advisors, and administrators manage thesis submissions, approvals, and communication efficiently.

- **Backend:** PHP (Laravel)
- **API:** RESTful endpoints for thesis management, user authentication, and more
- **Frontend:** Developed in Dart (Flutter) — see the [thesis_sys_app](https://github.com/Ithnoobs/thesis_sys_app) repo

## Features

- [x] User registration & authentication
- [x] Thesis submission & tracking
- [ ] Advisor-student communication
- [ ] Status updates and notifications
- [ ] Admin panel for managing users and theses

## Setup

### Requirements

- PHP 8.x
- Composer
- MySQL or compatible database

### Installation

```bash
git clone https://github.com/IndoTexh/thesis-system.git
cd thesis-system
composer install
cp .env.example .env
# Edit .env for database and other settings
php artisan key:generate
php artisan migrate
php artisan storage:link   
php artisan serve
```

## API Usage

The backend exposes a REST API consumed by the [thesis_sys_app frontend](https://github.com/Ithnoobs/thesis_sys_app). See the `docs/` folder or the frontend repository for API usage examples.

## License

MIT

---
**See the [frontend app](https://github.com/Ithnoobs/thesis_sys_app) for the user interface and mobile client.**