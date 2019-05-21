<html style="background-color:#F2F2F2;">
<head>
   <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
</head>
<body style="background-color:#F2F2F2;padding-top:65px;text-align:center;font-family:Arial, Helvetica, sans-serif;" >
<table class="container" align="center" cellspacing="0" border="0" cellpadding="0" width="580" bgcolor="#FFFFFF" style="width:580px;background-color:#FFF; border-top: 1px solid #DDD; border-bottom: 1px solid #DDD;" >
<tr>
    <td style="text-align: center;padding-top:44px;padding-left:39px;padding-right:39px;border-left-width:1px;border-left-style:solid;border-left-color:#DDD;border-right-width:1px;border-right-style:solid;border-right-color:#DDD;">
        <img alt="logo" src="{{ url(ViewHelper::getImgSrc('logo.png'))  }}" />
    </td>
</tr>
<tr>
    <td class="title" style="padding-top:44px;padding-left:39px;padding-right:39px;text-align:left;border-left-width:1px;border-left-style:solid;border-left-color:#DDD;border-right-width:1px;border-right-style:solid;border-right-color:#DDD;" >
        <h2 style="font-family:Arial, Helvetica, sans-serif;font-size:28px;color:#262626;font-weight:normal;margin-top:0;margin-bottom:39px;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;letter-spacing:0;" >Contact Form Enquiry</h2>
    </td>
</tr>
<tr>
    <td class="section" style="padding-top:0px;padding-bottom:0;padding-right:39px;padding-left:39px;text-align:left;border-left-width:1px;border-left-style:solid;border-left-color:#DDD;border-right-width:1px;border-right-style:solid;border-right-color:#DDD;" >
        <p style="font-family:Arial, Helvetica, sans-serif;margin-top:0;margin-bottom:5px;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-size:12px;color:#4C4C4C;" >The following message was sent via the website contact form:</p>
    </td>
</tr>

<tr>
    <td class="section" style="padding-top:25px;padding-bottom:0;padding-right:39px;padding-left:39px;text-align:left;border-left-width:1px;border-left-style:solid;border-left-color:#DDD;border-right-width:1px;border-right-style:solid;border-right-color:#DDD;" >
        <h3 style="font-family:Arial, Helvetica, sans-serif;color:#262626;font-weight:bold;font-size:16px;margin-bottom:3px;">
        	Name
        </h3>
        <p style="font-family:Arial, Helvetica, sans-serif;margin-top:0;margin-bottom:5px;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-size:12px;color:#4C4C4C;" >
        	{{ $entry->first_name . ' ' . $entry->last_name }}
        </p>
    </td>
</tr>
@if (!empty($entry->phone))
    <tr>
        <td class="section" style="padding-top:25px;padding-bottom:0;padding-right:39px;padding-left:39px;text-align:left;border-left-width:1px;border-left-style:solid;border-left-color:#DDD;border-right-width:1px;border-right-style:solid;border-right-color:#DDD;" >
            <h3 style="font-family:Arial, Helvetica, sans-serif;color:#262626;font-weight:bold;font-size:16px;margin-bottom:3px;">
                Phone
            </h3>
            <p style="font-family:Arial, Helvetica, sans-serif;margin-top:0;margin-bottom:5px;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-size:12px;color:#4C4C4C;" >
                {{ $entry->phone }}
            </p>
        </td>
    </tr>
@endif
<tr>
    <td class="section" style="padding-top:25px;padding-bottom:0;padding-right:39px;padding-left:39px;text-align:left;border-left-width:1px;border-left-style:solid;border-left-color:#DDD;border-right-width:1px;border-right-style:solid;border-right-color:#DDD;" >
        <h3 style="font-family:Arial, Helvetica, sans-serif;color:#262626;font-weight:bold;font-size:16px;margin-bottom:3px;">
        	Email
        </h3>
        <p style="font-family:Arial, Helvetica, sans-serif;margin-top:0;margin-bottom:5px;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-size:12px;color:#4C4C4C;" >
        	{{ $entry->email }}
        </p>
    </td>
</tr>
<tr>
    <td class="section" style="padding-top:25px;padding-bottom:0;padding-right:39px;padding-left:39px;text-align:left;border-left-width:1px;border-left-style:solid;border-left-color:#DDD;border-right-width:1px;border-right-style:solid;border-right-color:#DDD;" >
        <h3 style="font-family:Arial, Helvetica, sans-serif;color:#262626;font-weight:bold;font-size:16px;margin-bottom:3px;">
        	Message
        </h3>
        <p style="font-family:Arial, Helvetica, sans-serif;margin-top:0;margin-bottom:5px;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-size:12px;color:#4C4C4C;" >
        	{!! nl2br($entry->message) !!}
        </p>
    </td>
</tr>

<tr>
    <td class="last" style="font-family:Arial, Helvetica, sans-serif;padding-bottom:24px !important;padding-left:39px;padding-right:39px;border-left-width:1px;border-left-style:solid;border-left-color:#DDD;border-right-width:1px;border-right-style:solid;border-right-color:#DDD;" >&nbsp;</td>
</tr>
<tr>
    <td class="cta" align="left" style="background-color:#F1FAFE;font-size:14px;color:#1f1f1f;border-top-width:1px;border-top-style:solid;border-top-color:#DAE3EA;border-left-width:1px;border-left-style:solid;border-left-color:#DDD;border-right-width:1px;border-right-style:solid;border-right-color:#DDD;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:25px;padding-bottom:25px;padding-right:39px;padding-left:39px;text-align:left;" >
        <table cellspacing="0" border="0" cellpadding="0" width="500" align="left">
            <tr>
                <td class="link" align="left" style="font-family:Arial, Helvetica, sans-serif;padding-left:9px; font-size: 14px;" >
                    <a href="{{ route('home') }}" style="color:#185787;" >{{ settings('site_name') }}</a>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
</body>
</html>