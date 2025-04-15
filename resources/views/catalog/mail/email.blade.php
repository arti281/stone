<div style="font-family: Arial, sans-serif; background:#b8b7b7; margin: 0; padding: 15px;">

    <div style="max-width: 600px; margin: 20px auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div style="text-align: center">
            <img height="80" width="150" src="{{ $logo ?? '' }}">
        </div>
        <div style="margin-bottom: 20px;">
            <h1 style="color: #333;">Hi {{ $emailData['name'] ?? '' }}</h1>
            <p style="color: #666;">Query : <strong>{{$emailData['title'] ?? ''}}</strong></p>
        </div>

        @if ($emailType == 'customer')  
            <div style="margin-bottom: 20px;">

                @if ($emailData['title'] == 'For Enquiry')
                    <p style="color: #666; line-height: 1.6;">Thank you for reaching out to us with your enquiry. We appreciate your interest in EZ-Lifestyle and are eager to assist you further.</p>
                @else
                    <p style="color: #666; line-height: 1.6;">Thank you for reaching out EZ-Lifestyle. We appreciate your interest in <strong>{{$emailData['title']}}</strong> and are eager to assist you further.</p>
                @endif   
                
                <p style="color: #666; line-height: 1.6;">Our team has received your message and will be in touch with you shortly to address your query. If you have any additional information or specific requirements, please feel free to let us know, and we will do our best to accommodate your needs.</p>

            </div>
            <div>
                <p style="color: #666; font-style: italic;">Best Regards,</p>
                <p style="color: #666;">EZ Lifestyle</p>
            </div>
        @endif

        @if ($emailType == 'admin')
            <div style="margin-bottom: 20px;">
                I'm absolutely thrilled to be reaching out to you! This opportunity to connect has me genuinely excited.
            </div>
            <table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse: collapse;">
                @if (optional($emailData)['brand_name'])
                    <tr>
                        <th style="background-color: #f2f2f2;">Brand Name</th>
                        <td style="background-color: #fff;">{{$emailData['brand_name']}}</td>
                    </tr> 
                @endif
                @if (optional($emailData)['shop_name'])
                    <tr>
                        <th style="background-color: #f2f2f2;">Shop Name</th>
                        <td style="background-color: #fff;">{{$emailData['shop_name']}}</td>
                    </tr> 
                @endif
                @if (optional($emailData)['firm_name'])
                    <tr>
                        <th style="background-color: #f2f2f2;">Firm Name</th>
                        <td style="background-color: #fff;">{{$emailData['firm_name']}}</td>
                    </tr> 
                @endif
                @if (optional($emailData)['email'])
                    <tr>
                        <th style="background-color: #f2f2f2;">Email</th>
                        <td style="background-color: #fff;">{{$emailData['email']}}</td>
                    </tr> 
                @endif
                @if (optional($emailData)['number'])
                    <tr>
                        <th style="background-color: #f2f2f2;">Number</th>
                        <td style="background-color: #fff;">{{$emailData['number']}}</td>
                    </tr> 
                @endif
                @if (optional($emailData)['address'])
                    <tr>
                        <th style="background-color: #f2f2f2;">Address</th>
                        <td style="background-color: #fff;">{{$emailData['address']}}</td>
                    </tr> 
                @endif
                @if (optional($emailData)['website'])
                    <tr>
                        <th style="background-color: #f2f2f2;">Website</th>
                        <td style="background-color: #fff;">{{$emailData['website']}}</td>
                    </tr> 
                @endif
                @if (optional($emailData)['message'])
                    <tr>
                        <th style="background-color: #f2f2f2;">Message</th>
                        <td style="background-color: #fff;">{{$emailData['message']}}</td>
                    </tr> 
                @endif
            </table>
            <div>
                <p style="color: #666; font-style: italic;">Best Regards,</p>
                <p style="color: #666;">{{$emailData['name']}}</p>
            </div>
        @endif
    </div>

</div>