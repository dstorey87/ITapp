# Problem Tracker

## Issue 1: Database Connection Error (mysqli_sql_exception: No such file or directory)
- **Date:** Sept 29, 2024
- **Description:** PHP application couldn't connect to MariaDB, error: "mysqli_sql_exception: No such file or directory".
- **Cause:** The `db.php` file was using `localhost` as the hostname for the database connection, but the MariaDB service is in a separate Docker container.
- **Solution:** Updated `db.php` to use the Docker service name `db` as the hostname.
- **File Affected:** `db.php`
- **Resolution:**
  - Changed `$servername = "localhost"` to `$servername = "db"`.
  - Restarted the Docker stack with `docker compose down` and `docker compose up`.

---

## Issue 2: [Add any future issues here]

