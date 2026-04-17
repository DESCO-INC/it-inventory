<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Email Test</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f8;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding:30px 10px;">

                <!-- CARD -->
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0"
                    style="width:600px; background:#ffffff; border:1px solid #e5e5e5;">

                    <!-- HEADER -->
                    <tr>
                        <td
                            style="background:#16a34a; padding:18px; text-align:center;
                        font-family:Arial, sans-serif; font-size:16px; color:#ffffff;">
                            IT Inventory System Notification
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:25px; font-family:Arial, sans-serif; font-size:14px; color:#333333;">

                            <p style="margin:0 0 15px 0;">Hello IT Department,</p>

                            <p style="margin:0 0 20px 0;">
                                This is an automated system alert regarding software licenses that are
                                <strong>expired</strong> or <strong>expiring within 30 days</strong>.
                            </p>

                            <!-- EXPIRED TABLE TITLE -->
                            <p style="margin:0 0 10px 0; font-weight:bold;">
                                Expired Software/s:
                            </p>

                            <!-- EXPIRED TABLE -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="border-collapse:collapse; font-family:Arial, sans-serif; font-size:13px;">

                                <tr style="background:#f3f4f6;">
                                    <td style="border:1px solid #dddddd; padding:8px; font-weight:bold;">User</td>
                                    <td style="border:1px solid #dddddd; padding:8px; font-weight:bold;">Unit</td>
                                    <td style="border:1px solid #dddddd; padding:8px; font-weight:bold;">Software</td>
                                    <td style="border:1px solid #dddddd; padding:8px; font-weight:bold;">Expiry Date
                                    </td>
                                </tr>

                                @forelse ($software->where('status', 'EXPIRED') as $item)
                                    <tr>
                                        <td style="border:1px solid #dddddd; padding:8px;">
                                            {{ $item->inventory->latestAccountability->name ?? 'Unassigned' }}
                                        </td>
                                        <td style="border:1px solid #dddddd; padding:8px;">
                                            {{ $item->inventory->control_no ?? 'N/A' }}
                                        </td>
                                        <td style="border:1px solid #dddddd; padding:8px;">
                                            {{ $item->software->name ?? 'N/A' }}
                                        </td>
                                        <td style="border:1px solid #dddddd; padding:8px;">
                                            {{ $item->date_expired }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3"
                                            style="border:1px solid #dddddd; padding:8px; text-align:center;">
                                            No expired software found.
                                        </td>
                                    </tr>
                                @endforelse
                            </table>

                            <br>

                            <!-- EXPIRING TITLE -->
                            <p style="margin:0 0 10px 0; font-weight:bold;">
                                Expiring Within 30 Days:
                            </p>

                            <!-- EXPIRING TABLE -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="border-collapse:collapse; font-family:Arial, sans-serif; font-size:13px;">

                                <tr style="background:#f3f4f6;">
                                    <td style="border:1px solid #dddddd; padding:8px; font-weight:bold;">User</td>
                                    <td style="border:1px solid #dddddd; padding:8px; font-weight:bold;">Unit</td>
                                    <td style="border:1px solid #dddddd; padding:8px; font-weight:bold;">Software</td>
                                    <td style="border:1px solid #dddddd; padding:8px; font-weight:bold;">Expiry Date
                                    </td>
                                </tr>

                                @forelse ($software->where('status', 'EXPIRING') as $item)
                                    <tr>
                                        <td style="border:1px solid #dddddd; padding:8px;">
                                            {{ $item->inventory->latestAccountability->name ?? 'Unassigned' }}
                                        </td>
                                        <td style="border:1px solid #dddddd; padding:8px;">
                                            {{ $item->inventory->control_no ?? 'N/A' }}
                                        </td>
                                        <td style="border:1px solid #dddddd; padding:8px;">
                                            {{ $item->software->name ?? 'N/A' }}
                                        </td>
                                        <td style="border:1px solid #dddddd; padding:8px;">
                                            {{ $item->date_expired }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            style="border:1px solid #dddddd; padding:8px; text-align:center;">
                                            No software expiring soon.
                                        </td>
                                    </tr>
                                @endforelse
                            </table>

                            <br>

                            <!-- BUTTON -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
                                <tr>
                                    <td style="background:#2563eb; padding:12px 20px; text-align:center;">
                                        <a href="{{ route('software.index') }}" target="_blank"
                                            style="color:#ffffff; text-decoration:none; font-size:14px; font-weight:bold; display:inline-block;">
                                            Go to IT Inventory System
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:30px 0 0 0;">
                                This is a system-generated email. Please do not reply.
                            </p>

                            <p style="margin:5px 0 0 0;">
                                <strong>Date Generated:</strong> {{ now()->format('F d, Y') }}
                            </p>

                        </td>
                    </tr>

                </table>
                <!-- END CARD -->

            </td>
        </tr>
    </table>

</body>

</html>
