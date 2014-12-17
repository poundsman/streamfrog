# StreamFrog

## Prerequisites

- a MySQL database
- Composer
- a Twitter application and it's various keys
- a Twitch API key

## Installation

Clone the repository to your webserver and switch into the new directory.

First go ahead and rename `env.php` to `.env.php` and fill in the file
with your keys and database login.

Now run ``composer install`` followed by ``php artisan migrate``. Done.

