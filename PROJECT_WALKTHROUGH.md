# Explaining the Student Management System

Use this page to understand the project and explain it in your own words. The main application code is in `app`, `routes`, `resources/views`, and `database`.

## The basic Laravel pattern

- **Route** (`routes/web.php`): connects a URL to the code that handles it. For example, `/available-courses` opens the student's course list.
- **Controller** (`app/Http/Controllers`): receives the request, talks to the database through models, then chooses a page or redirect.
- **Model** (`app/Models`): represents a database table. `Course` represents courses; `User` represents people who sign in.
- **View** (`resources/views`): the Blade template that displays HTML to the user.
- **Migration** (`database/migrations`): describes how Laravel creates a database table.

In short: **route → controller → model/database → view**.

## How student course registration works

1. A student opens the available courses page. The `Student` role check in `routes/web.php` limits that page to signed-in students.
2. The student presses the register button. The browser sends a POST request to `/register-course/{course}`.
3. `RegistrationController::store` gets the signed-in student and selected course. It checks for an existing registration, then `attach` adds their IDs to the `registrations` table.
4. The controller sends the student back to the page with a success or already-registered message.
5. To drop a course, the page sends a DELETE request. `RegistrationController::destroy` uses `detach` to remove that student's course link.

The `registrations` table joins students and courses. One student can register for many courses, and each course can have many students.

## What to say about roles

The app has three roles: **Admin**, **Lecturer**, and **Student**. The role middleware in `routes/web.php` protects groups of URLs. For example, only Admins can manage records, Lecturers can see their assigned courses, and Students can register for courses. The role is checked on the server, so hiding a button in a page is not the only protection.

## Files to look at first

- `routes/web.php` — the URLs and who can use them.
- `app/Http/Controllers/RegistrationController.php` — registering for and dropping courses.
- `app/Http/Controllers/CourseController.php` — displaying and managing courses.
- `app/Models/User.php` and `app/Models/Course.php` — how users and courses are related.
- `database/migrations/2026_10_27_164403_create_registrations_table.php` — the table that stores course registrations.

## Useful terms

- **Validation:** checking submitted form values before saving them.
- **Relationship:** a rule that tells Laravel how two tables connect.
- **`attach`:** add a relationship row, such as a student joining a course.
- **`detach`:** remove that relationship row.
- **Middleware:** a check that runs before a page opens, such as requiring login or a role.
- **Redirect:** send the browser to another page after an action is complete.
