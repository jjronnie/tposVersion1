<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Message: Welcome to TPOS</title>
</head>
<body bgcolor="#0A0A0A">

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                
                <table width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#1A1A1A">
                    
                    <tr>
                        <td bgcolor="#00FFFF" height="10" colspan="2"></td>
                    </tr>
                    <tr>
                        <td bgcolor="#000000" align="center" style="padding: 20px 0;">
                            <font face="Monospace, Courier New, sans-serif" color="#00FFFF" size="5">
                                **// SYSTEM BOOT: WELCOME TO TPOS //**
                            </font>
                            <br>
                            <font face="Monospace, Courier New, sans-serif" color="#AAAAAA" size="2">
                                *A new chapter in business efficiency begins now.*
                            </font>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 30px 40px;">
                            <font face="Verdana, Geneva, sans-serif" color="#FFFFFF" size="3">
                                
                                <p><strong>ACCESS GRANTED: User {{ $name }},</strong></p>
                                
                                <p>This transmission confirms the successful provisioning of your new business matrix, <strong>{{ $businessName }}</strong>. We are initiating the handshake protocol and are excited to welcome you aboard the TPOS network.</p>
                                
                                <p>To fully integrate your entity, a core data sync is required. Please access the Configuration Module to define your business parameters, product manifests, and service protocols.</p>

                                <br>
                            </font>
                            
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" bgcolor="#00FFFF" style="padding: 15px 0;">
                                        <a href="{{ $setupUrl }}" target="_blank" style="text-decoration: none;">
                                            <font face="Monospace, Courier New, sans-serif" color="#000000" size="4">
                                                <strong>[[ EXECUTE BUSINESS SETUP PROTOCOL ]]</strong>
                                            </font>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <font face="Verdana, Geneva, sans-serif" color="#FFFFFF" size="3">
                                <br>
                                <p><strong>DIRECTIVE:</strong> Complete the setup to unlock full system capabilities. Your operational efficiency is our primary objective.</p>

                            </font>
                        </td>
                    </tr>
                    
                    <tr>
                        <td bgcolor="#000000" style="padding: 20px 40px; border-top: 1px solid #00FFFF;">
                            <font face="Verdana, Geneva, sans-serif" color="#AAAAAA" size="2">
                                <p align="center">
                                    Should you encounter any errors or require Level-1 support, transmit a query to our 24/7 Response Unit.
                                </p>
                                <p align="center" style="margin-top: 10px;">
                                    <strong><font color="#00FFFF">END OF TRANSMISSION.</font></strong><br>
                                    The {{ config('app.name') }} Automated Intelligence Team
                                </p>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#00FFFF" height="10" colspan="2"></td>
                    </tr>

                </table>
                </td>
        </tr>
    </table>
    </body>
</html>