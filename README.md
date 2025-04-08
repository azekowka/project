# Movie Mood Matcher App for the CS Term 4

A web application that recommends movies based on user's mood. Built with PHP, MySQL, JavaScript, HTML, and CSS.

## Features

- User Authentication (Login/Signup)
- Mood-based Movie Recommendations
- Add/View Movies
- Responsive UI/UX Design using Flexbox and Grid 
- Session Management
- Secure Password Handling
- Uses PDO for database operations
- Implements MVC-like pattern (Model-View-Controller) 
- Clean code ensures good developer experience (DX)

## Project Structure

```
movie_mood_matcher/
├── Authentication Files
│   ├── login.php      # User login handling
│   ├── signup.php     # New user registration
│   ├── auth.php       # Authentication functions
│   └── logout.php     # User logout handling
│
├── Core Files
│   ├── index.php      # Main application page
│   ├── add_movie.php  # Add new movies form
│   └── db.php         # Database configuration
│
├── Assets
│   ├── style.css      # Application styling
│   ├── script.js      # Client-side functionality
│   └── default.jpg    # Default movie image
│
├── Database
│   └── setup.sql      # Database schema and initial data
│
└── README.md          # Project documentation
```

## Database Structure

### Tables

1. **users**
   - id (Primary Key)
   - username (Unique)
   - email (Unique)
   - password (Hashed)
   - created_at

2. **moods**
   - id (Primary Key)
   - mood_name (Unique)

3. **movies**
   - id (Primary Key)
   - title
   - description
   - mood_id (Foreign Key to moods)
   - image_url
   - user_id (Foreign Key to users)
   - created_at

## Flow of Operation

1. **Authentication Flow**
   - Unauthenticated users are redirected to login.php
   - Users can create account through signup.php
   - Successful auth creates session via auth.php
   - Users can logout through logout.php

2. **Main Application Flow**
   - Authenticated users see index.php
   - Can select moods to filter movies
   - Can add new movies through add_movie.php
   - All database operations go through db.php

3. **Data Flow**
   - Movies are associated with users (user_id)
   - Movies are categorized by moods (mood_id)
   - Images default to default.jpg if not provided

## Security Features

- Password hashing using PHP's password_hash()
- Session-based authentication
- SQL injection prevention through prepared statements
- Input validation and sanitization
- Protected routes requiring authentication

## Installation

1. Clone the repository to your web server's directory:
```bash
git clone [repository-url]
```

2. Set up the database:
   - Open phpMyAdmin or MySQL client
   - Import setup.sql file
   - This will create the database and required tables

3. Configure database connection:
   - Open db.php
   - Update database credentials if needed:
     ```php
     $host = 'localhost';
     $dbname = 'movie_mood_matcher';
     $username = 'root';
     $password = '';
     ```

4. Test user credentials:
   - Username: test_user
   - Password: test123

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Modern web browser
- XAMPP