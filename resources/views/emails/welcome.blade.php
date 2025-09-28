@component('mail::message')
# Welcome to TechTower Smart POS!

A new chapter in business efficiency begins now.

Hello {{ $name }},

Thank you for signing up and creating your new business account, **{{ $businessName }}**.  
We're excited to have you on board!

To help you get started, we recommend setting up your business records and preferences.  
You can do this by visiting the settings page and providing information about your business, products, and services.

@component('mail::button', ['url' => $setupUrl])
Complete Your Business Setup
@endcomponent

If you have any questions or need assistance, please do not hesitate to contact our support team.

Best regards,  
The TechTower Smart POS Team
@endcomponent
