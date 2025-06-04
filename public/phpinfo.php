<?php
// Only enable in development environments
if (getenv('SHOW_ERRORS') == 'true') {
    phpinfo();
} else {
    header('Location: /');
    exit;
}
