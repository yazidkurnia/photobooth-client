# Photobooth Application Blueprint

## Overview

This document outlines the architecture, features, and implementation details of the Photobooth application. The application is a web-based photobooth that allows users to take pictures using their device's camera.

## Features

*   **Email-based session:** Users start a session by entering their email address.
*   **Camera access:** The application requests permission to access the user's camera.
*   **Countdown timer:** A countdown timer is displayed before each photo is taken.
*   **Automatic photo capture:** Photos are taken automatically at regular intervals.
*   **Photo gallery:** Captured photos are displayed in a gallery.
*   **Session timer:** A session timer limits the duration of the photo session.

## Current Implementation

### Frontend

*   **View:** The main view is `resources/views/photobooth.blade.php`.
*   **Styling:** Tailwind CSS is used for styling.
*   **JavaScript:** Vanilla JavaScript is used to handle the application's logic.

### Backend

*   **Controller:** The `app/Http/Controllers/PhotoBoothController.php` handles the application's backend logic.
*   **Routing:** The route for the photobooth is defined in `routes/web.php`.

## Recent Changes

*   **Camera detection and permission handling:** The application now checks if a camera is available and if the user has granted permission to use it. If not, an appropriate error message is displayed.

## Future Enhancements

*   **Image storage:** Captured photos will be saved to the server.
*   **Email integration:** An email will be sent to the user with a link to their photo gallery.
*   **Social media sharing:** Users will be able to share their photos on social media.
