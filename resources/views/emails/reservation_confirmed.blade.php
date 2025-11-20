<div style="font-family: Arial, Helvetica, sans-serif; max-width: 600px; margin: 0 auto;">
    <h2 style="color:#ff7a00;">Konfirmasi Reservasi</h2>
    <p>Halo {{ $reservation->customer_name }},</p>
    <p>Terima kasih telah melakukan reservasi di Najwa Salon. Berikut detailnya:</p>
    <ul>
        <li>Tanggal: {{ $reservation->date }}</li>
        <li>Waktu: {{ $reservation->time_slot }}</li>
        <li>Layanan: {{ $reservation->service->name }}</li>
    </ul>
    <p>Jika perlu perubahan jadwal, balas email ini atau hubungi WhatsApp kami.</p>
    <p>Salam,</p>
    <p>Najwa Salon</p>
</div>