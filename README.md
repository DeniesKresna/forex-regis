# MT License Manager

Laravel + Tailwind + MySQL application for managing MetaTrader EA subscriptions.

## Requirements

Only Docker with Docker Compose is required.

## Start

```bash
docker compose up -d
```

Open http://localhost:8080

Code changes are reflected immediately because the project source is bind-mounted into the app container. Rebuild only when you change dependencies or the Docker image itself.

To run on server port 80, set `APP_PORT=80` in `.env` and change `APP_URL` to your domain or server IP, then run `docker compose up -d`.

Default admin:

- Email: `admin@example.com`
- Password: `admin12345`

Change the password after first login.

## Stop

```bash
docker compose down
```

## Reset database

This removes all application data including MySQL volume:

```bash
docker compose down -v
docker compose up -d
```

## EA API

```text
GET /api/metatrader/check?server_name=YOUR_SERVER&account_number=YOUR_ACCOUNT
```

Active response:

```json
{
  "success": true,
  "active": true,
  "expired_date": "2026-10-20"
}
```

Unknown account returns HTTP 404.

## Payment rule

Default configuration:

```json
{
  "10000": 3,
  "50000": 30
}
```

A payment must exactly match a configured amount. If the MT account is active, the duration is added to its current expiry. If it is expired or has no expiry, duration is added from today.

Payment records store the resolved duration and before/after expiry snapshots.
