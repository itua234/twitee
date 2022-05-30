About Book Rating API
This API is built with the Laravel Framework:

API Local Documentation url: (127.0.0.1:8000/api/docs)
Cloning the project
To clone the project, simply click on this link: Twitee API →:

Click the Code button on the github page
From the flyout menu Copy the HTTPS link.
Go to the application folder using cd command on your cmd or terminal: git clone https://github.com/absyinka/twitee
Run composer install on your cmd or terminal
Copy the .env.example file to .env on the root folder. You can type copy .env.example .env if using Windows command prompt or cp .env.example .env if using Powershell terminal.
Open your .env file and change the following: DB_DATABASE, DB_USERNAME and DB_PASSWORD field to match your local configuration.
Run php artisan key:generate
Run php artisan migrate
Run php artisan serve
Go to localhost:8000 or 127.0.0.1:8000
Thank you