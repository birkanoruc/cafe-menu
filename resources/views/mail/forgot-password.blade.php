<x-mail-layout>
    <tr>
        <td class="innerpadding borderbottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="h2">
                        {{ __('Şifrenizi mi unuttunuz?') }}
                    </td>
                </tr>
                <tr>
                    <td class="bodycopy">
                        Merhaba,
                        <br><br>
                        Şifrenizi sıfırlamak için aşağıdaki butonu tıklayın.
                        <br><br>
                        <a href="{{ route('auth.reset-password', ['token' => $token, 'email' => $email]) }}"
                            style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;">
                            {{ __('Şifreyi Sıfırla') }}
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</x-mail-layout>
