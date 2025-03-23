<?php

define("ENV", "local");

if (ENV === "local") {
    define("DB_HOST", "127.0.0.1");
    define("DB_NAME", "netiflix");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_CHARSET", "utf8mb4");
} else {
    define("DB_HOST", "127.0.0.1");
    define("DB_NAME", "netiflix");
    define("DB_USER", "server_user");
    define("DB_PASS", "server_password");
    define("DB_CHARSET", "utf8mb4");
}
