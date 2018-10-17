@component('mail::message')

    Tran trong kinh mời GD {{ $lead->title }}. {{ $lead->name }} tham dự Su Kien Du Lich luc {{ $appointment->appointment_datetime->format('d-m-Y H:i') }} tại tòa nhà Indochina, 4 Nguyễn Đình Chiểu, P.DaKao, Q1 (Tang 13, Khu A).
    Xin vui long mang theo CNMD de hoan thanh thu tuc dang ky.
    Dua ma so sau cho le tan de xac nhan: {{ $appointment->code }}
@endcomponent

Regards,<br>
YTMxxxxxx<br>
Hotline: 09xxxxxxxx
@endcomponent