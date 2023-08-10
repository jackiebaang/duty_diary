@component('mail::message')
# You are invited!
<br>
Hello {{ $inviteData['user']->name }},  
<br><br>
{{ $inviteData['invitedBy']}} has invited you to CDL Internship's Duty Diary  
<br><br>
*****************************************<br>
Username: {{ $inviteData['user']->email }}<br>
Temporary Password: {{ $inviteData['pass'] }}
*****************************************
<br>
@component('mail::button', ['url' => $inviteData['url'], 'class'=>'text-right'])
Accept
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
