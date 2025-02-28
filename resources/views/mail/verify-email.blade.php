<x-mail-layout>
    <tr>
        <td class="innerpadding borderbottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="h2">
                        {{ __('E-posta mı doğrulamak istiyorsunuz?') }}
                    </td>
                </tr>
                <tr>
                    <td class="bodycopy">
                        Merhaba,
                        <br><br>
                        E-posta doğrulamak için aşağıdaki butonu tıklayın.
                        <br><br>
                        <a href="{{ route('auth.verify-email', ['token' => $token]) }}"
                            style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;">
                            {{ __('E-Posta Doğrula') }}
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</x-mail-layout>
