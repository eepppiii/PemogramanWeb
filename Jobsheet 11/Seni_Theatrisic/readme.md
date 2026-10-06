# Jobsheet-11: Keamanan Web (Security)

Project ini merupakan implementasi dari Jobsheet-11 yang berfokus pada pengamanan aplikasi web.

## Fitur Keamanan yang Diimplementasikan:
1. **XSS Prevention**: Menggunakan fungsi `e()` (htmlspecialchars) pada setiap output data ke HTML.
2. **CSRF Protection**: Menggunakan token CSRF pada setiap form dan memverifikasinya di sisi server.
3. **Session Fixation Prevention**: Menggunakan `session_regenerate_id(true)` setelah login berhasil.
4. **SQL Injection Prevention**: Menggunakan PDO Prepared Statements untuk semua query database.