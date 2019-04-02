<?php

return [
    # Define your application mode here
    'mode' => 'sandbox',

    # Account credentials from developer portal
    'account' => [
        'client_id' => env('PAYPAL_CLIENT_ID', 'AUJhC20Z-R2GdritxQQtM2grNZnDPK53guQQDnu24SRuobKqusMu_V6OIParz_19BWCFxzTKY_INYpeD'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET', 'EHqRhWahUDGqs49LuNzV-PbBAeZ_vt7iDk7F_5b6bWFy_LwOQL_fTYAiKIfU7Ptx4NWJoNb7xOcWaR1l'),
    ],

    # Connection Information
    'http' => [
        'connection_time_out' => 30,
        'retry' => 1,
    ],

    # Logging Information
    'log' => [
        'log_enabled' => true,

        # When using a relative path, the log file is created
        # relative to the .php file that is the entry point
        # for this request. You can also provide an absolute
        # path here
        'file_name' => '../PayPal.log',

        # Logging level can be one of FINE, INFO, WARN or ERROR
        # Logging is most verbose in the 'FINE' level and
        # decreases as you proceed towards ERROR
        'log_level' => 'FINE',
    ],
];
