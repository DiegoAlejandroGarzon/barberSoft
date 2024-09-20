<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Mi first PDF</title>
		<style>
			.content {
			  position: 0;
			  width: 100%;
			  background-color: beige;
			}
			.card{
			  position: 0;
			  width: 100%;

			}
			.p{

				font-size: x-small
			}

            .data{
                font-style:normal;
				font-size: 10px;
			    font-family: Arial, Helvetica, sans-serif;
            }

			.cuerpo, .head,.footer,.acceso{
				justify-content:center;
			    align-items:center;
			    text-align: center;
				font-style:normal;
				font-size: 10px;
				font-family: Arial, Helvetica, sans-serif;
			}
           

			.accesos_qr{
				font-style: italic;
				font-size: 10px;
				font-family: Georgia, 'Times New Roman', Times, serif;

			}

			.row_data_qr {
				justify-content:start;
			    align-items:start;
			    text-align: start;
			}

			.accesos_qr{

				justify-content:center;
			    align-items:center;
			    text-align: center;
				background-color: #008083;
			}


			.head,.footer {
				padding:0.5mm;
				background-color: #008083;
				justify-content:start;
				align-items:start;
				text-align: start;
			}
			.acceso{
				background-color: #008001;
				padding:1mm;
			}
			
			.row_data_qr{
                justify-content:start;
				align-items:start;
				text-align: start;
			}
			
			.image-fit,.rounded-full,.imagen_qr{
				justify-content:center;
			    align-items:center;
				text-align: center;
				width:3.6cm;
				hight:1cm;
			}
             
			.row_image_qr,.img{

				justify-content:center;
			    align-items:center;
				text-align: center;
				
			}
            
			
            .interlineado{
				padding:0.1cm;
			}
			
		
			body { margin: 0cm 0cm 0cm 0cm;
					       
			}
			
			
		</style>
	</head>
	<body>
       
        <@foreach ($registros as $item)
        	<div class="content">
                <div class="card">
                    <div class="head">
                        <h3>Credencial Virtual</h3>
                    </div>
                    <div class="interlineado"></div>
                    <div>
                        @if($item->header_image_path)
                                            <div class="image-fit zoom-in h-10 w-10">
                                                <x-base.tippy
                                                    class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                                    src="{{ storage_path('app/public/'. $item->header_image_path) }}"
                                                    alt="{{ $item->evento_name }}"
                                                    as="img"
                                                    content="Subido el {{ $item->created_at }}"
                                                />
                                            </div>
                                        @else
                                            <!-- Imagen predeterminada si no hay imagen -->
                                            <div class="image-fit zoom-in h-10 w-10">
                                                <x-base.tippy
                                                    class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                                    src="{{storage_path('app/public/' .'jamescopaamericaargentina.jpg')}}"
                                                    alt="Default Image"
                                                    as="img"
                                                    content="No image available"
                                                />
                                            </div>
                                        @endif

                    </div>
                    <div class="interlineado"></div>
                    <div class="acceso">
						@if($item->has_entered ==1)
							<h4>Acceso Valido</h4>
						@else
							<h4>Acceso No Permitido</h4>
						@endif
					</div>
                    <div class="cuerpo">
                        <p class="asistente">{{$item->name}} {{$item->lastname}}</p>
                        <p class="asistente">{{$item->document_number}}</p>
                    </div>
                    <div class="interlineado"></div>
                    <div class="accesos_qr">
                        <h4>Accesos</h4>
                    </div>
                    <div class="row_data_qr">
                        <a class="data">. {{$item->localidad}}</a>
                    </div>
                    <div class="row_image_qr">
                        @if($item->qrCode)
                            <div>
                                <div class="mt-5">
                                    {!! $item->qrCode !!}
                                </div>
                            </div>
                        @else
                            <p class="text-center">Este asistente no tiene un código QR asociado.</p>
                        @endif
                    </div>
                    <div class="interlineado"></div>
                    <div class="footer">
                        <h3>Credencial Virtual</h3>
                    </div>
                </div>
		    </div>
        @endforeach
	</body>
</html>