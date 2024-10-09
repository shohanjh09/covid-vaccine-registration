# COVID-19 Vaccine Registration System

This is a **COVID-19 Vaccine Registration System** built using **Laravel**. It allows users to register for vaccination, select a vaccine center, and check their registration status. The system includes automated notifications for vaccination schedules, both via email and SMS (Twilio or similar integration), and follows a clean, modern design.

## Features

- **User Registration**: Users can register for vaccination by providing their full name, email, NID (National ID), and selecting a vaccination center.
- **Vaccine Center Selection**: Users can select a vaccine center from a pre-populated list.
- **Check Vaccination Status**: Users can enter their NID to check their registration and vaccination status. The system provides various statuses such as "Not Registered," "Scheduled," and "Vaccinated."
- **Scheduled Vaccination**: Vaccinations are scheduled based on the first-come-first-serve principle, ensuring users get scheduled dates according to available slots.
- **Email Notifications**: Automated email reminders are sent to users before their scheduled vaccination date. Emails can be tested using **Mailtrap**.
- **SMS Notifications**: SMS notifications are sent via Twilio (or similar services) to remind users of their scheduled vaccination date.
- **Service-Repository Structure**: The project follows a clean architecture where the controller calls the service, and the service interacts with the repository for database operations.
- **phpMyAdmin**: Included for easy database management via a browser.
- **Redis**: Utilized for caching and queue management.

## Tech Stack

- **Laravel (latest version)**
- **nginx** for serving the Laravel application.
- **MySQL** for database management.
- **phpMyAdmin** for managing the database via a web interface.
- **Redis** for caching and queue management.
- **Bootstrap 5** for the frontend.
- **Vite** for asset bundling and front-end tooling.
- **Docker** for containerized development.

## Setup Guide

### Requirements

Before setting up the project, make sure you have the following installed:

- **Docker**
- **Docker Compose**
- **Git**

### Step 1: Clone the Repository

Clone the repository to your local machine:

```bash
git clone https://github.com/your-repo/covid-vaccine-registration.git
```

### Step 2: Navigate to the Project Directory

```bash
cd covid-vaccine-registration
```

### Step 3: Setup Environment

Copy the `.env.example` file to create your `.env` file:

```bash
cp .env.example .env
```

Modify the `.env` file with the following values for Docker, MySQL, and Twilio:

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=covid_vaccine
DB_USERNAME=root
DB_PASSWORD=Uhtkjf75rbT8e3

# Twilio SMS credentials
TWILIO_SID=your_twilio_sid
TWILIO_AUTH_TOKEN=your_twilio_auth_token
TWILIO_SMS_FROM=your_twilio_phone_number

# Email settings (use your preferred email service)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@vaccine-system.com"
MAIL_FROM_NAME="${APP_NAME}"

