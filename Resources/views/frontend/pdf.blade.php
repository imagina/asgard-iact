@php
    $activities =$act->activities;
    $participants = $act->participant;
@endphp


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Acta #{{$act->id}}
    </title>
    <link rel="shortcut icon" href="{{ Theme::url('favicon.png') }}">

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
</head>
<body>
<header>
</header>
<!-- PIE DE PAGINA -->
<footer>
    <div class="px-3">
        <table class="table table-striped m-0 sizeText" style="background: #212529">
            <tbody class="">
                <tr>
                    <td style="vertical-align: middle; width: 33%" class="text-center">
                        <i class="fa fa-comments"></i>
                        Personeria de Ibague
                        <br>
                        personeriadeibague.gov.co
                    </td>
                    <td style="vertical-align: middle; width: 33%" class="text-center">
                        <i class="fa"></i>
                        despacho@personeriadeibague.gov.co
                    </td>
                    <td style="vertical-align: middle; width: 33%" class="text-center">
                        Telefono : +57 (8) 261 2536 • 310-325 08 67 • 313-360 25 28
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</footer>

<div class="logo mb-5">
    <img src="https://personeriadeibague.gov.co/themes/imagina2018/img/logo.png"
         width="55%"
         id="logo">
</div>

<div id="requirementFormat" class="mb-4">

    <!-- DATOS DEL CLIENTE -->
    <div class="col-12 pb-4 px-0">
        <!-- title -->
        <h5 class="text-center py-2 m-0" style="background: #212529; color: #fff" >
            ACTA # {{$act->id}}
        </h5>
        <div class="border" style="border-color: #212529">
            <!-- datos -->
            <table class="table sizeText m-0">
                <tbody>
                <tr>
                    <td class="font-weight-bold">
                        ASUNTO:
                    </td>
                    <td>
                        <span class="text-capitalize">
                            {{$act->title}}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">
                        FECHA:
                    </td>
                    <td>
                        <span>
                            {{strftime("%B %d de %Y",strtotime($act->created_at))}}
                        </span>
                    </td>
                    <td class="font-weight-bold border-left">
                        HORA:
                    </td>
                    <td>
                        <span class=>
                            {{strftime("%R",strtotime($act->created_at))}}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">
                       CIUDAD
                    </td>
                    <td>
                        <span>
                            {{$act->city->translate('en')->name}}
                        </span>
                    </td>
                    <td class="font-weight-bold border-left">
                        DIRECCION:
                    </td>
                    <td>
                        <span>
                           {{$act->address}}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">
                        CORREO ELECTRONICO:
                    </td>
                    <td>
                        <span>
                            {{$act->email}}
                        </span>
                    </td>
                    <td class="font-weight-bold border-left">
                        NUMERO DE CONTACTO:
                    </td>
                    <td>
                        <span>
                           {{$act->phone}}

                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if(count($participants))
    <div class="col-12 pb-4 px-0">
        <!-- title -->
        <h5 class="text-center py-2 m-0" style="background: #212529; color: #fff" >
            PARTICIPANTES
        </h5>
        <div class="border" style="border-color: #212529">
            <!-- datos -->
            <ul>
                @foreach($participants as $key=>$participant)
                    <li>
                        <strong> {{$participant->name}}</strong>
                    </li>
                @endforeach
            </ul>
        </div>
@endif
        @if(count($activities))
    <div class="col-12 pb-4 px-0">
        <!-- title -->
        <h5 class="text-center text-white py-2 m-0" style="background: #212529" >
            ACTIVIDADES
        </h5>
        <div class="border" style="border-color: #212529">
            <!-- datos -->
            <ul>
                @foreach($activities as $key=>$activity)
                    <li>
                        <strong> {{$activity}}</strong>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
    <!-- DATOS DEL PLAN -->
    <div class="pb-4">
        <!-- title -->
        <h5 class="text-center py-2 text-white m-0" style="background: #212529">
           DESARROLLO
            <br>
        </h5>
        <!-- descripcion -->
        <div class="border p-3 sizeText">
             <div class="sizeText">
              {!! $act->description !!}
                </div>
            </div>
        </div>
    </div>
    <!-- USUARIO -->
    <div class="pb-4">
            <!-- title -->
            <h5 class="text-center text-white py-2 m-0" style="background: #212529;">
                Firmas
            </h5>
            <!-- datos -->
            <div class="border" style="height:150px" >

            </div>
        </div>

</div>

</body>
</html>


<!-- ESTILOS  -->
<style>



    @page {
        margin-top: 100px;
    }
    *{
        font-family: Arial, Helvetica, sans-serif !important;
    }
    body{
        /*background-image: url('https://repositorios.imaginacolombia.com/themes/imagina2018/img/im-simbolo-gris.png');
        background-repeat: no-repeat;
        background-position: center;*/
    }
    #requirementFormat .col-6{
        width: 100% !important;
        position: static !important;
    }
    #requirementFormat .border{
        border: 2px solid #3a3a3a !important;
    }
    #requirementFormat .sizeText{
        font-size: 15px !important;
    }
    #requirementFormat td{
        padding: 5px;
        font-size: 15px !important;
    }
    header{
        position: fixed;
        top: -35px;
        left: -45px;
        right: -45px;
        height: 60px;
        color: white;
        z-index: -100;
    }
    footer{
        position: fixed;
        bottom: -35px;
        left: -45px;
        right: -45px;
        height: 60px;
        color: white;
    }
    #logo{
        opacity: 0.8;
    }
</style>
