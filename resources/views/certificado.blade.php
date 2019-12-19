<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <title>Certificado</title>
  </head>
  <body>
 
        <div>
          <h1>Declaracion</h1>
          <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('QrCode as PNG image!')) !!} ">

         
        </div>
   
  </body>
</html>