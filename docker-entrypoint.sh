#!/bin/bash
set -e

# Create an environment debug file to help troubleshooting
echo "===== Environment Variables Diagnostic =====" > /var/log/env-debug.log
echo "Date: $(date)" >> /var/log/env-debug.log
echo "" >> /var/log/env-debug.log
echo "Environment variables:" >> /var/log/env-debug.log
env | grep -E "DB_|SHOW_ERRORS" >> /var/log/env-debug.log
echo "" >> /var/log/env-debug.log

# Make sure logs directory is writable
mkdir -p /var/www/html/logs
chown -R www-data:www-data /var/www/html/logs
chmod -R 755 /var/www/html/logs

# Create a test file to ensure PHP can write to the logs directory
echo "<?php echo 'Log test at " $(date) "'; ?>" | php >> /var/www/html/logs/startup-test.log

# Create an index.php file in the logs directory that redirects to home for security
cat > /var/www/html/logs/index.php << 'EOF'
<?php
header('Location: /');
exit;
EOF

# Check if database is reachable
echo "Checking database connection..." >> /var/log/env-debug.log
php -r "
\$host = getenv('DB_HOST') ?: 'db';
\$db = getenv('DB_NAME') ?: 'videgrenierenligne';
\$user = getenv('DB_USER') ?: 'root';
\$pass = getenv('DB_PASSWORD') ?: '653rag9T';

echo \"Trying to connect to \$host/\$db as \$user...\n\";

try {
    \$dbh = new PDO(\"mysql:host=\$host;dbname=\$db\", \$user, \$pass);
    echo \"Database connection successful!\n\";
} catch (PDOException \$e) {
    echo \"Error: \" . \$e->getMessage() . \"\n\";
}
" >> /var/log/env-debug.log

# Create a PHP info file for debugging
cat > /var/www/html/public/phpinfo.php << 'EOF'
<?php
// Only enable in development environments
if (getenv('SHOW_ERRORS') == 'true') {
    phpinfo();
} else {
    header('Location: /');
    exit;
}
EOF

# Set proper permissions for the debug file
chmod 644 /var/www/html/public/phpinfo.php

# Execute the main command
exec "$@"