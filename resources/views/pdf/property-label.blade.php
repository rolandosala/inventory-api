<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <style>
        @page {
            margin: 0;
            size: 100mm 60mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #000;
        }

        .label {
            width: 100mm;
            height: 60mm;
            margin: 0;
            padding-left: 8px;
            
        }

        /* HEADER */

        .header {
            width: 100%;
            height: 15mm;
            border-bottom: 0.4mm solid #000;
            margin-top: 10px;
            background-color: none;
        }

        .logo {
            width: 11mm;
            height: 11mm;
            object-fit: contain;
            vertical-align: middle;
        }

        .logo1 {
            width: 30mm;
            height: 30mm;
        }


        .school {
            display: inline-block;
            vertical-align: middle;
            margin-left: 2mm;
        }

        .school-name {
            font-size: 8pt;
        }

        .property-title {
            font-size: 7pt;
            font-weight: bold;
            margin-top: 1mm;
            background-color: none;
        }

        /* BODY */

        .content {
            width: 100%;
            margin-top: -2px;
            margin-left: -5px;
            background-color: none;
        }

        .qr-container {
            width: 36mm;
            /* vertical-align: middle; */
        }

        .qr {
            width: 100px;
            height: 100px;
            background-color: none;
        }

        .details {
            width: 70mm;
            background-color: none;
            margin-left: -100px;
            /* vertical-align: middle; */
            /*  padding-left: 1mm; */
        }

        /* 
        .field {
            margin-bottom: 3mm;
        } */

        .label-name {
            font-size: 8pt;
            font-weight: bold;
        }


        .item {
            font-size: 8pt;
            font-weight: bold;
        }

        .footer {
            border-top: 0.25mm solid #777;
            margin-top: 3mm;
            font-size: 5.5pt;
            text-align: center;
        }
    </style>

</head>

<body>

    <div class="label">

        <!-- HEADER -->

        <div class="header">

            @if($logo)

                <img src="data:image/png;base64,{{ $logo }}" class="logo">

            @endif

            <div class="school">

                <div class="school-name">
                    <div class="text-h6 font-weight-bold"> Southern Leyte State University </div>
                    <div class="text-subtitle-1 "> Tomas Oppus Campus </div>
                    <div class="text-subtitle-1 "> San Isidro, Tomas Oppus, Southern Leyte </div>
                </div>
            </div>

        </div>


        <!-- CONTENT -->
        <div class="">

            <table class="content">

                <tr>

                    <!-- QR -->

                    <td class="qr-container">

                        <div class="qr">

                            @if($qrCode)

                                <img src="data:image/png;base64,{{ $qrCode }}" class="logo1">

                            @endif
                        </div>


                    </td>


                    <!-- DETAILS -->

                    <td class="details">

                        <div class="field">
                            <div class="label-name">
                                PROPERTY INFORMATION
                            </div>
                            <div class="label-name">
                                ASSET TAG : {{ $asset->asset_tag }}
                            </div>
                            <div class="label-name">
                                PROPERTY NO. : {{ $asset->property_number ?? 'N/A' }}
                            </div>
                            <div class="label-name">
                                ITEM : {{ $asset->item_name }}
                            </div>
                            <div class="label-name">
                                COST : {{ $asset->unit_cost }}
                            </div>
                            <div class="label-name">
                                END-USER : {{ $asset->item_name }}
                            </div>
                        </div>

                    </td>

                </tr>

            </table>

        </div>


        <div class="footer">

            Southern Leyte State University • ICT Inventory


        </div>

    </div>

</body>

</html>
