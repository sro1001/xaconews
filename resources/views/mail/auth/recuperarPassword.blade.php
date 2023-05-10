@extends('mail.layout.mailLayout')

@section('content')
    <table class="table_scale" width="80%" align="center" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0"
           style="border-collapse: collapse;">

        <tr>
            <td width="100%" height="40">&nbsp;</td>
        </tr>
        <tr>
            <td width="100%">
                Hola {{$usuario->nombre_completo}}
            </td>
        </tr>
        <tr>
            <td width="100%" height="30">&nbsp;</td>
        </tr>
        <tr>
            <td width="100%">
                Has recibido este email porque has solicitado reestablecer tu contraseña. <br>
                Para completar el proceso, haz click <a href="{{route('password.reset', $token)}}">en este enlace</a>.<br>
            </td>
        </tr>

        <tr>
            <td width="100%" height="30">&nbsp;</td>
        </tr>
    </table>
@endsection