    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>New contact form submission</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.4;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #e2dede;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            h1 {
                font-size: 24px;
                margin-bottom: 20px;
                text-align: center;
            }
            p {
                margin: 10px 0;
            }
            .message {
                background-color: #fff;
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>New Message received from your portfolio:</h1>
            <div class="message">
                <p><strong>Name:</strong> {{ $contact->name }}</p>
                <p><strong>Email:</strong> {{ $contact->email }}</p>
                <p><strong>Message:</strong></p>
                <p>{{ $contact->message }}</p>
            </div>
        </div>
    </body>
    </html>
