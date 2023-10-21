# Hangman Game Registration and Email Verification

Welcome to the Hangman Game Registration and Email Verification system. This system allows users to create accounts, verify their email addresses, and complete the registration process.

## Getting Started

1. Clone this repository to your local development environment.

2. Make sure you have PHP installed and a web server (e.g., Apache) set up to run the PHP code.

3. Set up a MySQL database and configure the connection settings in the `connect.php` file.

## Usage

### Registration and Email Verification

1. Start at the `index.php` page, where you have the option to either log in or create an account.

2. To create an account:
   - Click the "Create Account" button.
   - Enter your email address and your fullname.
   - Click the "Send Verification Email" button.

3. You may encounter the following errors:
   - "The email already exists": If the email address is already registered.
   - "The email is written in an invalid format": If the email is not in a valid format.
   - "Error inserting data": If there is an issue with the database insertion.
   - "Failed to send an email": If there is an issue with sending the verification email.

4. If there are no errors:
   - A verification email will be sent to your provided email address.
   - The email will contain a link to complete the registration.

5. Click the verification link in the email to complete the registration. This link will expire within a specified time frame (2 hours).

### Account Creation

1. After clicking the verification link, you will be taken to the registration page.

2. Enter your desired username, password, and confirm the password.

3. You may encounter the following errors:
   - "Passwords do not match": If the passwords provided do not match.
   - "Username already exists. Please choose a different username": If the chosen username is already in use.

4. If all is well, you will be directed to the sign-in page.

### Sign In

1. At the sign-in page, enter your credentials (username and password) to access the Hangman Game.

## Important Notes

- Ensure that your server environment is correctly set up to handle PHP and send emails through an SMTP server.

