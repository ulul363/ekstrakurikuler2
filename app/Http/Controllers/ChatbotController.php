<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    private function getMenu()
    {
        // Tanda ** diganti jadi <b> (Bold)
        return "🎓 <b>BOT SPK EKSTRAKURIKULER</b><br><br>
                Ketik angka pilihan di bawah ini:<br>
                <b>1.</b> 🏆 Info Peringkat Terbaik<br>
                <b>2.</b> 📊 Kriteria MARCOS<br>
                <b>3.</b> 📌 Panduan Penggunaan<br>
                <b>4.</b> 💡 Reset Chat";
    }

    public function reply(Request $request)
    {
        $user_msg = strtolower(trim($request->input('message', '')));

        $state = $request->session()->get('chat_state', 'MENU');
        $reply = "";

        // LOGIKA FSM
        if (in_array($user_msg, ['menu', 'halo', 'hai', 'bantuan'])) {
            $request->session()->put('chat_state', 'MENU');
            $reply = "Halo! Saya asisten cerdas SPK Ekstrakurikuler. 👋<br><br>" . $this->getMenu();
        } else if ($state == 'MENU') {
            if ($user_msg == '1') {
                $reply = "🏆 <b>Hasil Peringkat MARCOS Saat Ini:</b><br>
                          1. <b>Pramuka</b> (Skor: 0.6861)<br>
                          2. <b>Paskibra</b> (Skor: 0.6481)<br>
                          3. <b>PMR</b> (Skor: 0.4254)<br>
                          4. <b>Teater</b> (Skor: 0.4050)<br><br>
                          <i>Ketik 'menu' untuk kembali.</i>"; // Tanda * diganti jadi <i> (Italic)
            } else if ($user_msg == '2') {
                $reply = "📊 <b>Kriteria Penilaian MARCOS:</b><br>
                          - <b>C1 (30%)</b>: Kehadiran Pertemuan<br>
                          - <b>C2 (25%)</b>: Program Kerja<br>
                          - <b>C3 (25%)</b>: Capaian Prestasi<br>
                          - <b>C4 (20%)</b>: Intensitas Pertemuan<br><br>
                          <i>Ketik 'menu' untuk kembali.</i>";
            } else if ($user_msg == '3') {
                $reply = "📌 <b>Panduan Penggunaan Sistem:</b><br>
                          1. <b>Ketua Ekskul</b> login dan upload kegiatan.<br>
                          2. <b>Pembina</b> memvalidasi bukti.<br>
                          3. <b>Admin</b> melihat hasil SPK.<br><br>
                          <i>Ketik 'menu' untuk kembali.</i>";
            } else if ($user_msg == '4') {
                $request->session()->put('chat_state', 'MENU');
                $reply = "Sistem telah direset. 🔄<br><br>" . $this->getMenu();
            } else {
                $reply = "Maaf, saya tidak mengerti pilihan Anda. 😕<br><br>" . $this->getMenu();
            }
        } else {
            $request->session()->put('chat_state', 'MENU');
            $reply = $this->getMenu();
        }

        return response()->json(['reply' => $reply]);
    }
}