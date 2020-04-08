
1. Clone the repo to your computer

git clone https://github.com/EduardCherkashyn/MusicSchool.git


2. Run composer install to install required dependencies

composer install


3.Adjust .env line 16 


4. Create a schema in your database

php bin/console doctrine:database:create


5. Create tables in your schema

php bin/console doctrine:migrations:migrate


6. Load fixtures to your database

php bin/console doctrine:fixtures:load


7.Start server

php bin/console server:run 0.0.0.0:8000

# Backup
docker exec music_school_mysql /usr/bin/mysqldump -u root --password=123123 company_site > backup.sql

# Restore
cat backup.sql | docker exec -i music_school_mysql /usr/bin/mysql -u root --password=123123 company_site
