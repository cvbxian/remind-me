# Remind Me
 
Description
Remind Me is a simple Laravel-based personal task and reminder
management system. It allows a user to add a specific task or job
for a given day, complete with a due date and time, so that nothing
gets forgotten. From the task list, a user can mark a task as done,
edit its details, or delete it once it is no longer needed. The
system is meant to help a user stay organized and keep track of
daily responsibilities in one place.
 
Christian Valenzuela Bohol, Loren Gersalia Monzales
BSIT 4-3
 
## Software Requirements
- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Git
 
## Installation
1. Clone the repository:
   git clone https://github.com/<username>/remind-me.git
2. Install dependencies:
   composer install
3. Copy the environment file:
   cp .env.example .env
4. Generate the application key:
   php artisan key:generate
 
## Database
- Database name: remind_me_db
- Create the database in MySQL, then set DB_* values in your .env
- Run migrations to build the schema:
   php artisan migrate
 
## Running the Project
   php artisan serve
Then open http://127.0.0.1:8000 in your browser.
