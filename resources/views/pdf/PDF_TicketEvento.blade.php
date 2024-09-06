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


			.head,.footer{
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
			
			.imagen_evento,.imagen_qr{
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
		<div class="content">
			<div class="card">
				<div class="head">
					<h3>Credencial Virtual</h3>
				</div>
				<div class="interlineado"></div>
				<div>
					<img class="imagen_evento" src="{{storage_path('app/public/' .'jamescopaamericaargentina.jpg')}}" alt=""></div>
				</div>
				<div class="interlineado"></div>
				<div class="acceso">
					<h4>Acceso Valido</h4>
				</div>
				<div class="cuerpo">
					<p class="asistente">{{$user->name}} {{$user->lastname}}</p>
					<p class="asistente">{{$user->document_number}}</p>
				</div>
				<div class="interlineado"></div>
				<div class="accesos_qr">
					<h4>Accesos</h4>
				</div>
				<div class="row_data_qr">
					<a class="data">General</a>
				</div>
				<div class="row_image_qr">
						<img class="imagen_qr" src="{{storage_path('app/public/' .'sample-qr-code-icon.png')}}" alt="">
				</div>
				<div class="interlineado"></div>
				<div class="footer">
					<h3>Credencial Virtual</h3>
				</div>
			</div>
		</div>
	</body>
</html>