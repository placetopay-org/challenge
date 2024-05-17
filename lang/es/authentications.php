<?php

use App\FraudControl\Constants\DAFActions;
use App\ThreeDS\Services\Helpers\OutOfBandServiceTracer;
use App\ThreeDS\Services\Helpers\QuestionnaireServiceTracer;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageType;
use PlacetoPay\ThreeDsSecureBase\Constants\Versions\V220\TransactionStatus;

return [
    'titles' => [
        'index' => 'Autenticaciones',
        'decoupled_authentications' => 'Autenticaciones desacopladas',
        'unselected_decoupled_authentications' => 'Autenticaciones no seleccionadas',
        'workspace_decoupled_authentications' => 'Mis autenticaciones',
        'processing_decoupled_authentications' => 'Autenticaciones seleccionadas por otros usuarios',
        'messages' => 'Mensajes de autenticación',
        'traces' => 'Trazas de la autenticación',
        'export' => 'Reporte de la autenticación',
        'indicators' => 'Indicadores de la autenticación',
        'data' => 'Datos del mensaje',
    ],
    'invalid_range' => 'La diferencia de días para el rango de fechas no debe exceder los :number días',
    'statuses' => [
        TransactionStatus::SUCCESSFUL => [
            'label' => '[Y] Autenticado',
            'description' => 'Autenticación de verificación correcta.',
        ],
        TransactionStatus::NOT_AUTHENTICATED => [
            'label' => '[N] No Autenticado',
            'description' => 'No autenticado/Cuenta no verificada; Transacción denegada.',
        ],
        TransactionStatus::COULD_NOT_BE_PERFORMED => [
            'label' => '[U] No Realizado',
            'description' => 'Autenticación/Verificación de la cuenta no pudo ser realizado; Problema técnico u otro problema, como indicado en ARes o RReq.',
        ],
        TransactionStatus::ATTEMPTS_PROCESSING_PERFORMED => [
            'label' => '[A] Intento',
            'description' => 'Intentos de procesamiento realizado; No autenticado/verificado, pero se proporciona una prueba de intento de autenticación/verificación.',
        ],
        TransactionStatus::CHALLENGE_REQUIRED => [
            'label' => '[C] Desafio',
            'description' => 'Desafío necesario; Autenticación adicional es requerida usando el CReq/CRes.',
        ],
        TransactionStatus::CHALLENGE_REQUIRED_DECOUPLE => [
            'label' => '[D] Desacoplado',
            'description' => 'Autenticación desacoplada confirmada.',
        ],
        TransactionStatus::REJECTED => [
            'label' => '[R] Rechazada',
            'description' => 'Autenticación/Verificación de la cuenta rechazado; El emisor está rechazando la autenticación/verificación y solicita que la autorización no sea intentada.',
        ],
        TransactionStatus::INFORMATION_ONLY => [
            'label' => '[I] Informativa',
            'description' => 'Solo informativo; Preferencia de desafío del solicitante 3DS reconocido.',
        ],
    ],
    'acct_info' => [
        'ch_acc_age_ind' => [
            '01' => 'Sin cuenta (ingreso como invitado)',
            '02' => 'Se creo durante esta transacción',
            '03' => 'Menos de 30 días',
            '04' => '30−60 días',
            '05' => 'Más de 60 días',
        ],
        'ch_acc_change_ind' => [
            '01' => 'Cambió durante esta transacción',
            '02' => 'Menos de 30 días',
            '03' => '30−60 días',
            '04' => 'Más de 60 días',
        ],
        'ch_acc_pw_change_ind' => [
            '01' => 'No cambió',
            '02' => 'Cambió durante esta transacción',
            '03' => 'Menos de 30 días',
            '04' => '30−60 días',
            '05' => 'Más de 60 días',
        ],
        'payment_acc_ind' => [
            '01' => 'Sin cuenta (ingreso como invitado)',
            '02' => 'Durante la transacción',
            '03' => 'Menos de 30 días',
            '04' => '30−60 días',
            '05' => 'Más de 60 días',
        ],
        'ship_address_usage_ind' => [
            '01' => 'Esta transacción',
            '02' => 'Menos de 30 días',
            '03' => '30−60 días',
            '04' => 'Más de 60 días',
        ],
        'ship_name_indicator' => [
            '01' => 'Nombre de cuenta idéntica al nombre del envío',
            '02' => 'Nombre de cuenta diferente al nombre de envío',
        ],
        'suspicious_acc_activity' => [
            '01' => 'No se ha observado actividad sospechosa',
            '02' => 'Se ha observado actividad sospechosa',
        ],
    ],
    'no_authentication_found' => 'No se encontraron autenticaciones',
    'risks' => [
        App\FraudControl\Constants\RiskScores::LOW => 'Riesgo bajo',
        App\FraudControl\Constants\RiskScores::MEDIUM => 'Riesgo medio',
        App\FraudControl\Constants\RiskScores::HIGH => 'Riesgo alto',
    ],
    'component' => [
        'error' => 'Error generado por: <strong>:causer</strong>',
        'C' => '3DS SDK',
        'S' => '3DS Server',
        'D' => 'Servidor de directorio',
        'A' => 'ACS',
    ],
    'messages' => [
        'resolve' => 'La autenticación se resolvio de manera exitosa.',
        'not_resolve' => 'La autenticación ya no se encuentra en estado desacoplada.',
        'in_process' => 'La autenticación se está resolviendo por otro usuario.',
        'expiration' => 'Ha superado el tiempo máximo para resolver esta autenticación.',
        'no_information_provided' => 'No se proporcionó información de la cuenta del titular de la tarjeta.',
        'free_transaction' => 'La transacción se liberó de manera satisfactoria.',
        'type' => 'Tipo de mensaje',
        MessageType::AREQ => [
            'description' => 'Se inicia flujo de autenticación.',
        ],
        MessageType::ARES => [
            'description' => 'Respuesta a la solicitud de autenticación (AReq)',
        ],
        MessageType::RREQ => [
            'description' => 'Se comunican los resultados de la autenticación.',
        ],
        MessageType::RRES => [
            'description' => '3DS server envia una mensaje indicando que se recibió la solicitud de respuesta (RReq).',
        ],
        MessageType::CREQ => [
            'description' => 'Inicia la interacción del titular de la tarjeta en un flujo de desafío.',
        ],
        MessageType::CRES => [
            'description' => 'Respuesta a la solicitud del desafío (CReq).',
        ],
        'export' => [
            'note' => 'Este documento ha sido generado de forma automática por <strong>:name</strong>, si requiere información adicional por favor comunícate con nosotros a través de los siguientes contactos: ',
            'email' => '<strong>Correo electrónico: </strong>:email',
            'phone' => '<strong>Teléfonos: </strong>:phone',
            'hidden_field' => 'Contenido oculto',
        ],
    ],
    'traces' => [
        'titles' => [
            'authorization' => 'Trazas del servicio de autorización OAuth',
            'cardholder' => 'Trazas del servicio para titulares de tarjetas',
            'sms_diners' => 'Trazas del servicio de mensajería de Diners',
            'sms_core' => 'Trazas del servicio de mensajería Core API',
            'questionnaire' => 'Trazas del servicio de cuestionario',
            'out_of_band' => 'Trazas del servicio fuera de banda (OOB)',
        ],
        'authorization' => [
            'request' => 'Se realizó una solicitud al servicio',
            'response' => 'Respuesta a la solicitud del servicio',
            'error' => 'Error en el servicio de autorización OAuth',
        ],
        'cardholder' => [
            'request' => 'Se realizó una solicitud al servicio',
            'response' => 'Respuesta a la solicitud del servicio',
            'error' => 'Error en el servicio de titulares de tarjetas',
        ],
        'brands' => [
            'types' => [
                'daf' => 'Marco de autenticación digital de Visa (DAF)',
                'mastercard_ds_logic' => 'Mastercard transacciones 3RI',
            ],
            'daf' => [
                'actions' => [
                    'label' => [
                        DAFActions::APPROVE => 'Aprobar',
                        DAFActions::AUTHENTICATE => 'Autenticar por desafío',
                        DAFActions::DECIDE => 'El emisor tomará la decisión',
                        DAFActions::DENY => 'Denegar',
                        DAFActions::ISSUER_DENY => 'Decisión del emisor',
                    ],
                    'description' => [
                        DAFActions::APPROVE => 'El titular de la tarjeta está actuando como credencial de pago '
                            . 'autenticada con bajo riesgo, la autenticación será aprobada.',
                        DAFActions::AUTHENTICATE => 'El titular de la tarjeta actúa como una credencial de pago no '
                            . 'autenticada, se realizará un desafío de verificación, si el desafío se completa '
                            . 'satisfactoriamente, el titular de la tarjeta será dado de alta en DAF.',
                        DAFActions::DECIDE => 'El titular de la tarjeta actúa como una credencial de pago autenticada '
                            . 'pero la transacción es de medio-alto riesgo, se ejecutarán las listas y reglas de '
                            . 'control de fraude, no se permitirá la realización de desafíos.',
                        DAFActions::DENY => 'El estado actual del titular de la tarjeta es bloqueado, inválido o '
                            . 'desconocido, por lo cual se deniega la autenticación.',
                        DAFActions::ISSUER_DENY => 'Debido a que los desafíos están prohibidos para las credenciales '
                            . 'de pago autenticadas en DAF, esta transacción no fue autenticada',
                    ],
                ],
            ],
            'mastercard_ds_logic' => [
                'label' => 'Desafio desacoplado',
                'description' => 'Se debe autenticar a través de un desafío desacoplado las transacciones 3RI con los '
                    . 'indicadores 03 (Agregar tarjeta), 04 (Mantener información de la tarjeta) o 05 '
                    . '(Verificar cuenta)',
            ],
        ],
    ],
    'services' => [
        'otp_strategy' => [
            'diners' => [
                'validate' => [
                    'request' => 'El OTP fue enviado para ser validado por el servicio de Diners',
                    'response' => 'El OTP fue validado por el servicio de Diners exitosamente',
                    'error' => 'Se produjo un error durante la validación de OTP',
                    'codes' => [
                        '0' => 'OTP validado con éxito',
                        '1' => 'El OTP no pudo ser validado (mock)',
                        '56' => 'El OTP ingresado no coincide con el que se te ha provisto.',
                        '57' => 'El OTP de la cuenta se encuentra bloqueado',
                        '58' => 'El OTP no contiene el código de validación',
                        '61' => 'EL OTP ha expirado, se generará uno nuevo automaticamente, comprueba tu dispositivo',
                        '67' => 'EL OTP se ha ruteado al proveedor',
                        '0099' => 'Error del sistema de validación de OTP, por favor intente más tarde',
                        '903' => 'No se ha generado un OTP para la transacción debido a un error técnico',
                        '99' => 'Ha ocurrido un error al validar el OTP para la transacción',
                        '98' => 'Ha ocurrido un error al validar el OTP para la transacción',
                    ],
                ],
                'send' => [
                    'request' => 'El OTP fue solicitado al servicio de Diners',
                    'response' => 'El OTP fue recibido del servicio de Diners',
                    'error' => 'Se produjo un error al enviar OTP',
                    'codes' => [
                        '0' => 'Respuesta exítosa',
                        '903' => 'No se ha generado un OTP para la transacción debido a un error técnico',
                        '99' => 'No se ha generado un OTP para la transacción debido a un error técnico',
                        '9999' => 'No se generó una OTP para la transacción debido a un error con la tarjeta',
                    ],
                ],
            ],
            'core' => [
                'request' => 'Se solicitó el envío del OTP al servicio de mensajes Core API.',
                'response' => 'El OTP fue enviado satisfactoriamente por el servicio de mensajes Core API.',
                'error' => 'Se produjo un error al enviar OTP',
            ],
        ],
        'cardholder_strategy' => [
            'standard' => [
                'description' => 'La petición para información del cardholder se ha realizado desde el servicio estandar con autenticación',
            ],
            'standard_no_auth' => [
                'description' => 'La petición para información del cardholder se ha realizado desde el servicio estandar sin autenticación',
            ],
        ],
        'questionnaire' => [
            QuestionnaireServiceTracer::GET_QUESTIONNAIRE => [
                'request' => 'Una petición fue enviada para obtener el cuestionario.',
                'response' => 'Un cuestionario fue recibido del servicio.',
                'error' => 'Ocurrió un error mientras se obtenía el cuestionario.',
            ],
            QuestionnaireServiceTracer::VERIFY_ANSWERS => [
                'request' => 'Una petición fue enviada para verificar las respuestas del cuestionario.',
                'response' => [
                    'passed' => 'Las respuestas del cuestionario pasaron la verificación.',
                    'didnt_pass' => 'Las respuestas del cuestionario no pasaron la verificación.',
                ],
                'error' => 'Ocurrió un error mientras se verificaban las respuestas del cuestionario.',
            ],
            QuestionnaireServiceTracer::GET_ANSWERS => [
                'request' => 'Una petición fue enviada para obtener las respuestas del cuestionario.',
                'response' => 'Las respuestas del cuestionario fueron recibidas del servicio.',
                'error' => 'Ocurrió un error mientras se obtenian las respuestas del cuestionario.',
            ],
        ],
        'out_of_band' => [
            OutOfBandServiceTracer::CREATE_SESSION => [
                'request' => 'Una petición fue enviada para crear una sesión.',
                'response' => 'La sesión fue creada satisfactoriamente.',
                'error' => 'Ocurrió un error mientras se creaba la sesión.',
            ],
            OutOfBandServiceTracer::VERIFY_SESSION => [
                'request' => 'Una petición fue enviada para verificar la sesión.',
                'response' => [
                    'passed' => 'La sesión pasó la verificación.',
                    'didnt_pass' => 'La sesión no pasó la verificación.',
                ],
                'error' => 'Ocurrió un error mientras se verificaba la sesión.',
            ],
        ],
        'status' => [
            'failed' => 'Falló',
            'successful' => 'Exitoso',
            'not_recognised' => 'No reconocido',
            'rules_not_found' => 'Reglas no encontradas',
            'unauthenticated' => 'No autenticado',
            'wrong_format_headers' => 'Cabeceras con formato incorrecto',
            'wrong_authentication_headers' => 'Cabeceras de autenticación incorrectas',
            'required_data_element_missing' => 'Faltan datos requeridos',
            'format_of_elements_is_invalid' => 'Formato de datos inválido',
        ],
    ],
    'flows' => [
        'friction' => 'Con fricción',
        'frictionless' => 'Sin Fricción',
        'label' => 'Flujo',
    ],
    'trans_type' => [
        'label' => 'Tipo de transacción',
    ],
    'eci' => [
        'label' => 'eci',
    ],
    'authentication_type' => [
        'label' => 'Tipo de autenticación',
    ],
    'authentication_method' => [
        'label' => 'Método de autentificación',
    ],
    'trans_status_reason' => [
        'label' => 'Motivo del estado de la transacción',
    ],
    'frequency' => 'Autenticación por :frequency|Autenticaciones por :frequency',
    'message' => [
        'merchant_name' => 'Nombre del comerciante:',
        'mcc' => 'Código de categoría de comerciante:',
        'merchant_id' => 'Identificación del comerciante:',
    ],
    'challenge_statuses' => [
        'not_accepted' => 'El tarjetahabiente no aceptó el desafío',
        'canceled' => 'El tarjetahabiente canceló el desafío',
        'failed' => 'El tarjetahabiente falló en el desafío',
        'abandoned' => 'El tarjetahabiente abandonó el desafío',
        'passed' => 'El tarjetahabiente pasó el desafío',
        'in_progress' => 'El desafío está en ejecución',
    ],
    'fields' => [
        'acs_trans_id' => 'ID de transacción de ACS',
        'date' => 'Creada en',
    ],
    'identifiers_fields' => [
        'acs_trans_id' => 'ID de transacción de ACS',
        'ds_trans_id' => 'ID de transacción del DS',
        'threeds_server_trans_id' => 'ID de transacción del servidor 3DS',
        'sdk_trans_id' => 'ID de transacción del SDK',
        'authentication_value' => 'Valor de autenticación',
    ],
    'methods' => [
        'text' => 'Código de acceso de un solo uso',
        'oob' => 'Fuera de banda',
        'single_select' => 'Cuestionario de selección única',
        'multi_select' => 'Cuestionario de selección múltiple',
    ],
    'cavv' => [
        'default' => 'Algoritmo por defecto de la marca',
        'mastercard' => [
            'default' => 'Mastercard usando el número de la tarjeta e identificador de transacción '
                . 'del Servidor de Directorio',
            'ds' => 'Mastercard usando el identificador de transacción del Servidor de Directorio',
        ],
    ],
    'key_indicators' => [
        'one' => 'Indicador No. 01',
        'two' => 'Indicador No. 02',
        'three' => 'Indicador No. 03',
        'four' => 'Indicador No. 04',
        'five' => 'Indicador No. 05',
        'six' => 'Indicador No. 06',
        'seven' => 'Indicador No. 07',
        'eight' => 'Indicador No. 08',
    ],
];
