<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inquiry Confirmation</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f7f9;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f7f9; padding: 20px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #4299e1; padding: 30px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 600;">
                                Inquiry Received!
                            </h1>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px;">

                            <!-- Greeting -->
                            <p style="margin: 0 0 20px 0; font-size: 16px; line-height: 1.6; color: #333333;">
                                Thank you for contacting <strong>Otodoke</strong>! We've received your inquiry and will review it within the next 24 hours.
                            </p>

                            <!-- Inquiry Summary Box -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border-left: 4px solid #4299e1; margin: 30px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h2 style="margin: 0 0 15px 0; font-size: 18px; color: #2d3748;">
                                            Inquiry Summary
                                        </h2>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding: 8px 0; font-size: 14px; color: #718096;">
                                                    <strong style="color: #2d3748;">Email:</strong>
                                                </td>
                                                <td style="padding: 8px 0; font-size: 14px; color: #2d3748; text-align: right;">
                                                    {{ $inquiry->email }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; font-size: 14px; color: #718096;">
                                                    <strong style="color: #2d3748;">City:</strong>
                                                </td>
                                                <td style="padding: 8px 0; font-size: 14px; color: #2d3748; text-align: right;">
                                                    {{ ucfirst($inquiry->city) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; font-size: 14px; color: #718096;">
                                                    <strong style="color: #2d3748;">Items:</strong>
                                                </td>
                                                <td style="padding: 8px 0; font-size: 14px; color: #2d3748; text-align: right;">
                                                    {{ $inquiry->items->count() }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; font-size: 14px; color: #718096;">
                                                    <strong style="color: #2d3748;">Submitted:</strong>
                                                </td>
                                                <td style="padding: 8px 0; font-size: 14px; color: #2d3748; text-align: right;">
                                                    {{ $inquiry->created_at->format('M d, Y \a\t g:i A') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            @if($inquiry->additional_notes)
                            <!-- Additional Notes -->
                            <div style="margin: 20px 0;">
                                <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #2d3748;">
                                    Additional Notes
                                </h3>
                                <p style="margin: 0; padding: 15px; background-color: #f8fafc; border-radius: 4px; font-size: 14px; color: #4a5568; line-height: 1.6;">
                                    {{ $inquiry->additional_notes }}
                                </p>
                            </div>
                            @endif

                            @if($inquiry->items->count() > 0)
                            <!-- Items Section -->
                            <div style="margin-top: 30px;">
                                <h2 style="margin: 0 0 20px 0; font-size: 18px; color: #2d3748; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">
                                    Your Items
                                </h2>

                                @foreach($inquiry->items as $item)
                                <!-- Item Card -->
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden;">
                                    <tr>
                                        <td style="background-color: #f7fafc; padding: 12px 20px; border-bottom: 1px solid #e2e8f0;">
                                            <strong style="font-size: 16px; color: #2d3748;">
                                                Item {{ $loop->iteration }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 20px;">
                                            <!-- Item Details -->
                                            <p style="margin: 0 0 15px 0; font-size: 14px; line-height: 1.6; color: #4a5568;">
                                                {{ $item->details }}
                                            </p>

                                            @if($item->photos->count() > 0)
                                            <!-- Photos -->
                                            <div style="margin-top: 15px;">
                                                <p style="margin: 0 0 10px 0; font-size: 13px; font-weight: 600; color: #718096; text-transform: uppercase; letter-spacing: 0.5px;">
                                                    Photos ({{ $item->photos->count() }})
                                                </p>
                                                <table role="presentation" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        @foreach($item->photos as $photo)
                                                        <td style="padding: 0 10px 10px 0;">
                                                            <a href="{{ $photo->s3_url }}" style="display: block; text-decoration: none;">
                                                                <img src="{{ $photo->s3_url }}"
                                                                     alt="Item photo {{ $loop->iteration }}"
                                                                     style="width: 120px; height: 120px; object-fit: cover; border-radius: 6px; border: 2px solid #e2e8f0; display: block;">
                                                            </a>
                                                        </td>
                                                        @if($loop->iteration % 4 == 0)
                                                            </tr><tr>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                </table>
                                                <p style="margin: 10px 0 0 0; font-size: 12px; color: #a0aec0; font-style: italic;">
                                                    Click images to view full size
                                                </p>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                @endforeach
                            </div>
                            @endif

                            <!-- Next Steps -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top: 30px; background-color: #edf2f7; border-radius: 6px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #2d3748;">
                                            What happens next?
                                        </h3>
                                        <ul style="margin: 0; padding-left: 20px; font-size: 14px; line-height: 1.8; color: #4a5568;">
                                            <li>Our team will review your inquiry within 24 hours</li>
                                            <li>We'll send you a quote via email</li>
                                            <li>You can approve or request modifications</li>
                                            <li>Once approved, we'll process your order</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>

                            <!-- Closing -->
                            <p style="margin: 30px 0 0 0; font-size: 14px; line-height: 1.6; color: #4a5568;">
                                If you have any questions or need to make changes to your inquiry, please reply to this email.
                            </p>

                            <p style="margin: 20px 0 0 0; font-size: 14px; color: #4a5568;">
                                Best regards,<br>
                                <strong style="color: #2d3748;">The Otodoke Team</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f7fafc; padding: 30px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 10px 0; font-size: 12px; color: #a0aec0;">
                                This is an automated confirmation email. Please do not reply directly to this message.
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #cbd5e0;">
                                © {{ date('Y') }} Otodoke. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
