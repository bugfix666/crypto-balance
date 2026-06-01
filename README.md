
# ₿ Crypto Balance

[![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?logo=php&logoColor=white)](#)
[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)](#)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-18-4169E1?logo=postgresql&logoColor=white)](#)
[![Redis](https://img.shields.io/badge/Redis-Queue-red?logo=redis&logoColor=white)](#)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&logoColor=white)](#)
[![License](https://img.shields.io/badge/License-GPL--3.0-blue.svg)]()
[![CI](https://github.com/bugfix666/crypto-balance/actions/workflows/ci.yml/badge.svg)](https://github.com/bugfix666/crypto-balance/actions/workflows/ci.yml)

Lightweight cryptocurrency wallet and balance management service built with Laravel.

REST API • CLI tools • PostgreSQL • Redis queues • OpenAPI • Docker


---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Architecture](#architecture)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
- [Docker Services](#docker-services)
- [Database](#database)
- [API](#api)
- [Swagger / OpenAPI](#swagger--openapi)
- [CLI Commands](#cli-commands)
- [Queues and Background Processing](#queues-and-background-processing)
- [Testing](#testing)
- [Code Quality](#code-quality)
- [Makefile Commands](#makefile-commands)
- [Design Decisions](#design-decisions)
- [License](#license)

---

## Overview

**Crypto Balance** is a Laravel-based wallet and cryptocurrency balance management system.

The project provides a minimal but production-oriented architecture for managing wallet balances and recording every financial operation as an immutable transaction entry.

Key capabilities include:

- Wallet balance deposits and withdrawals
- Persistent operation history
- Queue-based processing
- REST API and Artisan CLI interfaces
- PostgreSQL persistence
- OpenAPI/Swagger integration
- Functional test coverage
- Dockerized local development

The project delegates core wallet logic to the external package:

```text
bugfix666/crypto-balance-wallet
```

---

## Features

### Wallet Management

- UUID-based wallet identification
- Precision-aware balance calculations
- Deposit operations
- Withdrawal operations
- Balance validation
- Protection against insufficient funds

### Transaction Lifecycle

Every balance change creates an operation record.

Supported operation types:

| Type | Description |
|---|---|
| Credit | Balance increase |
| Debit | Balance decrease |

Supported states:

| State | Meaning |
|---|---|
| `OS_INPROCESS` | Operation created |
| `OS_HOLD` | Awaiting confirmation |
| `OS_COMPLETE` | Successfully finalized |

Operations may be:

- processed immediately
- held temporarily
- finalized asynchronously through Redis queues

---

## Architecture

The project follows standard Laravel application layering.

### HTTP Layer

| Component | Responsibility |
|---|---|
| `WalletController` | Deposit and withdrawal API |
| `UserController` | User and wallet listing |
| `OperationController` | Transaction history |

### Validation Layer

| Request | Purpose |
|---|---|
| `ChangeBalanceRequest` | Wallet UUID + amount validation |
| `FindOperationsRequest` | User UUID validation |

Validation covers:

- UUID format
- numeric values
- min/max constraints
- malformed request protection

### API Resources

| Resource | Responsibility |
|---|---|
| `UserResource` | User representation |
| `WalletResource` | Wallet formatting |
| `OperationResource` | Transaction formatting |

### Queue Processing

The project includes asynchronous completion logic through:

```text
BalanceProcessCallbackJob
```

This job finalizes and confirms queued balance operations.

---

## Technology Stack

| Technology | Purpose |
|---|---|
| PHP 8.4+ | Runtime |
| Laravel 12 | Framework |
| PostgreSQL 18 | Database |
| Redis | Queues + cache |
| Docker | Development |
| Swagger/OpenAPI | API specification |
| PHPUnit | Functional testing |

---

## Project Structure

```text
app/
├── Console/
│   └── Commands/
├── Http/
│   ├── Controllers/Api/V1/
│   ├── Requests/
│   └── Resources/
├── Models/

database/
├── factories/
├── migrations/
└── seeders/

routes/
├── api.php
└── web.php

tests/
└── Feature/
```

---

## Getting Started

### Requirements

Install:

- Docker
- Docker Compose
- Make
- Git

No local PHP setup is required.

---

### Installation

Clone the repository:

```bash
git clone <repository-url>
cd crypto-balance
```

Start the environment:

```bash
make up
```

This command performs:

1. Docker image build
2. Container startup
3. `.env` creation
4. Composer install
5. Laravel key generation
6. Database migration
7. Seeder execution

---

## Docker Services

The development environment launches:

### Application Container

- PHP 8.4 runtime
- Laravel app
- Composer
- Artisan

### PostgreSQL

Default configuration:

```env
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=database
DB_USERNAME=user
DB_PASSWORD=password
```

### Redis

Used for:

- queues
- background jobs
- temporary cache

---

## Database

PostgreSQL is used as the primary datastore.

A separate test database is provisioned:

```text
database-test
```

Seeders generate:

- 10 demo users
- BTC wallets
- randomized balances
- precision configuration

---

## API

Base URL:

```text
http://localhost/api/v1
```

### Available Endpoints

| Method | Endpoint | Description |
|---|---|---|
| GET | `/users` | List users |
| POST | `/operations` | User operation history |
| POST | `/wallet/add-balance` | Deposit |
| POST | `/wallet/sub-balance` | Withdraw |

### Example Requests

#### Deposit Funds

```http
POST /wallet/add-balance
```

```json
{
  "wallet_uuid": "uuid",
  "amount": 100.00
}
```

#### Withdraw Funds

```http
POST /wallet/sub-balance
```

```json
{
  "wallet_uuid": "uuid",
  "amount": 50.00
}
```

---

## Swagger / OpenAPI

Swagger annotations are integrated into controllers.

Generate documentation:

```bash
make openapi
```

Output:

```text
storage/api-docs/api-docs.json
```

### Swagger UI / Screenshots

Add screenshots to:

```text
docs/images/
```

Example:

```markdown
![Swagger UI](docs/images/swagger-ui.png)
```

Recommended screenshots:

- Swagger UI
- API endpoint examples
- Docker container status
- CLI command output

Example placeholder:

```markdown
![Swagger Preview](docs/images/swagger-preview.png)
```

---

## CLI Commands

Wallet operations are available through Artisan.

### List Wallets

```bash
php artisan wallet:list
```

### Deposit

```bash
php artisan wallet:deposit <amount> <wallet_uuid>
```

Example:

```bash
php artisan wallet:deposit 1 85949663-786f-30c5-97e5-2193867f2c32
```

### Withdraw

```bash
php artisan wallet:withdraw <amount> <wallet_uuid>
```

### Operation History

```bash
php artisan wallet:operations <user_uuid>
```

Displays:

- UUID
- operation type
- amount
- currency
- timestamp

### Important Implementation Note

Deposit and withdrawal commands intentionally execute **100 iterations**.

This is currently used for:

- queue demonstration
- stress testing
- batch processing validation

Example:

```text
deposit 1
```

Produces:

```text
1 × 100 = 100
```

effective balance increase.

---

## Queues and Background Processing

Redis-backed queues handle asynchronous operation completion.

Manual worker start:

```bash
php artisan queue:listen
```

Queue pipeline:

```text
Balance Request
        ↓
Operation Created
        ↓
Redis Queue
        ↓
BalanceProcessCallbackJob
        ↓
Operation Complete
```

---

## Testing

The repository includes functional tests.

Run:

```bash
make test
```

or:

```bash
composer tests
```

Covered cases:

- deposits
- withdrawals
- hold operations
- completion logic
- cancellation
- insufficient funds
- balance verification

Testing uses:

```php
RefreshDatabase
```

for isolation.

---

## Code Quality

### PHPStan

```bash
make phpstan
```

### Psalm

```bash
make psalm
```

### Code Style

```bash
make cs-check
```

### Linting

```bash
make lint
```

---

## Makefile Commands

| Command | Description |
|---|---|
| `make up` | Full setup |
| `make start` | Start containers |
| `make stop` | Stop containers |
| `make restart` | Restart environment |
| `make migrate` | Fresh DB + seed |
| `make test` | Run tests |
| `make openapi` | Generate Swagger |
| `make route` | Rebuild routes |

---

## Design Decisions

### UUID Identity

Users and wallets are identified through UUIDs rather than incremental IDs.

### Precision Handling

Balances use:

- BCMath
- precision repositories
- formatting abstractions

This avoids floating-point inaccuracies.

### Thin Controllers

Controllers remain transport-focused while business logic is delegated to service and repository layers.

This separation improves:

- maintainability
- testability
- domain isolation

---

## License

Licensed under **GPL-3.0-only**.
