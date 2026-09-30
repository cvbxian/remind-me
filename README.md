# Remind Me

## Description
Remind Me is a simple Laravel-based personal task and reminder management
system. It allows a user to add a specific task or job for a given day,
complete with a due date and time, so that nothing gets forgotten. From the
task list, a user can mark a task as done, edit its details, or delete it
once it is no longer needed. The system is meant to help a user stay
organized and keep track of daily responsibilities in one place.

## Student Information
- Names: Christian Valenzuela Bohol, Loren Gersalia Monzales
- Course, Year & Section: BSIT 4-3

## Software Requirements
- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Git

## Installation
1. Clone the repository:
   git clone https://github.com/cvbxian/remind-me.git
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

## Repository Link
https://github.com/cvbxian/remind-me

---

## Request Data Model (Laboratory 2)

### requests Table Fields
- id (PK, auto-increment)
- requester_name (string, 100)
- requester_email (string, 255)
- item_name (string, 150)
- quantity (unsigned integer, must be > 0)
- purpose (text)
- status (string, 20, default: pending)
- created_at / updated_at (timestamps)

### Migration Command
   php artisan make:migration create_requests_table
   php artisan migrate

### Verifying the Table
1. php artisan migrate:status  (confirm it is marked Ran)
2. Open phpMyAdmin > remind_me_db > requests > Structure tab
3. Run: SELECT id, requester_name, item_name, quantity, status FROM requests;
4. Confirm a row with an omitted status shows the default 'pending'

### User Stories

**As a requester**, I want to submit a request with an item name, quantity,
and purpose so that I can obtain what I need through a recorded, trackable
process.
- Given valid request details with a quantity greater than zero, when the
  request is saved, then a new row is created in the requests table.
- Given no status is specified, when the row is saved, then it defaults to
  'pending'.

**As a staff reviewer**, I want to view all submitted requests along with
their current status so that I can identify which ones still need action.
- Given at least one request exists, when I query id, requester_name,
  item_name, quantity, and status, then all matching rows are returned.
- Given a request has not been reviewed, when I view it, then its status
  still reads 'pending'.

**As a record keeper**, I want every request to automatically store when it
was created and last updated so that I can maintain an accurate audit trail.
- Given a new request is inserted, when I inspect the row, then created_at
  and updated_at are both automatically populated.
- Given an existing request is later modified, when I inspect it again, then
  updated_at reflects a newer timestamp than created_at.
