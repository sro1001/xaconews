@extends('mail.layout.mailLayout')

@section('content')
    <table class="table_scale" align="center" cellpadding="0" style="border-collapse: collapse; width=75%; margin-top:30px!important;background-color: #BEEA9F;border-block-color: black;border: 4px solid;">
        <tr>
            <td width="100%" height="20">&nbsp;</td>
        </tr>
        <tr>
            <td width="100%">
                Hola {{$usuario->nombre_completo}},
            </td>
        </tr>
        <tr>
            <td width="100%" height="30">&nbsp;</td>
        </tr>
        <tr>
            <td width="100%">
                Has recibido este email porque has solicitado restablecer tu contraseña. <br>
                Para completar el proceso, haz click <a href="{{route('password.reset', $token)}}">en este enlace</a>.<br>
            </td>
        </tr>

        <tr>
            <td width="100%" height="20">&nbsp;</td>
        </tr>
    </table>
@endsection