# Tweeter Clone


### Installation (first time)

1. Open in cmd or terminal app and navigate to project folder
2. Run following commands

    ```bash
    composer install
    cp .env.example .env
    ```

3. Set the database information in .env
   DB_DATABASE, DB_USERNAME, DB_PASSWORD

4. Set your email information in .env

5. Run following commands

    ```bash
    php artisan key:generate
    php artisan passport:install
    php artisan migrate --seed
    ```
6. Make a daily cron job for the following command

    ```bash
    php artisan delete:daily
    ```

### Auth
    Set API_URL in .env
#### Boss
- Email: `boss1@admin.com`
- Password: `admin_password`

### For the APIs, you can import the file (`wizkid.postman_collection.json`) to postman and test the APIs
