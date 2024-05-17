## Reto Placetopay

### Problema:
Los datos de geolocalización asociados a la transacción en el transcurso del tiempo pueden cambiar, actualmente se consulta cada vez que se necesita, esto deriva en que una transacción creada en Enero refleje en Enero unos datos de geolocalización, y esa misma transacción visualizada unos meses después refleje otros datos

### Objetivo:
- Los datos de geolocalización se deben persistir
- Los datos de geolocalización correspondientes al 2024 se actualizaran de forma masiva
- Los datos de geolocalización anteriores al 2024 se actualizarán por demanda: cuándo se visualice el registro en el panel, estas transacciones se deben diferenciar alertando al usuario de que la información puede no coincidir por la antigüedad de la misma

### Contexto:
- Aplicación escrita en PHP 8.2 usando Laravel 10 y Vue 3
- La aplicación procesa 50.000 transacciones diarias
- Actualmente la aplicación tiene en base de datos 90 millones de transacciones
- Las transacciones (table: transactions) tienen relacionados mensajes (table: transaction_messages) en una relación 1 a N, uno de estos mensajes es de tipo (field: message_type) aReq el cual contiene una IP (attribute: browserIP) que es opcional, a partir de esa IP se consulta un servicio (class IPLocationContract)  para obtener los datos de geolocalización cada vez que se visualiza la transacción (route transactions.show) en el panel administrativo de forma asincrona (route: api.ip.location)
- El servicio de consulta de IP es un archivo local dispuesto en un EFS de aproximadamente 50mb y es actualizado cada 15 días de forma automática con la información más recientes de los ISP

### Dinamica

#### A partir de este momento:
- Eres revisor/a del Pull Request/Code Review)
- Tienes 10 minutos desde el momento de ser compartido el archivo PDF
- Verbalizar los pensamientos que consideres relevantes (correcciones, mejoras,  sugerencias)

#### El ejercicio termina:
- Al dejar de compartir pantalla
- Al perder la conexión a Internet
- Al completarse o superar el tiempo máximo
- Preguntas?