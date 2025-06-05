<div style="font-family: Arial, sans-serif;">

    <div style="max-width: 600px; margin: 20px auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div style="text-align: center">
            {{-- <img height="80" width="150" src="{{ $logo ?? '' }}"> --}}
        </div>
        <div style="margin-bottom: 20px;">
            <h1 style="color: #333;text-align:center">{{ $emailData['subject'] ?? '' }}</h1>
            <h4><h1 style="color: #333;text-align:center">{{ $emailData['email_otp'] ?? '' }}</h1></h4>
            @if ($emailData['url'])
                <p style="text-align: center">
                    <a href="{{ $emailData['url'] }}" 
                    style="display: inline-block; padding: 12px 30px; background-color: #4CAF50; color: white; text-align: center; font-size: 16px; font-weight: bold; text-decoration: none; border-radius: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: background-color 0.3s;" 
                    onmouseover="this.style.backgroundColor='#45a049'" onmouseout="this.style.backgroundColor='#4CAF50'">
                    {{ $emailData['text'] }}
                    </a>
                </p>
            @endif
        </div>
    </div>

</div>