# Optional - Set your preferred port for the application
APP_PORT=8070
```

### Step 4: Docker Setup

The application is containerized with **nginx**, **MySQL**, **phpMyAdmin**, **Redis**, and the Laravel application itself.

#### Step 4.1: Build and Start the Docker Containers

Run the following command to build and start your Docker containers:

```bash
docker-compose up --build
```

This will start the **nginx** server, **Laravel application**, **MySQL database**, **phpMyAdmin**, and **Redis** containers.

### Step 5: Composer Install and Key Generation

1. **Run Composer Install** inside the Docker container to install all the Laravel dependencies:

```bash
docker exec -it covid-vaccine-app composer install
```

2. **Generate the Laravel Application Key**:

```bash
docker exec -it covid-vaccine-app php artisan key:generate
```

### Step 6: Run Migrations and Seed Vaccine Centers

Once your containers are up and running, you need to set up the database.

1. **Run migrations** to create the necessary database tables:

```bash
docker exec -it covid-vaccine-app php artisan migrate
```

2. **Seed the database** with some initial vaccine centers:

```bash
docker exec -it covid-vaccine-app php artisan db:seed --class=VaccineCenterSeeder
```

### Step 7: Cache, Config, and Route Clear (Optional)

If needed, you can clear cached data for the application using the following commands:

```bash
docker exec -it covid-vaccine-app php artisan config:clear
docker exec -it covid-vaccine-app php artisan cache:clear
docker exec -it covid-vaccine-app php artisan route:clear
```

### Step 8: Compile Assets with Vite

To compile the front-end assets (CSS and JS), run the following command inside the Docker container:

```bash
docker exec -it covid-vaccine-app npm run dev
```

For production builds:

```bash
docker exec -it covid-vaccine-app npm run build
```

### Step 9: Access the Application

Once everything is set up, you can access the application and services in your browser:

- **Application**: [http://localhost:8070](http://localhost:8070)
- **phpMyAdmin**: [http://localhost:8071](http://localhost:8071)

The **phpMyAdmin** interface allows you to easily manage your MySQL database via a web browser. Use the following credentials:

- Username: `root`
- Password: `Uhtkjf75rbT8e3`

### Step 10: Using Redis for Caching and Queues

This application uses **Redis** for caching and queue management. Ensure that Redis is running as part of the Docker setup. You can monitor the status of the queues and Redis by using Laravel's built-in commands.

Run the following to start processing jobs:

```bash
docker exec -it covid-vaccine-app php artisan queue:work
```

## Email and SMS Notifications Testing

- **Email Notifications**: You can test email notifications using **Mailtrap**, a service for safely testing emails during development.

  To test:
    - Set up a Mailtrap account and add your **username** and **password** in the `.env` file under the mail configuration.
    - Mailtrap allows you to view emails sent by the application in a sandbox environment.

- **SMS Notifications**: SMS notifications are sent using **Twilio**. Make sure you configure the Twilio API credentials in the `.env` file. If using the **Twilio test credentials**, messages will be simulated.

## Testing

1. **Unit and Feature Testing**:
    - Run Laravel’s built-in tests to ensure the application works as expected.
    - Use the following command to run all the tests:

   ```bash
   docker exec -it covid-vaccine-app php artisan test
   ```

2. **Manual Testing**:
    - **User Registration**: Test user registration by visiting the registration page, submitting a valid form, and ensuring that users are added to the database.
    - **Vaccination Status**: Test the vaccination status feature by submitting a valid NID and verifying the displayed status.
    - **Email Notifications**: Use **Mailtrap** to verify that reminder emails are being sent before scheduled vaccination dates.
    - **SMS Notifications**: Use **Twilio** or a similar service to verify SMS notifications.

## Code Overview

### Service-Repository Pattern

- **Controllers**: Each controller interacts with a service layer, ensuring separation of concerns.
- **Services**: Handle business logic. Controllers call these services, which then interact with repositories.
- **Repositories**: Handle all database interactions. Services delegate data access to repositories, keeping the application flexible and testable.

### Notifications

- **Email Notifications**: Sent to users the night before their scheduled vaccination date via Laravel’s notification system.
- **SMS Notifications**: Sent via Twilio (or other SMS providers) to remind users of their vaccination date.

### Controllers

- **RegistrationController**: Handles user registration and scheduling of vaccination.
- **VaccinationController**: Handles the logic for checking vaccination status.

### Models

- **User**: Represents users who register for vaccination.
- **VaccineCenter**: Represents vaccination centers.
- **Vaccination**: Represents vaccination records and scheduled dates for users.

### Views

- **layouts/app.blade.php**: Base layout with navigation and footer.
- **registration/register.blade.php**: Form for registering users for vaccination.
- **search/status.blade.php**: Page for checking vaccination status.

## Future Improvements

- **Admin Panel**: Add admin functionality for managing vaccine centers.
- **Multi-language Support**: Add support for multiple languages for a better user experience.

## License

This project is open-source and available under the [MIT license](https://opensource.org/licenses/MIT).
